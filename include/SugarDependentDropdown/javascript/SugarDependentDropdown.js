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
SUGAR.dependentDropdown={currentAction:null,debugMode:false}
SUGAR.dependentDropdown.handleDependentDropdown=function(el){}
SUGAR.dependentDropdown.generateElement=function(focusElement,elementRow,index,elementIndex){if(SUGAR.dependentDropdown.debugMode)SUGAR.dependentDropdown.utils.debugStack('generateElement');var tmp=null;if(focusElement){var sandbox=SUGAR.dependentDropdown.utils.generateElementContainer(focusElement,elementRow,index,elementIndex);if(focusElement.label){focusLabel={tag:'span',cls:'routingLabel',html:"&nbsp;"+focusElement.label+"&nbsp;"}
switch(focusElement.label_pos){case"top":focusLabel.html=focusElement.label+"<br />";break;case"bottom":focusLabel.html="<br />"+focusElement.label;break;}
if(focusElement.label_pos=='left'||focusElement.label_pos=='top'){YAHOO.ext.DomHelper.append(sandbox,focusLabel);}}
switch(focusElement.type){case'input':if(typeof(focusElement.values)=='string'){focusElement.values=eval(focusElement.values);}
var preselect=SUGAR.dependentDropdown.utils.getPreselectKey(focusElement.name);if(preselect.match(/::/))
preselect='';tmp=YAHOO.ext.DomHelper.append(sandbox,{tag:'input',id:focusElement.grouping+"::"+index+":::"+elementIndex+":-:"+focusElement.id,name:focusElement.grouping+"::"+index+"::"+focusElement.name,cls:'input',onchange:focusElement.onchange,value:preselect},true);var newElement=tmp.dom;break;case'select':tmp=YAHOO.ext.DomHelper.append(sandbox,{tag:'select',id:focusElement.grouping+"::"+index+":::"+elementIndex+":-:"+focusElement.id,name:focusElement.grouping+"::"+index+"::"+focusElement.name,cls:'input',onchange:focusElement.onchange},true);var newElement=tmp.dom;if(typeof(focusElement.values)=='string'){focusElement.values=eval(focusElement.values);}
var preselect=SUGAR.dependentDropdown.utils.getPreselectKey(focusElement.name);var i=0;for(var key in focusElement.values){var selected=(preselect==key)?true:false;newElement.options[i]=new Option(focusElement.values[key],key,selected);if(selected){newElement.options[i].selected=true;}
i++;}
break;case'none':break;case'checkbox':alert('implement checkbox pls');break;case'multiple':alert('implement multiple pls');break;default:if(SUGAR.dependentDropdown.dropdowns.debugMode){alert("Improper type defined: [ "+focusElement.type+"]");}
return;break;}
if(focusElement.label){if(focusElement.label_pos=='right'||focusElement.label_pos=='bottom'){YAHOO.ext.DomHelper.append(sandbox,focusLabel);}}
try{newElement.onchange();}catch(e){if(SUGAR.dependentDropdown.dropdowns.debugMode){debugger;}}}else{}}
SUGAR.dependentDropdown.utils={generateElementContainer:function(focusElement,elementRow,index,elementIndex){var oldElement=document.getElementById('elementContainer'+focusElement.grouping+"::"+index+":::"+elementIndex);if(oldElement){SUGAR.dependentDropdown.utils.removeChildren(oldElement);}
var tmp=YAHOO.ext.DomHelper.append(elementRow,{tag:'span',id:'elementContainer'+focusElement.grouping+"::"+index+":::"+elementIndex},true);return tmp.dom;},getPreselectKey:function(elementName){try{if(SUGAR.dependentDropdown.currentAction.action[elementName]){return SUGAR.dependentDropdown.currentAction.action[elementName];}else{return'';}}catch(e){if(SUGAR.dependentDropdown.dropdowns.debugMode){}
return'';}},debugStack:function(func){if(!SUGAR.dependentDropdown._stack){SUGAR.dependentDropdown._stack=new Array();}
SUGAR.dependentDropdown._stack.push(func);},removeChildren:function(el){for(i=el.childNodes.length-1;i>=0;i--){if(el.childNodes[i]){el.removeChild(el.childNodes[i]);}}}}