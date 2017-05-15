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
({events:{'click [data-action=shortcuts]':'shortcuts','click [data-action=tour]':'showTutorialClick','click [data-action=feedback]':'feedback','click [data-action=support]':'support','click [data-action=help]':'help'},tagName:'span',layoutName:'',watchingForDashboard:false,helpBtnDisabledLayouts:['about','first-login-wizard'],handleViewChange:function(layout,params){var module=params&&params.module?params.module:null;this.layoutName=_.isObject(layout)?layout.name:layout;this.disableHelpButton(true);if(app.tutorial.hasTutorial(this.layoutName,module)){this.enableTourButton();if(params.module==='Home'&&params.layout==='record'&&params.action==='detail'){var serverInfo=app.metadata.getServerInfo(),currentKeyValue=serverInfo.build+'-'+serverInfo.flavor+'-'+serverInfo.version,lastStateKey=app.user.lastState.key('toggle-show-tutorial',this),lastKeyValue=app.user.lastState.get(lastStateKey);if(currentKeyValue!==lastKeyValue){app.user.lastState.set(lastStateKey,currentKeyValue);this.showTutorial({showTooltip:true});}}}else{this.disableTourButton();}},handleRouteChange:function(route,params){this.routeParams={'route':route,'params':params};},enableTourButton:function(){this.$('[data-action=tour]').removeClass('disabled');this.events['click [data-action=tour]']='showTutorialClick';this.undelegateEvents();this.delegateEvents();},disableTourButton:function(){this.$('[data-action=tour]').addClass('disabled');delete this.events['click [data-action=tour]'];this.undelegateEvents();this.delegateEvents();},initialize:function(options){app.view.View.prototype.initialize.call(this,options);app.events.on('app:view:change',this.handleViewChange,this);var self=this;app.utils.doWhen(function(){return!_.isUndefined(app.router);},function(){self.listenTo(app.router,'route',self.handleRouteChange);});app.events.on('app:help',function(){this.help();},this);app.events.on('app:help:shown',function(){this.toggleHelpButton(true);this.disableHelpButton(false);},this);app.events.on('app:help:hidden',function(){this.toggleHelpButton(false);this.disableHelpButton(true);},this);app.events.on('alert:cancel:clicked',function(){this.disableHelpButton(this.shouldHelpBeDisabled());},this);this._watchForDashboard();app.shortcuts.register(app.shortcuts.GLOBAL+'Help','?',this.shortcuts,this);app.user.lastState.preserve(app.user.lastState.key('toggle-show-tutorial',this));this.before('render',function(){if(this._feedbackView){this._feedbackView.dispose();}},this);},_watchForDashboard:function(){if(this.watchingForDashboard===false){this.watchingForDashboard=true;app.utils.doWhen(function(){var layout=app.controller.layout;if(!_.isUndefined(layout)){if(layout.module=='Home'||layout.name==='bwc'){return true;}else{var sidebar=layout.getComponent('sidebar');if(sidebar){var dashboard=sidebar.getComponent('dashboard-pane');if(dashboard){return(dashboard.$('.dashlets').length>0||dashboard.$('.container-fluid').length==1);}}}}
return false;},_.bind(function(){this.watchingForDashboard=false;this.disableHelpButton(false);},this));}},shouldHelpBeDisabled:function(){return(_.indexOf(this.helpBtnDisabledLayouts,this.layoutName)!==-1);},_renderHtml:function(){this.isAuthenticated=app.api.isAuthenticated();this.isShortcutsEnabled=(this.isAuthenticated&&app.shortcuts.isEnabled());app.view.View.prototype._renderHtml.call(this);},feedback:function(evt){if(!app.isSynced){return;}
if(!this._feedbackView||this._feedbackView.disposed){this._feedbackView=app.view.createView({module:'Feedbacks',name:'feedback',button:this.$('[data-action="feedback"]')});this.listenTo(this._feedbackView,'show hide',function(view,active){this.$('[data-action="feedback"]').toggleClass('active',active);});}
this._feedbackView.toggle();},support:function(){window.open('http://support.sugarcrm.com','_blank');},help:function(event){if(this.layoutName==='bwc'||this.layoutName==='about'){this.bwcHelpClicked();return;}
var button=this.$('[data-action="help"]');var buttonDisabled=button.hasClass('disabled');var buttonAppEvent=button.hasClass('active')?'app:help:hide':'app:help:show';if(!buttonDisabled){button.addClass('disabled');app.events.trigger(buttonAppEvent);}},disableHelpButton:function(disable){disable=_.isUndefined(disable)?true:disable;var button=this.$('[data-action=help]');if(button){button.toggleClass('disabled',disable);}
if(disable){this._watchForDashboard();}
return disable;},toggleHelpButton:function(active,button){if(_.isUndefined(button)){button=this.$('[data-action=help]');}
if(button){button.toggleClass('active',active);}},shortcuts:function(event){var activeDrawerLayout=app.drawer.getActive(),$shortcutButton=this.$('[data-action=shortcuts]');if(!activeDrawerLayout||activeDrawerLayout.type!=='shortcuts'){$shortcutButton.addClass('active');app.drawer.open({layout:'shortcuts'},function(){$shortcutButton.removeClass('active');});}else{app.drawer.close();}},showTutorialClick:function(e){if(!app.tutorial.instance){this.showTutorial();e.currentTarget.blur();}},showTutorial:function(prefs){app.tutorial.resetPrefs(prefs);app.tutorial.show(app.controller.context.get('layout'),{module:app.controller.context.get('module')});},bwcHelpClicked:function(){var serverInfo=app.metadata.getServerInfo(),lang=app.lang.getLanguage(),module=app.controller.context.get('module'),route=this.routeParams.route,url='http://www.sugarcrm.com/crm/product_doc.php?edition='+serverInfo.flavor+'&version='+serverInfo.version+'&lang='+lang+'&module='+module+'&route='+route;if(route=='bwc'){var action=window.location.hash.match(/#bwc.*action=(\w*)/i);if(action&&!_.isUndefined(action[1])){url+='&action='+action[1];}}
app.logger.info("help URL: "+url);window.open(url);}})