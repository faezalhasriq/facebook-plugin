/*
 * Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
 * pursuant to the terms of the End User License Agreement available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
 */
({
    className: 'row-fluid',

    loadData: function (options) {
        var responseData = {'results': null, 'errmsg': null, 'httpCode': null};

        app.api.call('read', app.api.buildURL('connector/marketo/schema', null, null, {objectName: 'LeadRecord'}), {}, {
            success: _.bind(function (data) {
                if (data.error)
                    responseData.errmsg = data.error;
                else
                    responseData.results = data;
            }, this),
            error: _.bind(function (data) {
                responseData.errmsg = data.message;
                responseData.httpCode = data.status;
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
