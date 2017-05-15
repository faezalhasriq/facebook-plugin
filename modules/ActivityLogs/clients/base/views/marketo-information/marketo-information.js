/*
 * Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
 * pursuant to the terms of the End User License Agreement available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
 */
({
    className: 'row-fluid',

    loadData: function (options) {
        var responseData = {'sync': null, 'activity': null, 'errmsg': null};

        app.api.call('read', app.api.buildURL('/connector/marketo/status'), {}, {
            success: _.bind(function (data) {
                responseData.sync = data;
            }, this),
            error: _.bind(function (data) {
                responseData.errmsg = data.message;
            }, this),
            complete: _.bind(function () {
                this.data = responseData;
                this.render();
            }, this)
        });

        app.api.call('read', app.api.buildURL('/connector/marketo/status/activity'), {}, {
            success: _.bind(function (data) {
                responseData.activity = data;
            }, this),
            error: _.bind(function (data) {
                responseData.errmsg = data.message;
            }, this),
            complete: _.bind(function () {
                this.data = responseData;
                this.render();
            }, this)
        });

        this.data = responseData;
        this.render();
    }
})
