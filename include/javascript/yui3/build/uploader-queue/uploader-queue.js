/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('uploader-queue',function(Y,NAME){var UploaderQueue=function(){this.queuedFiles=[];this.uploadRetries={};this.numberOfUploads=0;this.currentUploadedByteValues={};this.currentFiles={};this.totalBytesUploaded=0;this.totalBytes=0;UploaderQueue.superclass.constructor.apply(this,arguments);};Y.extend(UploaderQueue,Y.Base,{_currentState:UploaderQueue.STOPPED,initializer:function(){},_uploadStartHandler:function(event){var updatedEvent=event;updatedEvent.file=event.target;updatedEvent.originEvent=event;this.fire("uploadstart",updatedEvent);},_uploadErrorHandler:function(event){var errorAction=this.get("errorAction"),updatedEvent=event,fileid,retries;updatedEvent.file=event.target;updatedEvent.originEvent=event;this.numberOfUploads-=1;delete this.currentFiles[event.target.get("id")];this._detachFileEvents(event.target);event.target.cancelUpload();if(errorAction===UploaderQueue.STOP){this.pauseUpload();}
else if(errorAction===UploaderQueue.RESTART_ASAP){fileid=event.target.get("id");retries=this.uploadRetries[fileid]||0;if(retries<this.get("retryCount")){this.uploadRetries[fileid]=retries+1;this.addToQueueTop(event.target);}
this._startNextFile();}
else if(errorAction===UploaderQueue.RESTART_AFTER){fileid=event.target.get("id");retries=this.uploadRetries[fileid]||0;if(retries<this.get("retryCount")){this.uploadRetries[fileid]=retries+1;this.addToQueueBottom(event.target);}
this._startNextFile();}
this.fire("uploaderror",updatedEvent);},_startNextFile:function(){if(this.queuedFiles.length>0){var currentFile=this.queuedFiles.shift(),fileId=currentFile.get("id"),parameters=this.get("perFileParameters"),fileParameters=parameters.hasOwnProperty(fileId)?parameters[fileId]:parameters;this.currentUploadedByteValues[fileId]=0;currentFile.on("uploadstart",this._uploadStartHandler,this);currentFile.on("uploadprogress",this._uploadProgressHandler,this);currentFile.on("uploadcomplete",this._uploadCompleteHandler,this);currentFile.on("uploaderror",this._uploadErrorHandler,this);currentFile.on("uploadcancel",this._uploadCancelHandler,this);currentFile.set("xhrHeaders",this.get("uploadHeaders"));currentFile.set("xhrWithCredentials",this.get("withCredentials"));currentFile.startUpload(this.get("uploadURL"),fileParameters,this.get("fileFieldName"));this._registerUpload(currentFile);}},_registerUpload:function(file){this.numberOfUploads+=1;this.currentFiles[file.get("id")]=file;},_unregisterUpload:function(file){if(this.numberOfUploads>0){this.numberOfUploads-=1;}
delete this.currentFiles[file.get("id")];delete this.uploadRetries[file.get("id")];this._detachFileEvents(file);},_detachFileEvents:function(file){file.detach("uploadstart",this._uploadStartHandler);file.detach("uploadprogress",this._uploadProgressHandler);file.detach("uploadcomplete",this._uploadCompleteHandler);file.detach("uploaderror",this._uploadErrorHandler);file.detach("uploadcancel",this._uploadCancelHandler);},_uploadCompleteHandler:function(event){this._unregisterUpload(event.target);this.totalBytesUploaded+=event.target.get("size");delete this.currentUploadedByteValues[event.target.get("id")];if(this.queuedFiles.length>0&&this._currentState===UploaderQueue.UPLOADING){this._startNextFile();}
var updatedEvent=event,uploadedTotal=this.totalBytesUploaded,percentLoaded=Math.min(100,Math.round(10000*uploadedTotal/this.totalBytes)/ 100);updatedEvent.file=event.target;updatedEvent.originEvent=event;Y.each(this.currentUploadedByteValues,function(value){uploadedTotal+=value;});this.fire("totaluploadprogress",{bytesLoaded:uploadedTotal,bytesTotal:this.totalBytes,percentLoaded:percentLoaded});this.fire("uploadcomplete",updatedEvent);if(this.queuedFiles.length===0&&this.numberOfUploads<=0){this.fire("alluploadscomplete");this._currentState=UploaderQueue.STOPPED;}},_uploadCancelHandler:function(event){var updatedEvent=event;updatedEvent.originEvent=event;updatedEvent.file=event.target;this.fire("uploadcancel",updatedEvent);},_uploadProgressHandler:function(event){this.currentUploadedByteValues[event.target.get("id")]=event.bytesLoaded;var updatedEvent=event,uploadedTotal=this.totalBytesUploaded,percentLoaded=Math.min(100,Math.round(10000*uploadedTotal/this.totalBytes)/ 100);updatedEvent.originEvent=event;updatedEvent.file=event.target;this.fire("uploadprogress",updatedEvent);Y.each(this.currentUploadedByteValues,function(value){uploadedTotal+=value;});this.fire("totaluploadprogress",{bytesLoaded:uploadedTotal,bytesTotal:this.totalBytes,percentLoaded:percentLoaded});},startUpload:function(){this.queuedFiles=this.get("fileList").slice(0);this.numberOfUploads=0;this.currentUploadedByteValues={};this.currentFiles={};this.totalBytesUploaded=0;this._currentState=UploaderQueue.UPLOADING;while(this.numberOfUploads<this.get("simUploads")&&this.queuedFiles.length>0){this._startNextFile();}},pauseUpload:function(){this._currentState=UploaderQueue.STOPPED;},restartUpload:function(){this._currentState=UploaderQueue.UPLOADING;while(this.numberOfUploads<this.get("simUploads")){this._startNextFile();}},forceReupload:function(file){var id=file.get("id");if(this.currentFiles.hasOwnProperty(id)){file.cancelUpload();this._unregisterUpload(file);this.addToQueueTop(file);this._startNextFile();}},addToQueueTop:function(file){this.queuedFiles.unshift(file);},addToQueueBottom:function(file){this.queuedFiles.push(file);},cancelUpload:function(file){var id,i,fid;if(file){id=file.get("id");if(this.currentFiles[id]){this.currentFiles[id].cancelUpload();this._unregisterUpload(this.currentFiles[id]);if(this._currentState===UploaderQueue.UPLOADING){this._startNextFile();}}
else{for(i=0,len=this.queuedFiles.length;i<len;i++){if(this.queuedFiles[i].get("id")===id){this.queuedFiles.splice(i,1);break;}}}}
else{for(fid in this.currentFiles){this.currentFiles[fid].cancelUpload();this._unregisterUpload(this.currentFiles[fid]);}
this.currentUploadedByteValues={};this.currentFiles={};this.totalBytesUploaded=0;this.fire("alluploadscancelled");this._currentState=UploaderQueue.STOPPED;}}},{CONTINUE:"continue",STOP:"stop",RESTART_ASAP:"restartasap",RESTART_AFTER:"restartafter",STOPPED:"stopped",UPLOADING:"uploading",NAME:'uploaderqueue',ATTRS:{simUploads:{value:2,validator:function(val){return(val>=1&&val<=5);}},errorAction:{value:"continue",validator:function(val){return(val===UploaderQueue.CONTINUE||val===UploaderQueue.STOP||val===UploaderQueue.RESTART_ASAP||val===UploaderQueue.RESTART_AFTER);}},bytesUploaded:{readOnly:true,value:0},bytesTotal:{readOnly:true,value:0},fileList:{value:[],lazyAdd:false,setter:function(val){var newValue=val;Y.Array.each(newValue,function(value){this.totalBytes+=value.get("size");},this);return val;}},fileFieldName:{value:"Filedata"},uploadURL:{value:""},uploadHeaders:{value:{}},withCredentials:{value:true},perFileParameters:{value:{}},retryCount:{value:3}}});Y.namespace('Uploader');Y.Uploader.Queue=UploaderQueue;},'3.15.0',{"requires":["base"]});