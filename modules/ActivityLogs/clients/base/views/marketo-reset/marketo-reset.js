/*
 * Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
 * pursuant to the terms of the End User License Agreement available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
 */
({
    events: {
        'click a[name="cancel_button"]': 'onButtonClicked',
        'click a[name="save_button"]': 'onButtonClicked'
    },
    onButtonClicked: function (evt) {
        // since the next line is so long, passing it to a variable
        // so it isnt just messily tossed into the switch
        var btnName = $(evt.target).attr('name').slice(0, -7);
        switch (btnName) {
            case 'cancel':
                this.cancelConfig();
                break;
            case 'save':
                this.saveConfig();
                break;
        }
    },

    saveConfig: function () {
        app.api.call('update', app.api.buildURL('/connector/marketo/reset'), {}, {
            success: _.bind(function (data) {
                console.log(data);
                this.showSavedConfirmation(function () {
                    window.location = '#Administration';
                    window.location.reload();
                });
            }, this),
            error: _.bind(function (data) {
            }, this),
            complete: _.bind(function () {
            }, this)
        });
    },

    /**
     * Cancels the config setup process and redirects back
     */
    cancelConfig: function () {
        app.router.goBack();
    },
    /**
     * show the saved confirmation alert
     * @param {Object|Undefined} [onClose] the function fired upon closing.
     */
    showSavedConfirmation: function (onClose) {
        onClose = onClose || function () {
        };
        var alert = app.alert.show('activity_log_success', {
            level: 'success',
            title: app.lang.get('LBL_MARKETO_CONFIG_TITLE_SETTINGS', 'ActivityLogs') + ':',
            messages: app.lang.get('LBL_MARKETO_CONFIG_SETTINGS_SAVED', 'ActivityLogs'),
            autoClose: true,
            onAutoClose: _.bind(function () {
                alert.getCloseSelector().off();
                onClose();
            })
        });
        var $close = alert.getCloseSelector();
        $close.on('click', onClose);
        app.accessibility.run($close, 'click');
    }

})
