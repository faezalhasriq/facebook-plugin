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
    user_id: '',
    access_token: '',
    page_token: '',
	page_name: '',
	page_id: '',
    app_id: '',
	no_data: false,
    data: [],
    result_limit: '',
    fetching_data: true,

    events: {
        'click [name=reply_button]': 'replyPost',
        'click [name=create_case_button]': 'createCase',
		'click [name=fb_logout]': 'fbLogout'
    },

    initDashlet: function() {
		this.app_id = App.config.app_id;
		this.page_id = App.config.page_id;
		this.page_name = App.config.page_name;
        this.fetching_data = true;
        this.no_data = false;
        var self = this;
		
        // check if managed to fetch facebook app id
        if (!_.isEmpty(this.app_id)) {
			if (typeof window.fbAsyncInit == "undefined") {
				//Initialize facebook scripts
				window.fbAsyncInit = function () {
					FB.init({
						appId: self.app_id,
						xfbml: true,
						version: 'v2.8'
					});
					self.loadData();
					//ADD ADDITIONAL FACEBOOK CODE HERE
				};
			} 
			else {
				var runWhenReady = function(){
					//Wait for the availability of the FB-library
					if (typeof FB == "undefined"){
						setTimeout(runWhenReady, 500);
						return;
					}
					self.loadData();
				};
				runWhenReady();
			}

			//Load facebook-scripts
			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {
					return;
				}
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
        } 
		else {
            this.fetching_data = false;
            console.log('Invalid APP ID');
        }
    },

    render: function() {
        this._super('render');
        $('.' + this.page_name + ' .comment-link').on("click", this.toggleComments);
    },
	
	fbLogout: function(){
		FB.logout(function (response) {
            window.location.reload();
        });
	},
	
    loginToFacebook: function() {
        if (typeof FB == "undefined") {
            return true;
        }

        // check login status
        FB.getLoginStatus(_.bind(function (response) {
            if (response.status === 'connected') {
				console.log('connected');
                this.user_id = response.authResponse.userID;
                this.access_token = response.authResponse.accessToken;
                this.getPageAccessToken();
            }  
			else {
                // if not logged in then trigger facebook login popup
                FB.login(_.bind(function (response) {
					console.log('not connected');
                    if (response.authResponse) {
                        FB.api('/me', _.bind(function (response) {
                            // load token for page and then load data
                            this.getPageAccessToken();
                        }, this));
                    } 
					else {
                        console.log("User cancelled login or did not fully authorize. User: " + App.user.get("user_name"));
                        console.log(response);
                        this.fetching_data = false;
                        this.render();
                    }
                }, this), {scope: 'email, publish_actions, publish_pages, manage_pages, public_profile'}); // scope is fb permission allowed
            }
        }, this));
    },

    getPageAccessToken: function() {
        FB.api('/me/accounts', {fields: 'access_token, id, link, username, perms'}, _.bind(function (response) {
			if (response && !response.error && response.data) {
				_.each(response.data, _.bind(function (page_row) {
						this.page_token = page_row.access_token;
						console.log('pageToken: ' + this.page_token);
				}, this));
			} 
			else if (response && response.error) {
				console.log(response.error);
				this.fetching_data = false;
			}
			// retrigger loading of page data
			this.loadData({success: false, error: response.error});
		}, this));
    },

    loadData: function (options) {
        if (this.error == true) {
            $('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
            $('.icon-refresh.icon-spin').removeClass("icon-spin").removeClass('icon-refresh').addClass("icon-cog");
            return true;
        }
		
        if (this.module == "Cases") {
			// for case module
            this.fetching_data = true;
            if (!_.isUndefined(this.model.get("id")) && !_.isEmpty(this.model.get("id"))) {
                var url = app.api.buildURL('Cases/get_facebook_id_by_case', '', {}, {});
                app.api.call('create', url, {'id': this.model.get("id")}, {
                    success: _.bind(function (response) {
                        if (response && response.id && !_.isEmpty(response.id)) {
                            this.data = [];
                            this.data.push({id: response.id});
                        }
                        this.loadFacebookData(options);
                    }, this),
                    error: _.bind(function (err) {
                        console.log(err);
                    }, this)
                });
            } 
			else {
                this.fetching_data = false;
            }
        } 
		else {
			// for home module
            this.loadFacebookData(options);
        }
    },

    loadFacebookData: function (options) {
		this.result_limit = App.config.result_limit;
        var self = this;

        if (typeof FB != "undefined") {
            this.access_token = FB.getAccessToken();
        }
		//debugger;
        // check if user is logged in
        if (_.isEmpty(this.access_token) || _.isEmpty(this.page_token)) {
			this.loginToFacebook();
        } 
		else {
			if (this.module == "Cases") {
				var tasks = [];
                var ids = [];

                _.each(this.data, _.bind(function (row, index) {
                    ids.push(row.id);
                    tasks.push(function (callback) {
						// get post details for for that case
                        self.getPostDetails(row, callback);
                    });
                }, this));

                if (ids.length > 0) {
                    tasks.push(_.bind(function (callback) {
                        self.getCaseData(ids, callback);
                    }, this));
                } 
				else {
                    tasks.push(function (callback) {
                        callback(null);
                    });
                }

                async.parallel(tasks, _.bind(function (err, results) {
					this.fetching_data = false;
					this.render();
					$('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
					$('.icon-refresh.icon-spin').removeClass("icon-spin").removeClass('icon-refresh').addClass("icon-cog");
				}, this));
            } 
			else {
                // for Home module, retrieve all facebook posts
                FB.api('/' + this.page_id + '/feed', {fields: 'id, name, from, message, type, object_id, link, created_time, likes, actions, comments{comments{message, from, id, created_time, attachment, likes}, message, from, id, created_time, attachment, likes}'}, _.bind(function (response) {
                    this.fetching_data = false;
                    response.data = _.filter(response.data, function (row) {
                        // ignore post from admin page
						if (row.from.id == self.page_id) {
                            return false;
                        }
						// retrieve only from visitor post
                        return true;
                    });
                    _.each(response.data, function (row) {
                        // get total number of likes from post
                        if (!_.isUndefined(row.likes) && !_.isEmpty(row.likes)) {
                            row.likes_count = row.likes.data.length;
                        } 
						else {
                            row.likes_count = 0;
                        }

                        // set external link to post
                        if (row.actions && !_.isEmpty(row.actions)) {
                            row.external_link = '';
                            _.each(row.actions, function (action) {
                                if (_.isEmpty(row.external_link) && !_.isUndefined(action.link)) {
                                    row.external_link = action.link;
                                }
                            });
                        } 
						else {
                            row.external_link = '';
                        }

                        if (row.comments && row.comments.data && !_.isEmpty(row.comments.data)) {
                            row.comments = row.comments.data;
                            row.comment_count = row.comments.length;
                            row.has_comments = true;

                            _.each(row.comments, _.bind(function (comment) {
                                // get total number of likes from post
                                if (!_.isUndefined(comment.likes) && !_.isEmpty(comment.likes)) {
                                    comment.likes_count = comment.likes.data.length;
                                } 
								else {
                                    comment.likes_count = 0;
                                }

                                if (comment.comments && comment.comments.data && !_.isEmpty(comment.comments.data)) {
                                    comment.comments = comment.comments.data;
                                    comment.comment_count = comment.comments.length;
                                    comment.has_comments = true;

                                    _.each(comment.comments, _.bind(function (subcomment) {
                                        if (!_.isUndefined(subcomment.likes) && !_.isEmpty(subcomment.likes)) {
                                            subcomment.likes_count = subcomment.likes.data.length;
                                        } 
										else {
                                            subcomment.likes_count = 0;
                                        }
                                    }, this));
                                } 
								else {
                                    comment.comments = [];
                                    comment.comment_count = 0;
                                }
                            }, this));
                        } 
						else {
                            row.comments = [];
                            row.comment_count = 0;
                        }
                    });

                    _.extend(this, response);
                    var tasks = [];
                    var ids = [];
                    _.each(this.data, _.bind(function (row, index) {
                        ids.push(row.id);
                    }, this));

                    if (ids.length > 0) {
                        tasks.push(function (callback) {
                            self.getCaseData(ids, callback);
                        });
                    } 
					else {
                        this.no_data = true;
                    }

                    async.parallel(tasks, _.bind(function (err, results) {
						this.render();
						$('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
						$('.icon-refresh.icon-spin').removeClass("icon-spin").removeClass('icon-refresh').addClass("icon-cog");
					}, this));
					//debugger;
                }, this));
            }
        }
		//debugger;
		//console.log(this.data);
    },

    getCaseData: function (ids, callback) {
        if (ids && !_.isEmpty(ids)) {
            var url = app.api.buildURL('Cases/get_cases_by_facebook_ids', '', {}, {});
            app.api.call('create', url, {'ids': ids}, {
                success: _.bind(function (response) {
                    if (response && !_.isEmpty(response)) {
                        _.each(response, _.bind(function (sugar_id, fb_id) {
                            _.each(this.data, _.bind(function (row) {
                                if (fb_id == row.id) {
                                    row.case_id = sugar_id;
                                    row.has_case = true;
                                }
                            }, this));
                        }, this));
                    }
                    if (callback) {
                        callback(null);
                    }
                }, this),
                error: _.bind(function (err) {
                    console.log(err);
                    if (callback) {
                        callback(err);
                    }
                }, this)
            });
        } 
		else {
            if (callback) {
                callback(null);
            }
        }
    },

    getPostDetails: function (post, callback) {
        var self = this;
        if (post && post.id && !_.isEmpty(post.id)) {
            FB.api('/' + post.id, {fields: 'likes, created_time, from, message, comments{comments{from, created_time, id, likes, message, attachment}, from, id, likes, created_time, message, attachment}, id, actions'}, function (response) {
					if (response && !response.error) {
						_.each(response, function (val, index) {
							post[index] = val;
						});
						
						if (response.actions && !_.isEmpty(response.actions)) {
							post.external_link = '';
							_.each(response.actions, function (action) {
								if (!_.isUndefined(action.link)) {
									post.external_link = action.link;
								}
							});
						} 
						else {
							post.external_link = '';
						}

						// get total number of likes from post
						if (!_.isUndefined(response.likes) && !_.isEmpty(response.likes)) {
							post.likes_count = response.likes.data.length;
						} 
						else {
							post.likes_count = 0;
						}

						if (response.comments && !_.isEmpty(response.comments)) {
							post.comments = response.comments.data;
							post.comment_count = post.comments.length;

							_.each(post.comments, function (row) {
								// get total number of likes from post
								if (!_.isUndefined(row.likes) && !_.isEmpty(row.likes)) {
									row.likes_count = row.likes.data.length;
								} 
								else {
									row.likes_count = 0;
								}

								// set external link to post
								if (row.actions && !_.isEmpty(row.actions)) {
									row.external_link = '';
									_.each(row.actions, function (action) {
										if (!_.isUndefined(action.link)) {
											row.external_link = action.link;
										}
									});
								} 
								else {
									row.external_link = '';
								}

								if (row.comments && row.comments.data && !_.isEmpty(row.comments.data)) {
									row.comments = row.comments.data;
									row.comment_count = row.comments.length;
									row.has_comments = true;

									_.each(row.comments, _.bind(function (comment) {
										// get total number of likes from post
										if (!_.isUndefined(comment.likes) && !_.isEmpty(comment.likes)) {
											comment.likes_count = comment.likes.data.length;
										} 
										else {
											comment.likes_count = 0;
										}

										if (comment.comments && comment.comments.data && !_.isEmpty(comment.comments.data)) {
											comment.comments = comment.comments.data;
											comment.comment_count = comment.comments.length;
											comment.has_comments = true;

											_.each(comment.comments, _.bind(function (subcomment) {
												if (!_.isUndefined(subcomment.likes) && !_.isEmpty(subcomment.likes)) {
													subcomment.likes_count = subcomment.likes.data.length;
												} 
												else {
													subcomment.likes_count = 0;
												}
											}, this));
										} 
										else {
											comment.comments = [];
											comment.comment_count = 0;
										}
									}, this));
								} 
								else {
									row.comments = [];
									row.comment_count = 0;
								}
							});
						} 
						else {
							post.comments = [];
							post.comment_count = 0;
						}

						if (callback) {
							callback(null);
						}
					} 
					else if (response && response.error) {
						/* handle api error */
						if (console && console.log) {
							console.log(response.error);
						}
						callback(response.error);
					} 
					else {
						callback(false);
					}
				}
            );
        }
    },

    createCase: function (evt) {
		// go to case record view if case already created
        if (!_.isUndefined($(evt.currentTarget).data("caseid")) && !_.isEmpty($(evt.currentTarget).data("caseid"))) {
            var route = app.router.buildRoute("Cases", $(evt.currentTarget).data("caseid"));
            app.router.navigate(route, {trigger: true});
        }
		// no case id, create a new case
		else {
            $(evt.currentTarget).html('<i class="fb fa fa-spinner fa-spin fa-1x icon icon-spinner icon-spin"></i>');
            $(evt.currentTarget).addClass("disabled");
            var fb_id = $(evt.currentTarget).data("id");

            var model = app.data.createBean('Cases');
            model.set("facebook_post_id", fb_id);
            model.set("source", "Facebook");

            _.each(this.data, _.bind(function (row, index) {
                if (fb_id == row.id) {
                    if (!_.isUndefined(row.message)) {
                        model.set("name", "[CASE] " + row.message.substr(0, 126));
                    }
					
                    var desc = '';
                    desc += "From: " + row.from.name + " \n";
                    desc += "Created Time: " + row.created_time + " \n";
                    desc += "Facebook Link: " + row.external_link + " \n";
                    desc += "\n";
                    desc += "Message: " + row.message + " \n";
                    model.set("description", desc);
                }
            }, this));

            app.drawer.open({
                layout: 'create',
                context: {
                    create: true,
                    module: 'Cases',
                    model: model
                }
            }, _.bind(function (refresh, model) {
                // check if case was created
                if (model && !_.isUndefined(model.get("id"))) {
                    $(evt.currentTarget).removeClass("btn-primary");
                    $(evt.currentTarget).html('<i class="fb fa fa-eye fa-1x icon icon-eye-open"></i>');
                    $(evt.currentTarget).data("caseid", model.get("id"));
                    $(evt.currentTarget).attr("title", "View case");
                } 
				else {
                    // user cancelled or error occurred, reset button
                    $(evt.currentTarget).html('<i class="fb fa fa-edit fa-1x icon icon-edit"></i>');
                    $(evt.currentTarget).removeClass("disabled");
                }
            }, this));
        }
    },

	replyPost: function (evt) {
        var reply_text = $("textarea.reply-area[data-id='" + $(evt.currentTarget).data("id") + "']").val();

        if (!_.isUndefined(reply_text) && !_.isEmpty(reply_text)) {
            $(evt.currentTarget).html('<i class="fb fa fa-spinner fa-spin fa-1x icon icon-spinner icon-spin"></i>');
            $(evt.currentTarget).addClass("disabled");
            $("textarea.reply-area[data-id='" + $(evt.currentTarget).data("id") + "']").attr("disabled", true);
            // send comment to reply api
            this.replyPostApi($(evt.currentTarget).data("id"), reply_text);
        } 
		else {
			// display error when no message is set
			app.alert.show('empty-reply-msg', {
				level: 'error',
				messages: 'Message is not set.',
				autoClose: true
			});
			$("textarea.reply-area[data-id='" + $(evt.currentTarget).data("id") + "']").focus();
        }
    },
	
    replyPostApi: function (object_id, message) {
        if (_.isEmpty(object_id) || _.isEmpty(message)) {
             console.log("Reply failed, no message or no post_id found");
        } 
		else {
            console.log("User " + App.user.get("user_name") + " commented to post " + object_id + " with message: " + message);
            FB.api('/' + object_id + '/comments', 'POST', {'access_token': this.page_token, 'message': message}, _.bind(function (response) {
                if (response && !response.error) {
                    $('.btn.reply_button[data-id="' + object_id + '"]').html('<i class="fb fa fa-check fa-1x icon icon-check"></i>');
                } 
				else {
                    $('.btn.reply_button[data-id="' + object_id + '"]').html('<i class="fb fa fa-cross fa-1x icon icon-remove"></i>');
                    if (response && response.error) {
                        console.log(response.error);
                    }
                }
            }, this));
        }
    },

    toggleComments: function () {
        if ($(this).closest("tbody").children(".comment.head").is(":hidden")) {
            $(this).closest("tbody").children(".comment.head").show();
            $(this).closest("tbody").children(".comment.body").show();
        } 
		else {
            $(this).closest("tbody").children(".comment.head").hide();
            $(this).closest("tbody").children(".comment.body").hide();
        }
        if ($(this).closest("tbody").children(".reply").is(":hidden")) {
            $(this).closest("tbody").children(".reply").show();
        } 
		else {
            $(this).closest("tbody").children(".reply").hide();
        }
    }
})
