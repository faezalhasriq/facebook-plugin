({

    extendsFrom: 'HeaderpaneView',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.module = 'Cases';
        this.title = app.lang.get('LBL_FACEBOOK_DASHLET_CONFIG_TITLE', this.module);

        this.context.on('cases:settings:close', function () {
            app.router.goBack();
        });

        this.context.on('cases:settings:save', function () {
            this.context.trigger('cases:settings:config-content:save');
        }, this);
    }
})
