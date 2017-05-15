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
({extendsFrom:'DnbView',events:{'click .showMoreData':'showMoreData','click .showLessData':'showLessData','change #fb':'selectSocialMedia','change #youtube':'selectSocialMedia','change #twitter':'selectSocialMedia'},newsConst:{'newsPath':'OrderProductResponse.OrderProductResponseDetail.Product.Organization.News.NewsDetails','socialPath':'OrderProductResponse.OrderProductResponseDetail.Product.Organization.Telecommunication.SocialMediaDetail','socialMediaNamePath':'SocialMediaPlatformName.$','fburl':'https://www.facebook.com/','twitterurl':'https://twitter.com/','youtubeurl':'http://www.youtube.com/'},socialMediaMeta:{'youtube':{'code':25866,'url':'http://www.youtube.com/','label':'LBL_DNB_NEWS_YOUTUBE','list':null},'twitter':{'code':25867,'url':'https://twitter.com/','label':'LBL_DNB_NEWS_TWITTER','list':null},'wiki':{'code':25868,'url':'http://www.youtube.com/','label':'LBL_DNB_NEWS_WIKI','list':null},'fb':{'code':25869,'url':'https://www.facebook.com/','label':'LBL_DNB_NEWS_FACEBOOK','list':null}},socialMediaDD:{'mediaName':{'json_path':'SocialMediaPlatformName.$'},'contentKey':{'json_path':'UserContentKey'},'displayName':{'json_path':'UserDisplayName'}},initialize:function(options){this._super('initialize',[options]);if(this.layout.collapse){this.layout.collapse(true);}
this.layout.on('dashlet:collapse',this.loadNews,this);app.events.on('dnbcompinfo:duns_selected',this.collapseDashlet,this);this.layout.layout.context.on('dashboard:collapse:fire',this.loadNews,this);},loadData:function(options){if(this.model.get('duns_num')){this.duns_num=this.model.get('duns_num');}},_render:function(){app.view.View.prototype._renderHtml.call(this);_.each(this.socialMediaMeta,function(value,key){if(value.list&&value.list.length>0){var listSelector='#'+key;this.$(listSelector).select2({placeholder:app.lang.get(value.label),data:value.list,containerCss:{'width':'100%'}});}},this);},refreshClicked:function(){this.loadNews(false);},loadNews:function(isCollapsed){if(!isCollapsed){this.loadDNBData('duns_num','dnb_temp_duns_num',this.getNewsandMediaInfo,null,'dnb.dnb-no-duns','dnb.dnb-no-duns-field');}},selectSocialMedia:function(event){var selectedMedia=event.target.id;if(selectedMedia){var baseUrl=this.socialMediaMeta[selectedMedia].url;var selector='#'+selectedMedia;var contentKey=this.$(selector).val();window.open(baseUrl+contentKey);this.$(selector).val('');}},getNewsandMediaInfo:function(duns_num){var self=this;self.template=app.template.get(self.name);if(!self.disposed){self.render();}
self.$('div#dnb-news-detail-loading').show();self.$('div#dnb-news-detail').hide();if(duns_num&&duns_num!==''){var dnbNewInfoURL=app.api.buildURL('connector/dnb/news/'+duns_num,'',{},{});var resultData={'product':null,'errmsg':null};app.api.call('READ',dnbNewInfoURL,{},{success:function(data){var responseCode=self.getJsonNode(data,self.appendSVCPaths.responseCode),responseMsg=self.getJsonNode(data,self.appendSVCPaths.responseMsg);if(responseCode&&responseCode===self.responseCodes.success){var newsData=self.getJsonNode(data,self.newsConst.newsPath),socialData=self.getJsonNode(data,self.newsConst.socialPath);if(newsData||socialData){resultData.news={},resultData.social={};if(newsData){resultData.news.product=newsData;}
if(socialData){resultData.social.product=socialData;}}else{resultData.errmsg=app.lang.get('LBL_DNB_NO_DATA');}}else{resultData.errmsg=responseMsg||app.lang.get('LBL_DNB_SVC_ERR');}
self.renderNewsAndSocial(resultData);},error:_.bind(self.checkAndProcessError,self)});}},renderNewsAndSocial:function(dnbApiResponse){if(this.disposed){return;}
var dnbNews={};if(dnbApiResponse.news||dnbApiResponse.social){dnbNews.news={},dnbNews.social={};if(dnbApiResponse.news.product){dnbNews.news.product=dnbApiResponse.news.product;}else{dnbNews.news.errmsg=app.lang.get('LBL_DNB_NO_DATA');}
if(dnbApiResponse.social.product){dnbNews.social.product=this.formatSocial(dnbApiResponse.social.product,this.socialMediaDD);}else{dnbNews.social.errmsg=app.lang.get('LBL_DNB_NO_DATA');}}
if(dnbApiResponse.errmsg){dnbNews.errmsg=dnbApiResponse.errmsg;}
this.dnbNews=dnbNews;this.render();this.$('div#dnb-news-detail-loading').hide();this.$('div#dnb-news-detail').show();this.$('.showLessData').hide();},formatSocial:function(dnbApiResponse,socialDD){var socialMedia=_.groupBy(dnbApiResponse,function(socialObj){return socialObj.SocialMediaPlatformName['@DNBCodeValue'];});var formattedSocialData=[];_.each(this.socialMediaMeta,function(socialMetaValue,socialMetaKey){if(socialMedia[socialMetaValue.code]){formattedSocialData.push({'label':socialMetaValue.label,'mediaId':socialMetaKey});socialMetaValue.list=[];_.each(socialMedia[socialMetaValue.code],function(socialMediaDetails){var contentKey=this.getJsonNode(socialMediaDetails,this.socialMediaDD.contentKey.json_path),displayName=this.getJsonNode(socialMediaDetails,this.socialMediaDD.displayName.json_path);var dropDownData=null;dropDownData={id:contentKey,text:displayName||contentKey};socialMetaValue.list.push(dropDownData);},this);}},this);return formattedSocialData;}});