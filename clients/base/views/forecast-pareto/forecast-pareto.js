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
({plugins:['Dashlet','Tooltip'],className:'forecasts-chart-wrapper',displayTimeperiodPivot:true,isManager:false,isTopLevelManager:false,validChangedFields:['amount','likely_case','best_case','worst_case','assigned_user_id','date_closed','date_closed_timestamp','probability','commit_stage','sales_stage'],initOptions:null,forecastsNotSetUpMsg:undefined,forecastConfig:undefined,opportunitiesWithRevenueLineItems:false,initialize:function(options){this.isManager=app.user.get('is_manager');this._initPlugins();if(this.isManager){this.isTopLevelManager=app.user.get('is_top_level_manager');}
this.initOptions=options;this.forecastConfig=app.metadata.getModule('Forecasts','config');this.isForecastSetup=this.forecastConfig.is_setup;this.forecastsConfigOK=app.utils.checkForecastConfig();var oppConfig=app.metadata.getModule('Opportunities','config');if(oppConfig&&oppConfig['opps_view_by']==='RevenueLineItems'){this.opportunitiesWithRevenueLineItems=true;}else{this.opportunitiesWithRevenueLineItems=false;}
if(this.isForecastSetup&&this.forecastsConfigOK){this.initOptions.meta.template=undefined;if(!options.meta.config){app.api.call('GET',app.api.buildURL('Forecasts/init'),null,{success:_.bind(this.forecastInitCallback,this),complete:this.initOptions?this.initOptions.complete:null});}
this.displayTimeperiodPivot=(options.context.get('module')==='Home');}else{this.initOptions.meta.template='forecast-pareto.no-access';var isAdmin=_.isUndefined(app.user.getAcls()['Forecasts'].admin);this.forecastsNotSetUpMsg=app.utils.getForecastNotSetUpMessage(isAdmin);}
this._super('initialize',[this.initOptions]);},getLabel:function(){return app.lang.get(this.meta.label);},initDashlet:function(){if(!this.isManager&&this.meta.config){this.meta.panels=_.chain(this.meta.panels).filter(function(panel){panel.fields=_.without(panel.fields,_.findWhere(panel.fields,{name:'visibility'}));return panel;}).value();}
if(this.isForecastSetup&&this.forecastsConfigOK){this.settings.module='Forecasts';}
var fieldOptions=app.lang.getAppListStrings(this.dashletConfig.dataset.options),cfg=app.metadata.getModule('Forecasts','config');this.dashletConfig.dataset.options={};if(cfg.show_worksheet_worst&&app.acl.hasAccess('view','ForecastWorksheets',app.user.get('id'),'worst_case')){this.dashletConfig.dataset.options['worst']=fieldOptions['worst'];}
if(cfg.show_worksheet_likely){this.dashletConfig.dataset.options['likely']=fieldOptions['likely'];}
if(cfg.show_worksheet_best&&app.acl.hasAccess('view','ForecastWorksheets',app.user.get('id'),'best_case')){this.dashletConfig.dataset.options['best']=fieldOptions['best'];}
this.dashletConfig.show_dataset=true;if(_.size(this.dashletConfig.dataset.options)<=1){this.dashletConfig.show_dataset=false;}},forecastInitCallback:function(initData){if(this.disposed){return;}
var defaultOptions={user_id:app.user.get('id'),display_manager:this.isDisplayManager(),show_target_quota:(this.isManager&&!this.isTopLevelManager),selectedTimePeriod:initData.defaultSelections.timeperiod_id.id,timeperiod_id:initData.defaultSelections.timeperiod_id.id,timeperiod_label:initData.defaultSelections.timeperiod_id.label,dataset:initData.defaultSelections.dataset,group_by:initData.defaultSelections.group_by,ranges:_.keys(app.lang.getAppListStrings(this.forecastConfig.buckets_dom))};var model=this._getNonForecastModel();if(model&&!this.displayTimeperiodPivot&&model.has('date_closed_timestamp')&&model.get('date_closed_timestamp')!=0){defaultOptions.timeperiod_id=model.get('date_closed_timestamp');}else{this.layout.setTitle(this.getLabel()+' '+defaultOptions.timeperiod_label);}
this.settings.set(defaultOptions);},loadData:function(options){if(options&&_.isFunction(options.complete)){options.complete();}},_render:function(){this.settings.set('display_manager',this.isDisplayManager());this.spanSize=this.displayTimeperiodPivot&&this.dashletConfig.show_dataset?'span4':'span6';this._super('_render');var chartField=this.getField('paretoChart');if(!_.isUndefined(chartField)){chartField.renderChart();chartField.once('chart:pareto:rendered',function(){this.addRowToChart();},this);}},toggleRepOptionsVisibility:function(){var mgrToggleOffset;if(this.settings.get('display_manager')===true){mgrToggleOffset=6;this.$el.find('div.groupByOptions').addClass('hide');}else{mgrToggleOffset=3;this.$el.find('div.groupByOptions').removeClass('hide');}
if(this.displayTimeperiodPivot){mgrToggleOffset=mgrToggleOffset-3;}
if(this.isManager){var el=this.$el.find('#'+this.cid+'-mgr-toggle');if(el.length>0){var classes=el.attr('class').split(' ').filter(function(item){return item.indexOf('offset')===-1?item:'';});if(mgrToggleOffset!=0){classes.push('offset'+mgrToggleOffset);}
el.attr('class',classes.join(' '));}}},visibilitySwitcher:function(event){this.settings.set({display_manager:this.isDisplayManager(),show_target_quota:(this.isDisplayManager()&&!this.isTopLevelManager)});},isDisplayManager:function(){return this.isManager?(this.getVisibility()==='group'):false;},bindDataChange:function(){var meta=this.meta||this.initOptions.meta;if(meta.config){return;}
if(_.isUndefined(this.context)){return;}
if(this.isForecastSetup&&this.forecastsConfigOK){this.on('render',function(){var chartField=this.getField('paretoChart'),dashletToolbar=this.layout.getComponent('dashlet-toolbar');if(chartField&&dashletToolbar){chartField.before('chart:pareto:render',function(){this.$('[data-action=loading]').removeClass(this.cssIconDefault).addClass(this.cssIconRefresh);},dashletToolbar);chartField.on('chart:pareto:rendered',function(){this.$('[data-action=loading]').removeClass(this.cssIconRefresh).addClass(this.cssIconDefault);},dashletToolbar);}},this);this.settings.on('change:title',function(model,title){this.layout.setTitle(this.getLabel()+title);},this);this.settings.on('change:display_manager',this.toggleRepOptionsVisibility,this);if(!this.displayTimeperiodPivot){this.findModelToListen();this.listenModel.on('change',this.handleDataChange,this);}else{this.settings.on('change:selectedTimePeriod',function(context,timeperiod){this.settings.set({timeperiod_id:timeperiod});},this);}}},findModelToListen:function(){this.listenModel=this._getNonForecastModel();},_getNonForecastModel:function(){if(this.model.module=='Forecasts'){return this.context.parent.get('model');}
return this.model;},handleDataChange:function(model){model=model||this._getNonForecastModel();var changed=model.changed,changedField=_.keys(changed),validChangedFields=_.intersection(this.validChangedFields,_.keys(changed)),changedCurrencyFields=_.intersection(['amount','best_case','likely_case','worst_case'],validChangedFields),assigned_user=model.get('assigned_user_id');if(!_.isEmpty(changedCurrencyFields)){_.each(changedCurrencyFields,function(field){if(parseFloat(model.get(field))==parseFloat(model.previous(field))){validChangedFields=_.without(validChangedFields,field);}});}
if(_.isEmpty(validChangedFields)){return;}
if(this.settings.get('display_manager')===false&&assigned_user==app.user.get('id')){var field=this.getField('paretoChart'),serverData=field.getServerData();if(!field.hasServerData()){return;}
if(changedField.length==1&&changedField[0]=='date_closed'){changedField.push('date_closed_timestamp');changed.date_closed_timestamp=Math.round(+app.date.parse(changed.date_closed).getTime()/ 1000);model.set('date_closed_timestamp',changed.date_closed_timestamp,{silent:true});}
if(_.contains(changedField,'date_closed_timestamp')){if(!(model.get('date_closed_timestamp')>=_.first(serverData['x-axis']).start_timestamp&&model.get('date_closed_timestamp')<=_.last(serverData['x-axis']).end_timestamp)){if(this.listenModel instanceof Backbone.Collection){if(this.listenModel.length>1){this.removeRowFromChart(model);return;}}
field.once('chart:pareto:rendered',function(){this[0].addRowToChart(this[1]);},[this,model]);this.settings.set('timeperiod_id',model.get('date_closed_timestamp'));return;}}
if(_.contains(changedField,'amount')){changed.likely=this._convertCurrencyValue(changed.amount,model.get('base_rate'));delete changed.amount;}
if(_.contains(changedField,'likely_case')){changed.likely=this._convertCurrencyValue(changed.likely_case,model.get('base_rate'));delete changed.likely_case;}
if(_.contains(changedField,'best_case')){changed.best=this._convertCurrencyValue(changed.best_case,model.get('base_rate'));delete changed.best_case;}
if(_.contains(changedField,'worst_case')){changed.worst=this._convertCurrencyValue(changed.worst_case,model.get('base_rate'));delete changed.worst_case;}
if(_.contains(changedField,'commit_stage')){changed.forecast=changed.commit_stage;delete changed.commit_stage;}
var record=_.find(serverData.data,function(record,i,list){if(model.get('id')==record.record_id){list[i]=_.extend({},record,changed);return true;}
return false;});if(_.isEmpty(record)){this.addRowToChart(model);}else{field.setServerData(serverData,_.contains(changedField,'probability'));}}else if(_.contains(changedField,'assigned_user_id')){if(assigned_user===app.user.get('id')){this.addRowToChart(model);}else{this.removeRowFromChart(model);}}},addRowToChart:function(model){model=model||this._getNonForecastModel();if(model.get('assigned_user_id')==app.user.get('id')&&!this.settings.get('display_manager')){var field=this.getField('paretoChart'),serverData=field.getServerData(),found=_.find(serverData.data,function(record){return(record.record_id==model.get('id'));}),base_rate=model.get('base_rate'),likely_field=model.has('amount')?model.get('amount'):model.get('likely_case');if(_.isEmpty(found)){serverData.data.push({best:this._convertCurrencyValue(model.get('best_case'),base_rate),likely:this._convertCurrencyValue(likely_field,base_rate),worst:this._convertCurrencyValue(model.get('worst_case'),base_rate),record_id:model.get('id'),date_closed_timestamp:model.get('date_closed_timestamp'),probability:model.get('probability'),sales_stage:model.get('sales_stage'),forecast:model.get('commit_stage')});field.setServerData(serverData,true);}}},_convertCurrencyValue:function(value,base_rate){return app.currency.convertWithRate(value,base_rate);},removeRowFromChart:function(model){model=model||this._getNonForecastModel();var field=this.getField('paretoChart'),serverData=field.getServerData();_.find(serverData.data,function(record,i,list){if(model.get('id')==record.record_id){list.splice(i,1);return true;}
return false;});field.setServerData(serverData,true);},unbindData:function(){var ctx=this.context.parent;if(ctx){ctx.off(null,null,this);}
if(this.listenModel)this.listenModel.off(null,null,this);if(this.context)this.context.off(null,null,this);app.view.View.prototype.unbindData.call(this);},_initPlugins:function(){if(this.isManager){this.plugins=_.union(this.plugins,['ToggleVisibility']);}
return this;}})