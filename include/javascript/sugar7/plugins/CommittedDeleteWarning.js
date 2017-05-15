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
(function(app){app.events.on('app:init',function(){app.plugins.register('CommittedDeleteWarning',['view'],{onAttach:function(component,plugin){this.on('init',function(){this.context.on('record:deleted',this.showDeleteRecordCommitWarning,this);this.layout.on('list:records:deleted',this.showDeleteRecordCommitWarning,this);this.layout.on('list:record:deleted',this.showDeleteRecordCommitWarning,this);});},showDeleteRecordCommitWarning:function(deletedModel){var message=null;if(this.checkDeletedModel(deletedModel)){var forecastModuleSingular=app.lang.getModuleName('Forecasts');message=app.lang.get('WARNING_DELETED_RECORD_RECOMMIT_1','Forecasts')
+'<a href="#Forecasts">'+forecastModuleSingular+'</a>.  '
+app.lang.get('WARNING_DELETED_RECORD_RECOMMIT_2','Forecasts')
+'<a href="#Forecasts">'+forecastModuleSingular+'</a>.';app.alert.show('included_list_delete_warning',{level:'warning',messages:message,onLinkClick:function(){app.alert.dismissAll();}});}
return message;},checkDeletedModel:function(deletedModel){var showWarning=false;if(_.isArray(deletedModel)){showWarning=_.find(deletedModel,function(model){return this._checkDeletedModel(model);},this);}else{showWarning=this._checkDeletedModel(deletedModel);}
return showWarning;},_checkDeletedModel:function(deletedModel){var showDeleteWarning=false;if(deletedModel.module==='Opportunities'&&deletedModel.get('included_revenue_line_items')){showDeleteWarning=true;}else{var config=app.metadata.getModule('Forecasts','config');if(_.contains(config.commit_stages_included,deletedModel.get('commit_stage'))){showDeleteWarning=true;}}
return showDeleteWarning;},onDetach:function(component,plugin){this.context.off('record:deleted',null,this);this.layout.off('list:record:deleted',null,this);this.layout.off('list:records:deleted',null,this);}});});})(SUGAR.App);