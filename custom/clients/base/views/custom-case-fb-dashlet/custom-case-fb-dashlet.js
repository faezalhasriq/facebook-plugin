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
({
    plugins: ['Dashlet'],
	app_id: '1846034682318845',
	page_id: '185059835322329',
	user_id: null,
	access_token: null, // user's access token
	page_token: null, // page's access token
	data: [],
	fb_data: [],
	user: [],
	case_data: [],
	events: {
		'click [name=reply_button]': 'replyPostClicked',
		'click [name=fb_logout]': 'fbLogout',
		'click [name=fb_login]': 'fbLogin'
    },
	//is_fb_init: false,
	
	initDashlet: function () {
		this.on('render', this.initFB);
    },
	
	render: function () {
        this._super('render');
        $('.comment-link').on("click", this.toggleComments);
    },
	
	initFB: function(){
		//if(this.is_fb_init == false){
		var obj = this;
		
		window.fbAsyncInit = function() {
			FB.init({
				appId: obj.app_id,
				status: true,
				cookie: true,
				xfbml: true,
				version: 'v2.8'
			});

			FB.getLoginStatus(function (response) {
				if (response.status === 'connected') {
					// to get access token.
					this.access_token = response.authResponse.accessToken;
					this.user_id = response.authResponse.userID;
					//console.log(this.access_token);
					//console.log(this.user_id);
					
					// to get login detail of user.
					FB.api('/me', {fields: 'id, first_name, last_name'}, function(response) {
						obj.user.push({
							first_name: response.first_name,
							last_name: response.last_name,
							user_id: response.id
						})
						$.each(obj.user, _.bind(function(key, value) {
							obj.render();
						},self));
					});
					
					FB.api('/me/accounts', {fields: 'access_token, id, link, username'}, function(response) {
						_.each(response.data, _.bind(function (page_row) {
							if (obj.page_id == page_row.id) {
								obj.page_token = page_row.access_token;
							}
						}, this));
					});
					
					// to get post feeds in facebook page. including visitors comments.
					FB.api('/' + obj.page_id + '/feed',{fields: 'message, id, created_time, from, likes, comments{comments{message,from,id,created_time,attachment,likes},message,from,id,created_time,attachment,likes}'}, function(response) {
						//console.log(response);
						var visitor_post = response.data;

						for (var i = 0; i < visitor_post.length; i += 1) {
							obj.fb_data.push({
								message: visitor_post[i].message,
								id: visitor_post[i].id,
								created_time: visitor_post[i].created_time,
								from: visitor_post[i].from.name,
								from_id: "https://www.facebook.com/" + visitor_post[i].from.id,
								comment: visitor_post[i].comments,
								likes: visitor_post[i].likes
							});
						}
						
						sritems = {};
						var i=0;
						//var self = this;
						$.each(obj.fb_data, _.bind(function(key, value) {
							   self.sritems[i] = value;
							   obj.render();
							  i++;
							  },self));
						//debugger;
						// why required this one? 
						// related in createCaseClicked()
						obj.data = Object.assign(obj.fb_data);
					});
					
					FB.api('/me/accounts', function(response) {
						//console.log(response);
					});
				}
			});
			
			//obj.caseFbDashlet();
			
			if(obj.module == "Cases")
			{
				//console.log('is this cases module?');
				var facebook_post_id = obj.model.get("facebook_post_id");
				//console.log(facebook_post_id);
				FB.api('/' + facebook_post_id,
				{fields: 'id, message, from, likes, created_time, comments{comments{message, from, id, likes, created_time}, message, from, id, likes, created_time}'}, function(response){
					
					obj.case_data = [];
					obj.case_data.push({
						id: response.id,
						message: response.message,
						from: response.from,
						from_id: "https://www.facebook.com/" + response.from.id,
						comments: response.comments,
						likes: response.likes
					});
					//console.log(obj.case_data);
					$.each(obj.case_data, _.bind(function(key, value) {
						obj.render();
					},self));
					//obj.data = Object.assign(obj.case_data);
					//debugger;
					
				});
			}
		};
		
		
		
		// JS SDK - this will be loaded asynchronously
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));	
	//}
	},
	
	toggleComments: function () {
		if ($(this).closest("tbody").children(".comment.head").is(":hidden")) {
            $(this).closest("tbody").children(".comment.head").show();
            $(this).closest("tbody").children(".comment.body").show();
        } else {
            $(this).closest("tbody").children(".comment.head").hide();
            $(this).closest("tbody").children(".comment.body").hide();
        }
        if ($(this).closest("tbody").children(".reply").is(":hidden")) {
            $(this).closest("tbody").children(".reply").show();
        } else {
            $(this).closest("tbody").children(".reply").hide();
        }
    },
	
	replyPostClicked: function (evt) {
        //Disable fields and set as loading while awaiting response
        var comment_text = $("textarea.reply-area[data-id='" + $(evt.currentTarget).data("id") + "']").val();
		console.log(comment_text);
        if (!_.isUndefined(comment_text) && !_.isEmpty(comment_text)) {
            $(evt.currentTarget).html('<i class="fb fa fa-spinner fa-spin fa-1x"></i>');
            $(evt.currentTarget).addClass("disabled");
            $("textarea.reply-area[data-id='" + $(evt.currentTarget).data("id") + "']").attr("disabled", true);

            //Send comment to api
            this.replyToPost($(evt.currentTarget).data("id"), comment_text);
        } else {
            // TODO: Display error/warning when no message is set
        }
    },
	
	replyToPost: function (object_id, message) {
        if (_.isEmpty(object_id) || _.isEmpty(message)) {
            console.log("error", "Reply failed, no message or no post_id found");
        } else {
            var parsed_post_id = object_id;
            if (object_id.substr(object_id.indexOf("_") + 1).length > 0) {
                parsed_post_id = object_id.substr(object_id.indexOf("_") + 1);
            }

            console.log("info", "User " + App.user.get("user_name") + " commented to post " + parsed_post_id + " with message: " + message);
            FB.api("/" + object_id + "/comments",
					"POST",
					{
						"access_token": this.page_token,
						"message": message
					},
            _.bind(function (response) {
                if (response && !response.error) {
                    // Post was successfull, set reply-button as checkbox
                    $('.btn.reply_button[data-id="' + object_id + '"]').html('<i class="fb fa fa-check fa-1x"></i>');
                } else {
                    $('.btn.reply_button[data-id="' + object_id + '"]').html('<i class="fb fa fa-cross fa-1x"></i>');
                    if (response && response.error) {
                        console.log("fatal", response.error);
                    }
                }
            }, this));
        }
    },
	
	fbLogout: function(){
		FB.logout(function (response) {
            //Do what ever you want here when logged out like reloading the page
            window.location.reload();
        });
	},
	
	fbLogin: function(){
		FB.login(function(response) {
		  // handle the response
		  window.location.reload();
		}, {scope: 'email,publish_actions,publish_pages,manage_pages'});
	},
	
	caseFbDashlet: function(){
		//var self = this;
		if(this.module == "Cases")
		{
			//console.log('is this cases module?');
			var facebook_post_id = this.model.get("facebook_post_id");
			//console.log(facebook_post_id);
			FB.api('/' + facebook_post_id,
			{fields: 'id, message, from, comments{comments{message, from, id, likes}, message, from, id, likes}'}, function(response){
				
				this.case_data = [];
				this.case_data.push({
					id: response.id,
					message: response.message,
					from: response.from,
					comments: response.comments
				});
				//console.log(this.case_data);
				/* $.each(this.case_data, _.bind(function(key, value) {
					self.render();
				},self)); */
				//obj.data = Object.assign(obj.case_data);
				//debugger;
				
			});
			//this.on('render');
		}
	},
})