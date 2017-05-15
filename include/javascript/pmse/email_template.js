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
var UID,TEMPLATE_NAME,panel,restProxy,w,f,editorWindow,editorInstance,clone,editorWidth="100%",editorHeight='450px',timeoutForAutoSave=5000,timer,usingTimer=false,dirtyNotificator;function initTimer(){timer=setInterval(function(){usingTimer=true;save();},timeoutForAutoSave);}
function onChange(){dirtyNotificator.text("*");};function openPanel(){var i;panel.open();for(i=0;i<panel.subpanels.length;i+=1){if(panel.subpanels[i].isOpen){return;}}
if(i){panel.subpanels[0].open();}}
function getTextSize(text,objectReference){var $container=$(objectReference),span=document.createElement('span'),h,w;$(span).css({"font-family":$container.css("font-family"),"font-size":$container.css("font-size")});span.innerHTML=text.replace(/\s/g,"&nbsp;");span.style.display="none";span.style.whiteSpace='nowrap';document.body.appendChild(span);w=$(span).outerWidth();h=$(span).outerHeight();$(span).remove();return{width:w,height:h};}
function showPanelOnSubject(i){var textSize,inputPos,subjectInput=$('#email_subject').get(0);textSize=getTextSize(subjectInput.value.substr(0,i),subjectInput);inputPos=$(subjectInput).offset();panel.setBelongsTo(subjectInput);openPanel();panel.getHTML().style.left=(inputPos.left+textSize.width)+"px";}
function evaluateInputText(e){if(e.keyCode===27){panel.close();return;}
var i=this.selectionStart;if((this.value.length>0&&this.value.charAt(i-1)==='{')||(this.value.length>1&&this.value.charAt(i-1)===':'&&this.value.charAt(i-2)==='{')||(this.value.length>2&&this.value.charAt(i-1)===':'&&this.value.charAt(i-2)===':'&&this.value.charAt(i-3)==='{')){showPanelOnSubject(i);}else{panel.close();}}
function showPanelOnPlainTextBody(i){var inputArea=$('#plain_email_body'),text,breakLines,offset=$(inputArea).offset(),lastLineWidth=0,inputAreaWidth=$(inputArea).width();text=inputArea.val().substr(0,i).split(/\n/);breakLines=text.length;$(clone).remove();clone=document.createElement("div");$(clone).css({width:inputAreaWidth+"px","font-family":$(inputArea).css("font-family"),"font-size":$(inputArea).css("font-size"),"padding":$(inputArea).css("padding"),"top":offset.top,"left":offset.left,"position":"absolute"});for(i=0;i<breakLines;i+=1){if(i===breakLines){clone.innerHTML+=text[i];}else if(i>0){clone.innerHTML+='<br/>{';}else{clone.innerHTML+='{';}
lastLineWidth=getTextSize(text[i],inputArea).width;while(lastLineWidth>inputAreaWidth){lastLineWidth-=inputAreaWidth;clone.innerHTML+='<br/>{';}}
document.body.appendChild(clone);panel.setBelongsTo(clone);openPanel();panel.getHTML().style.left=(parseInt(panel.getHTML().style.left,10)+lastLineWidth)+"px";$(clone).hide();}
function evaluateInputPlainText(e){if(e.keyCode===27){panel.close();return;}
var i=this.selectionStart;if((this.value.length>0&&this.value.charAt(i-1)==='{')||(this.value.length>1&&this.value.charAt(i-1)===':'&&this.value.charAt(i-2)==='{')||(this.value.length>2&&this.value.charAt(i-1)===':'&&this.value.charAt(i-2)===':'&&this.value.charAt(i-3)==='{')){showPanelOnPlainTextBody(i);}else{panel.close();}}
function showPanelOnEditorText(){var selection=editorWindow.getSelection(),aux,pos,i,j,extraPos={width:0,height:0},textContainer,textNodeValue,textContainerWidth,additionalRows='',textNode;textNode=selection.anchorNode;if(textNode.tagName){textContainer=textNode;textNode=document.createTextNode("");textContainer.appendChild(textNode);}else{textContainer=textNode.parentElement;}
textNodeValue=textNode.nodeValue||"";i=selection.anchorOffset;aux=$(textContainer).offset();pos=$(editorInstance.contentAreaContainer).find("iframe").offset();pos={top:aux.top+pos.top,left:aux.left+pos.left};textContainerWidth=$(textContainer).width();if(textContainer.childNodes.length<=1){if(i>0){extraPos=getTextSize(textNodeValue.substr(0,i),textContainer);while(extraPos.width>textContainerWidth){extraPos.width-=textContainerWidth;additionalRows+='<br/>{';}}}else{for(i=0,j=textContainer.childNodes.length;i<j;i+=1){if(textContainer.childNodes[i]!==textNode){if(textContainer.childNodes[i].nodeType===document.TEXT_NODE){extraPos.width+=getTextSize(textContainer.childNodes[i].nodeValue,textContainer).width;}else if(textContainer.childNodes[i].nodeType===document.ELEMENT_NODE){if(textContainer.childNodes[i].tagName.toLowerCase()==='br'){while(extraPos.width>textContainerWidth){extraPos.width-=textContainerWidth;additionalRows+='<br/>{';}
additionalRows+='<br/>{';extraPos.width=0;}else{extraPos.width+=$(textContainer.childNodes[i]).outerWidth();}}}else{i=selection.anchorOffset;extraPos.width+=getTextSize(textNodeValue.substr(0,i),textContainer).width;while(extraPos.width>textContainerWidth){extraPos.width-=textContainerWidth;additionalRows+='<br/>{';}
break;}}}
$(clone).remove();clone=textContainer.cloneNode(false);$(clone).css({"font-family":$(textContainer).css("font-family"),"font-size":$(textContainer).css("font-size")});clone.innerHTML='{'+additionalRows;clone.style.position='absolute';clone.style.top=(pos.top)+"px";clone.style.left=(pos.left+extraPos.width)+"px";$(clone).data("textNode",textNode);document.body.appendChild(clone);panel.setBelongsTo(clone);openPanel();clone.style.display='none';}
function evaluateInputEditorText(e){if(e.keyCode===27){panel.close();return;}
var selection=editorWindow.getSelection(),textNode,i,length,textNodeValue;textNode=selection.anchorNode;textNodeValue=textNode.nodeValue;i=selection.anchorOffset;length=(textNodeValue&&textNodeValue.length)||0;if((length>0&&textNodeValue.charAt(i-1)==='{')||(length>1&&textNodeValue.charAt(i-1)===':'&&textNodeValue.charAt(i-2)==='{')||(length>2&&textNodeValue.charAt(i-1)===':'&&textNodeValue.charAt(i-2)===':'&&textNodeValue.charAt(i-3)==='{')){showPanelOnEditorText();}else{panel.close();}}
function showSaveButton(){$('#save_label').remove();$('#save').show();}
function onSuccess(){App.alert.dismiss('upload');$('#template-name-title').text($('#template_name').val());dirtyNotificator.text("");if(!usingTimer){location.href=SUGAR_URL;}}
function onFailure(){var mp=new MessagePanel({title:'Error',wtype:'Error',message:valid.message});mp.show();showSaveButton();}
function save(){var json={},$from_address=$('#from_address'),$from_name=$('#from_name'),$name=$('#template_name'),$description=$('#template_description'),$subject=$('#email_subject'),$text_only=$('#text_only_body'),errorMessage,errorFields='',restClient=new RestClient(),result=true,mp=new MessagePanel({title:'Warning',wtype:'Warning'});$from_name.val($.trim($from_name.val()));$from_address.val($.trim($from_address.val()));$name.val($.trim($name.val()));$subject.val($.trim($subject.val()));$text_only.val($text_only.val());if(!($from_address.val()===""||/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($from_address.val()))){if(!usingTimer){mp.setMessage(translate('LBL_PMSE_LABEL_ERROR_INVALID_EMAIL_ADDRESS ON FIELD',translate('LBL_PMSE_DASHLET_LABEL_FROM_ADDRESS')));mp.show();}
return;}
$('#template_name').val($.trim($('#template_name').val()));json.body_html=editorInstance.getBody().innerHTML;json.name=$name.val();json.description=$description.val();json.subject=$subject.val();json.from_name=$from_name.val();json.from_address=$from_address.val();if(!json.name){errorFields+='<br/> * '+translate('LBL_PMSE_DASHLET_LABEL_NAME');}
if(!json.subject){errorFields+='<br/> * '+translate('LBL_PMSE_DASHLET_LABEL_SUBJECT');}
if((!$.trim($(editorInstance.getBody()).text())&&!json.text_only)||(!$.trim(json.body)&&json.text_only)){errorFields+='<br/> * '+translate('LBL_PMSE_DASHLET_LABEL_BODY');}
if(errorFields){if(!usingTimer){mp.setTitle('Warning');mp.setMessageType('Warning');mp.setMessage(translate('LBL_PMSE_LABEL_ERROR_FIELDS_TO_FILL')+errorFields);mp.show();}
return;}
restClient.setRestfulBehavior(SUGAR_REST);if(!SUGAR_REST){restClient.setBackupAjaxUrl(SUGAR_AJAX_URL);}
restClient.getCall({url:SUGAR_URL+'/rest/v10/CrmData/validateEmailTemplateName',id:$name.val(),data:{id:UID},success:function(xhr,response){result=response.result;if(!result&&!usingTimer){errorMessage=translate('LBL_PMSE_MESSAGE_THEEMAILTEMPLATENAMEALREADYEXISTS',$name.val());mp.setTitle('Error');mp.setMessageType('Error');mp.setMessage(errorMessage);mp.show();}},failure:function(xhr,response){if(!usingTimer){mp.setTitle('Error');mp.setMessageType('Error');mp.setMessage(translate('LBL_PMSE_LABEL_ERROR_GENERIC'));mp.setButtons([{jtype:'normal',caption:translate('LBL_PMSE_BUTTON_OK'),handler:function(){location.href=SUGAR_URL;}}]);mp.show();}}});if(!result){App.alert.dismiss('upload');return false;}
restProxy.setUrl("/rest/v10/EmailTemplate/");restProxy.setUid(UID);restProxy.sendData(json,{success:onSuccess,failure:onFailure});}
function attachListeners(){$('#variables_panel_button').on('click',function(e){e.stopPropagation();e.preventDefault();showPanelOnSubject($('#email_subject').get(0).selectionStart);});$('#email_subject').on('blur',function(){panel.close();}).on('keyup',evaluateInputText);$('#variables_window_button').on("click",function(e){e.preventDefault();e.stopPropagation();showPanelOnEditorText();});$('#email_template_form').on('submit',function(e){App.alert.show('upload',{level:'process',title:'LBL_LOADING',autoclose:false});e.preventDefault();usingTimer=false;save();});$('#cancel').on('click',function(){App.router.navigate('Home',{trigger:true,replace:true});});$('#text_only_body').on('change',function(){if(this.checked){$('#email_body_container').hide();$('#plain_body_container').show().find('textarea').css({width:editorWidth,height:editorHeight});}else{$('#email_body_container').show();$('#plain_body_container').hide();}});$(document.body).on("click",function(){panel.close();});$('#plain_email_body').on('keyup',evaluateInputPlainText);$('#save').on('click',function(){App.alert.show('upload',{level:'process',title:'LBL_LOADING',autoclose:false});var errorFields='',fields=$('#email_template_form').serializeArray(),i,description=document.getElementById('template_description').value,body=tinyMCE.get('email_body').getContent(),attributes,url,mp,errorMessage='',canSave;mp=new MessagePanel({title:'Warning',wtype:'Warning'});if(!(fields[2].value===""||/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(fields[2].value))){if(!usingTimer){mp.setMessage(translate('LBL_PMSE_LABEL_ERROR_INVALID_EMAIL_ADDRESS ON FIELD',translate('LBL_PMSE_DASHLET_LABEL_FROM_ADDRESS')));mp.show();}
return;}
if(!fields[0].value){errorFields+='<br/> * '+translate('LBL_PMSE_DASHLET_LABEL_NAME');}
if(!fields[3].value){errorFields+='<br/> * '+translate('LBL_PMSE_DASHLET_LABEL_SUBJECT');}
if((!$.trim($(editorInstance.getBody()).text()))){errorFields+='<br/> * '+translate('LBL_PMSE_DASHLET_LABEL_BODY');}
if(errorFields){if(!usingTimer){mp.setTitle('Warning');mp.setMessageType('Warning');mp.setMessage(translate('LBL_PMSE_LABEL_ERROR_FIELDS_TO_FILL')+errorFields);mp.show();}
return;}
url=App.api.buildURL('pmse_Emails_Templates',null,null,{filter:[{'name':fields[0].value}]});App.api.call("read",url,null,{success:function(a){App.alert.dismiss('upload');if(TEMPLATE_NAME!==fields[0].value){if(a.records.length>0){errorMessage=translate('LBL_PMSE_MESSAGE_THEEMAILTEMPLATENAMEALREADYEXISTS',fields[0].value);mp.setTitle('Error');mp.setMessageType('Error');mp.setMessage(errorMessage);mp.show();}else{canSave=true;}}else{canSave=true;}
if(canSave){attributes={'subject':fields[3].value,'name':fields[0].value,'from_name':fields[1].value,'from_address':fields[2].value,'description':description,'body_html':body};url=App.api.buildURL("pmse_Emails_Templates",null,{id:UID});App.api.call('update',url,attributes,{success:function(a){App.router.navigate('Home',{trigger:true,replace:true});}});}}});});}
function loadModuleFields(module){var fields;if(module&&!module.fields.length){restProxy.setUrl("/rest/v10/CrmData/fields/");restProxy.uid=module.value;fields=restProxy.getData({});if(fields.success){module.fields=fields.result;}}}
function replaceExpression(string,replace){return string.replace(/^\{\:\:([a-zA-Z]|\d)+\:\:([a-zA-Z_\-]|\d)+\:\:\}/,replace);}
function getAddVariableHandler(module){return function(value){var input,currentValue,i,newExpression="{::"+module+"::"+value+"::}",aux,aux2;if(this.parent.belongsTo.tagName.toLowerCase()==="input"){input=$('#email_subject').get(0);currentValue=input.value;i=input.selectionStart;}else if(this.parent.belongsTo.tagName.toLowerCase()==="div"){input=$('#plain_email_body').get(0);currentValue=input.value;i=input.selectionStart;}else{input=$(this.parent.belongsTo).data("textNode");currentValue=input.nodeValue;i=editorWindow.getSelection().anchorOffset;}
if(i){if(currentValue.charAt(i-1)==="{"){aux=currentValue.substr(i-1);aux2=replaceExpression(aux,newExpression);aux=aux2===aux?aux.replace(/\{/,newExpression):aux2;}else if(i>1&&currentValue.charAt(i-1)===":"&&currentValue.charAt(i-2)==="{"){aux=currentValue.substr(i-2);aux2=replaceExpression(aux,newExpression);aux=aux2===aux?aux.replace(/\{\:/,newExpression):aux2;i-=1;}else if(i>2&&currentValue.charAt(i-1)===":"&&currentValue.charAt(i-2)===":"&&currentValue.charAt(i-3)==="{"){aux=currentValue.substr(i-3);aux2=replaceExpression(aux,newExpression);aux=aux2===aux?aux.replace(/\{\:\:/,newExpression):aux2;i-=2;}
if(aux2){value=currentValue.substr(0,i-1)+aux;}else{value=currentValue.substr(0,i)+newExpression+currentValue.substr(i);}}else{i=0;value=newExpression+currentValue;}
if(this.parent.belongsTo.tagName.toLowerCase()==='input'||this.parent.belongsTo.tagName.toLowerCase()==='div'){input.value=value;}else{input.nodeValue=value;}
panel.close();};}
function updateFieldsOptions(value){var i,selectField=f.items[1];$(selectField.controlObject).empty();if(value===MODULE){selectField.setOptions(FIELDS);}else{for(i=0;i<RELATED_MODULES.length;i+=1){if(RELATED_MODULES[i].value===value){i=RELATED_MODULES[i];break;}}
loadModuleFields(i);selectField.setOptions(i.fields);}}
function init(param){var i,FIELDS=param.targetFields,RELATED_MODULES=param.relatedModules,MODULE=param.targetModule;UID=param.et_uid;TEMPLATE_NAME=param.templateName;tinyMCE.baseURL="include/javascript/tiny_mce/";tinyMCE.init({"convert_urls":false,"valid_children":"+body[style]","height":editorHeight,"width":editorWidth,"theme":"advanced","theme_advanced_toolbar_align":"left","theme_advanced_toolbar_location":"top","theme_advanced_buttons1":"code,help,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,\n\t                     \t\t\t\t\tjustifyfull,separator,forecolor,backcolor,separator,styleselect,formatselect,fontselect,fontsizeselect,","theme_advanced_buttons2":"cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,\n\t                     \t\t\t\t\tindent,separator,ltr,rtl,separator,undo,redo,separator, link,unlink,anchor,image,separator,sub,sup,separator,charmap,\n\t                     \t\t\t\t\tvisualaid","theme_advanced_buttons3":"tablecontrols,separator,advhr,hr,removeformat,separator,insertdate,inserttime,separator,preview,spellchecker","strict_loading_mode":true,"mode":"exact","language":"en","plugins":"advhr,insertdatetime,table,preview,paste,searchreplace,directionality,spellchecker,fullpage","elements":"","extended_valid_elements":"style[dir|lang|media|title|type],hr[class|width|size|noshade],@[class|style]","content_css":"include\/javascript\/tiny_mce\/themes\/advanced\/skins\/default\/content.css","cleanup_on_startup":true,"directionality":"ltr","init_instance_callback":function(){editorInstance=this;editorWindow=editorInstance.getWin();$(editorWindow.document.body).on("click",function(){});},"onchange_callback":function(a,b,c){}});tinyMCE.execCommand('mceAddControl',false,'email_body');panel=new MultipleItemPanel({belongsTo:document.getElementById("email_subject"),matchParentWidth:false,width:18});panel.addSubpanel({title:translate('LBL_PMSE_ADAM_UI_TITLE_MODULE_FIELDS',translate('LBL_PMSE_LABEL_TARGETMODULE')),collapsable:true,items:FIELDS,onItemSelect:getAddVariableHandler(MODULE)},"list");for(i=0;i<RELATED_MODULES.length;i+=1){panel.addSubpanel({title:translate('LBL_PMSE_ADAM_UI_TITLE_MODULE_FIELDS',RELATED_MODULES[i].text),collapsable:true,items:RELATED_MODULES[i].fields,onItemSelect:getAddVariableHandler(RELATED_MODULES[i].value)},"list");}
f=$('#email_template_form');f.on('change',onChange);dirtyNotificator=$('#dirty-notificator');document.body.appendChild(panel.getHTML());attachListeners();$('#text_only_body').trigger("change");}