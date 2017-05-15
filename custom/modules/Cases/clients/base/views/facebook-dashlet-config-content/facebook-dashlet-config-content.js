/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    loading: false,
    initialize: function (options) {
        this._super("initialize", [options]);
        this.context.on('cases:settings:config-content:save', this.saveConfig, this);
        this.configModel = new app.data.beanModel();

        this.configModel.on('change:fb_license_type', function (model) {
            if (!this.loading) {
                this.render();
            }
        }, this);

    },
    _render: function () {
        this._super('_render');
    },
    
    loadData: function () {
        this.loading = true;
        app.api.call('read', app.api.buildURL(this.module, 'config'), {}, {
            success: _.bind(function (data) {
                if (!_.isEmpty(data)) {
                    _.each(data, function (value, key) {
                        this.configModel.set(key, value);
                    }, this);
                }
                this.loading = false;
                this.render();
            }, this),
            error: _.bind(function (error) {
                console.log(error);
            }, this)});
    },

    /**
     * Save changes to config parameters
     */
    saveConfig: function () {
        var data = {};

        var fields = {};
        switch (this.configModel.get('fb_license_type')) {
            case 'addoptify':
                fields = this.meta.addoptify_fields;
                break;
            case 'outfitters':
                fields = this.meta.outfitters_fields;
                break;
        }

        _.each(fields, function (def) {
            data[def.name] = this.configModel.get(def.name);
        }, this);

        data['fb_license_type'] = this.configModel.get('fb_license_type');
        data['fb_page_name'] = this.configModel.get('fb_page_name');
        data['fb_app_id'] = this.configModel.get('fb_app_id');
        data['fb_log_level'] = this.configModel.get('fb_log_level');

        app.alert.show('cases:settings:save', {
            level: 'process',
            title: app.lang.getAppString('LBL_LOADING')
        });

        var url = app.api.buildURL(this.module, 'config');

        app.api.call('update', url, data, {
            success: _.bind(function (result) {
                app.alert.dismiss('cases:settings:save');

                app.alert.show('cases:settings:save', {
                    level: 'success',
                    title: app.lang.getAppString('LBL_SUCCESS'),
                    messages: 'All settings saved.',
                    autoClose: true
                });

                app.router.goBack();
            }, this),
            error: _.bind(function (error) {
                console.log(error);
            }, this),
            complete: _.bind(function (data) {
                app.alert.dismiss('cases:settings:save');
            }, this)
        });
    }
})
