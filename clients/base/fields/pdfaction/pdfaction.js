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
({extendsFrom:'RowactionField',events:{'click [data-action=link]':'linkClicked','click [data-action=download]':'downloadClicked','click [data-action=email]':'emailClicked'},templateCollection:null,fetchCalled:false,initialize:function(options){this._super('initialize',[options]);this.templateCollection=app.data.createBeanCollection('PdfManager');this._fetchTemplate();},_render:function(){var emailClientPreference=app.user.getPreference('email_client_preference');if(!this.templateCollection.length>0||(this.def.action==='email'&&emailClientPreference.type!=='sugar')){this.hide();}else{this._super('_render');}},_fetchTemplate:function(){this.fetchCalled=true;var collection=this.templateCollection;collection.filterDef={'$and':[{'base_module':this.module},{'published':'yes'}]};collection.fetch();},_buildDownloadLink:function(templateId){var urlParams=$.param({'action':'sugarpdf','module':this.module,'sugarpdf':'pdfmanager','record':this.model.id,'pdf_template_id':templateId});return'?'+urlParams;},_buildEmailLink:function(templateId){return'#'+app.bwc.buildRoute(this.module,null,'sugarpdf',{'sugarpdf':'pdfmanager','record':this.model.id,'pdf_template_id':templateId,'to_email':'1'});},linkClicked:function(evt){evt.preventDefault();evt.stopPropagation();if(this.templateCollection.dataFetched){this.fetchCalled=!this.fetchCalled;}else{this._fetchTemplate();}
this.render();},emailClicked:function(evt){var templateId=this.$(evt.currentTarget).data('id');app.router.navigate(this._buildEmailLink(templateId),{trigger:true});},downloadClicked:function(evt){var templateId=this.$(evt.currentTarget).data('id');app.bwc.login(null,_.bind(function(){this._triggerDownload(this._buildDownloadLink(templateId));},this));},_triggerDownload:function(url){app.api.fileDownload(url,{error:function(data){app.error.handleHttpError(data,{});}},{iframe:this.$el});},bindDataChange:function(){this.templateCollection.on('reset',this.render,this);this._super('bindDataChange');},unbindData:function(){this.templateCollection.off(null,null,this);this.templateCollection=null;this._super('unbindData');},hasAccess:function(){var pdfAccess=app.acl.hasAccess('view','PdfManager');return pdfAccess&&this._super('hasAccess');}})