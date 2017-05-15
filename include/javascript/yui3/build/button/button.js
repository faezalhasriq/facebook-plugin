/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('button',function(Y,NAME){var ButtonCore=Y.ButtonCore,CLASS_NAMES=ButtonCore.CLASS_NAMES,ARIA_STATES=ButtonCore.ARIA_STATES,ARIA_ROLES=ButtonCore.ARIA_ROLES;function Button(){Button.superclass.constructor.apply(this,arguments);}
Y.extend(Button,Y.Widget,{BOUNDING_TEMPLATE:ButtonCore.prototype.TEMPLATE,CONTENT_TEMPLATE:null},{NAME:ButtonCore.NAME,ATTRS:ButtonCore.ATTRS,HTML_PARSER:{labelHTML:ButtonCore._getHTMLFromNode,disabled:ButtonCore._getDisabledFromNode},CLASS_NAMES:CLASS_NAMES});Y.mix(Button.prototype,ButtonCore.prototype);function ToggleButton(){Button.superclass.constructor.apply(this,arguments);}
Y.extend(ToggleButton,Button,{trigger:'click',selectedAttrName:'',initializer:function(config){var button=this,type=button.get('type'),selectedAttrName=(type==="checkbox"?'checked':'pressed'),selectedState=config[selectedAttrName]||false;button.addAttr(selectedAttrName,{value:selectedState});button.selectedAttrName=selectedAttrName;},destructor:function(){delete this.selectedAttrName;},bindUI:function(){var button=this,cb=button.get('contentBox');ToggleButton.superclass.bindUI.call(button);cb.on(button.trigger,button.toggle,button);button.after(button.selectedAttrName+'Change',button._afterSelectedChange);},syncUI:function(){var button=this,cb=button.get('contentBox'),type=button.get('type'),ROLES=ToggleButton.ARIA_ROLES,role=(type==='checkbox'?ROLES.CHECKBOX:ROLES.TOGGLE),selectedAttrName=button.selectedAttrName;ToggleButton.superclass.syncUI.call(button);cb.set('role',role);button._uiSetSelected(button.get(selectedAttrName));},_afterSelectedChange:function(e){this._uiSetSelected(e.newVal);},_uiSetSelected:function(value){var button=this,cb=button.get('contentBox'),STATES=ToggleButton.ARIA_STATES,type=button.get('type'),ariaState=(type==='checkbox'?STATES.CHECKED:STATES.PRESSED);cb.toggleClass(Button.CLASS_NAMES.SELECTED,value);cb.set(ariaState,value);},toggle:function(){var button=this;button._set(button.selectedAttrName,!button.get(button.selectedAttrName));}},{NAME:'toggleButton',ATTRS:{type:{value:'toggle',writeOnce:'initOnly'}},HTML_PARSER:{checked:function(node){return node.hasClass(CLASS_NAMES.SELECTED);},pressed:function(node){return node.hasClass(CLASS_NAMES.SELECTED);}},ARIA_STATES:ARIA_STATES,ARIA_ROLES:ARIA_ROLES,CLASS_NAMES:CLASS_NAMES});Y.Button=Button;Y.ToggleButton=ToggleButton;},'3.15.0',{"requires":["button-core","cssbutton","widget"]});