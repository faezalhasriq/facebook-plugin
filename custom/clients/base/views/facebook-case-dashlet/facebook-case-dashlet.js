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
    uid: null,
    token: null,
    page_token: null,
    no_data: false,
    data: [],
    log_level: 'debug',
    app_id: '1846034682318845',
    valid_license: true,
    result_limit: 50,
    /* {bool} Is dashlet currently fetching data? */
    fetching: true,
    /* {bool} Has an error occurred? */
    error: false,
    /* {string} An error message */
    error_message: "",
    /* {string} Name-identifier of the page. eg. www.facebook.com/{examplecompany} */
    page_name: '',
    /* Fetch user acl access */
    user_access: {
        view: App.acl.hasAccess("view", "Cases"),
        edit: App.acl.hasAccess("edit", "Cases")
    },
    events: {
        'click [name=reply_button]': 'replyPostClicked',
        'click [name=create_case_button]': 'createCaseClicked'
    },
    /**
     * @returns {undefined}
     */
    initDashlet: function () {
        this.fetching = true;
        this.no_data = false;
        this.initAutoGrow();
        var self = this;

        // Fetch system-wide settings from admin-configuration
        var app_config = App.metadata.getModule('Cases', 'config');
        if (app_config && !_.isEmpty(app_config)) {
            if (!_.isUndefined(app_config.fb_page_name) && !_.isEmpty(app_config.fb_page_name)) {
                this.page_name = app_config.fb_page_name;
            }
            if (!_.isUndefined(app_config.fb_log_level) && !_.isEmpty(app_config.fb_log_level)) {
                this.log_level = app_config.fb_log_level;
            }
            if (!_.isUndefined(app_config.fb_app_id) && !_.isEmpty(app_config.fb_app_id)) {
                this.app_id = app_config.fb_app_id;
            }
        }

        // Check if managed to fetch facebook app id
        if (!_.isEmpty(this.app_id)) {
            App.api.call('read', "rest/v10/license_validator/facebook", {}, {
                success: _.bind(function (response) {
                    if (response && response.valid && response.valid == true) {
                        this.valid_license = true;

                        if (typeof window.fbAsyncInit == "undefined") {
                            //Initialize facebook scripts
                            window.fbAsyncInit = function () {
                                FB.init({
                                    appId: self.app_id,
                                    xfbml: true,
                                    version: 'v2.8'
                                });
                                self.loadData();
                                // ADD ADDITIONAL FACEBOOK CODE HERE
                            };
                        } else {
                            var runWhenReady = function(){
                                // Wait for the availability of the FB-library
                                if (typeof FB == "undefined"){
                                    setTimeout(runWhenReady, 500);
                                    return;
                                }
                                // Library has been loaded, proceed with loading data
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
                    } else {
                        this.valid_license = false;
                        this.fetching = false;
                        this.error = true;
                        this.error_message = app.lang.get("LBL_FACEBOOK_DASHLET_INVALID_LICENSE_ERROR_MESSAGE");
                        this.logMessage("fatal", "License has expired!");
                        this.render();
                    }
                }, this),
                error: _.bind(function (err) {
                    this.valid_license = false;
                    this.fetching = false;
                    this.error = true;
                    this.error_message = app.lang.get("LBL_FACEBOOK_DASHLET_INVALID_LICENSE_ERROR_MESSAGE");
                    this.logMessage("fatal", "License has expired!");
                    this.render();
                }, this)
            });
        } else {
            this.fetching = false;
            this.error = true;
            this.error_message = app.lang.get("LBL_FACEBOOK_DASHLET_APP_ID_ERROR_MESSAGE");
        }

        // Fetch user defined dashlet settings.
        // If page name is defined in dashlet settigns it will override system-wide setting.
        if (this.settings && this.settings.attributes) {
            var hide_has_cases = this.settings.get("hide_has_cases") || false;
            var page_name = this.settings.get("page_name") || false;

            this.settings.set("hide_has_cases", hide_has_cases);
            this.settings.set("page_name", page_name);

            if (!_.isUndefined(page_name) && !_.isEmpty(page_name)) {
                this.page_name = this.settings.get("page_name");
            }
        }
        
        // If wrong source there is no point in displaying dashlet
        if (!_.isUndefined(this.model.get("source")) && this.model.get("source") != "Facebook") {
            if (this.layout.collapse) {
                this.layout.collapse(true);
            }
            //firing an event to notify dashlet expand / collapse
            this.layout.trigger('dashlet:collapse', true);
        }
    },
    /**
     * @inheritDoc
     *
     * Setup events for rendered fields
     */
    render: function () {
        this._super('render');
        $('.' + this.page_name + ' .comment-link').on("click", this.toggleComments);

        //Initialize logic that makes textarea expand as text gets longer
        $('.fb textarea').autogrow({onInitialize: true});
        $(".reply-area").blur();//Remove focus from input to prevent accidental input
    },
    /**
     * Eventhandler for clicking reply-button
     * 
     * @param {event} evt
     * @returns {undefined}
     */
    replyPostClicked: function (evt) {
        //Disable fields and set as loading while awaiting response
        var comment_text = $("textarea.reply-area[data-id='" + $(evt.currentTarget).data("id") + "']").val();

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
    /**
     * Eventhandler for clicking reply-button
     * 
     * @param {event} evt
     * @returns {undefined}
     */
    createCaseClicked: function (evt) {
        if (!_.isUndefined($(evt.currentTarget).data("caseid"))
                && !_.isEmpty($(evt.currentTarget).data("caseid"))) {
            // Navigare to the related case
            var route = app.router.buildRoute("Cases", $(evt.currentTarget).data("caseid"));
            app.router.navigate(route, {trigger: true});
        } else {
            $(evt.currentTarget).html('<i class="fb fa fa-spinner fa-spin fa-1x"></i>');
            $(evt.currentTarget).addClass("disabled");
            var fb_id = $(evt.currentTarget).data("id");

            var model = app.data.createBean('Cases');
            model.set("facebook_post_id", fb_id);
            model.set("source", "Facebook");

            // Populate model with data from fb-post
            _.each(this.data, _.bind(function (row, index) {
                if (fb_id == row.id) {
                    if (!_.isUndefined(row.message)) {
                        model.set("name", row.message.substr(0, 254));//(name-field maxlength is 255)
                    }

                    var msg = "";
                    msg += !_.isUndefined(row.from) && !_.isUndefined(row.from.name) ? row.from.name + " \n" : "";
                    msg += !_.isUndefined(row.formatted_created_time) ? row.formatted_created_time + " \n" : "";
                    msg += !_.isUndefined(row.external_link) ? row.external_link + " \n" : "";
                    msg += " \n";
                    msg += !_.isUndefined(row.message) ? row.message + " \n" : "";
                    msg += !_.isUndefined(row.link) ? row.link + " \n" : "";

                    model.set("description", msg);
                }
            }, this));

            // Add backwards compatability for Sugar 7.6
            var caseLayout = 'create';
            if (_.isFunction(App.metadata.getServerInfo) &&
                    App.metadata.getServerInfo().version.indexOf('7.6') != -1
                    ) {
                caseLayout = 'create-actions';
            }

            app.drawer.open({
                layout: caseLayout,
                context: {
                    create: true,
                    module: 'Cases',
                    model: model
                }
            }, _.bind(function (refresh, model) {
                // Is run when drawer is closed.

                // Check if case was created
                if (model && !_.isUndefined(model.get("id"))) {
                    $(evt.currentTarget).removeClass("btn-primary");
                    $(evt.currentTarget).html('<i class="fb fa fa-eye fa-1x"></i>');
                    $(evt.currentTarget).data("caseid", model.get("id"));
                    $(evt.currentTarget).attr("title", "View case");
                } else {
                    // User cancelled or error occurred, reset button
                    $(evt.currentTarget).html('<i class="fb fa fa-edit fa-1x"></i>');
                    $(evt.currentTarget).removeClass("disabled");
                }
            }, this));
        }
    },
    /**
     * Post a comment to a post with the page as author
     * 
     * @param {string} object_id
     * @param {string} message
     * @returns {undefined}
     */
    replyToPost: function (object_id, message) {
        if (_.isEmpty(object_id) || _.isEmpty(message)) {
            this.logMessage("error", "Reply failed, no message or no post_id found");
        } else {
            var parsed_post_id = object_id;
            if (object_id.substr(object_id.indexOf("_") + 1).length > 0) {
                parsed_post_id = object_id.substr(object_id.indexOf("_") + 1);
            }

            this.logMessage("info", "User " + App.user.get("user_name") + " commented to post " + parsed_post_id + " with message: " + message);
            FB.api(
                    "/" + object_id + "/comments",
                    "POST",
                    {
                        "access_token": this.page_token,
                        "message": message
                    },
            _.bind(function (response) {
                if (response && !response.error) {
                    // Post was successbull, set reply-button as checkbox
                    $('.btn.reply_button[data-id="' + object_id + '"]').html('<i class="fb fa fa-check fa-1x"></i>');
                } else {
                    $('.btn.reply_button[data-id="' + object_id + '"]').html('<i class="fb fa fa-cross fa-1x"></i>');
                    if (response && response.error) {
                        this.logMessage("fatal", response.error);
                    }
                }
            }, this));
        }
    },
    /**
     * Toggles visibility of comments table
     * 
     * @returns {undefined}
     */
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
    /**
     * Trigger login to facebook and grant app permissions
     * 
     * @returns {Boolean}
     */
    loginToFacebook: function () {
        if (typeof FB == "undefined") {
            return true;
        }

        // Check login status is ok
        FB.getLoginStatus(_.bind(function (response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token 
                // and signed request each expire
                this.uid = response.authResponse.userID;
                this.token = response.authResponse.accessToken;
                // Load token for page, then load data
                this.getPageToken();
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook, 
                // but has not authenticated your app.
                // Retrigger login.
                FB.login(_.bind(function (response) {
                    if (response.authResponse) {
                        // Fetch user info
                        FB.api('/me', _.bind(function (response) {
                            // Load token for page and then load data
                            this.getPageToken();
                        }, this));
                    } else {
                        this.logMessage("warn", "User cancelled login or did not fully authorize. User: " + App.user.get("user_name"));
                        this.logMessage("debug", response);

                        // User cancelled login or did not fully authorize
                        if (console && console.log) {
                            console.log('User cancelled login or did not fully authorize.');
                        }
                        this.fetching = false;
                        this.render();
                    }
                }, this),
                        {
                            scope: 'public_profile,manage_pages,publish_actions,publish_pages'
                        });// Scope = the required user-permissions
            } else {
                // the user isn't logged in to Facebook.
                FB.login(_.bind(function (response) {
                    if (response.authResponse) {
                        FB.api('/me', _.bind(function (response) {
                            // Load token for page and then load data
                            this.getPageToken();
                        }, this));
                    } else {
                        this.logMessage("warn", "User cancelled login or did not fully authorize. User: " + App.user.get("user_name"));
                        this.logMessage("debug", response);
                        // User cancelled login or did not fully authorize
                        this.fetching = false;
                        this.render();
                    }
                }, this),
                        {
                            scope: 'public_profile,manage_pages,publish_actions,publish_pages'
                        });
            }
        }, this));
    },
    /**
     * Get access token for page
     * 
     * @returns {undefined}
     */
    getPageToken: function () {
        // Api call that fetches logged in user's pages with posting permissions.
        // Filtered by name defined in this.page_name
        FB.api(
                "/me/accounts?fields=access_token,id,link,username,perms&username=" + this.page_name,
                _.bind(function (response) {
                    if (response && !response.error && response.data) {
                        // Loop array response.data and set token
                        _.each(response.data, _.bind(function (page_row) {
                            if (page_row.id == this.page_name || this.page_name == page_row.username) {
                                this.page_token = page_row.access_token;
                            }
                        }, this));
                    } else if (response && response.error) {
                        if (console && console.log) {
                            console.log(response.error);
                        }
                        this.logMessage("fatal", response.error);
                        this.fetching = false;
                        this.error = true;
                        this.error_message = response.error;
                    }
                    // Retrigger loading of page data
                    this.loadData({success: false, error: response.error});
                }, this)
                );
    },
    /**
     * Fetch data
     * 
     * @param {object} options
     * @returns {undefined}
     */
    loadData: function (options) {
        if (this.error == true) {
            $('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
            return true;
        }

        // If this.module is "Cases" means we are in recordview of Cases. If so,
        // only load data for that case. If this.module is not "Cases" assume we 
        // are at Home and display a list of posts.
        if (this.module == "Cases") {
            // Check user access. If has no access there is no need to fetch comment-data.
            if (this.user_access.view == false
                    || (!_.isUndefined(this.model.get("source"))
                            && this.model.get("source") != "Facebook")) {
                this.fetching = false;
                this.no_data = true;
                this.render();
                //Make sure refresh-button is reset
                $('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
                return true;
            }

            this.fetching = true;

            // If is new it will not have a facebook id yet
            if (!_.isUndefined(this.model.get("id")) && !_.isEmpty(this.model.get("id"))) {
                var url = app.api.buildURL('Cases/get_facebook_id_by_case', '', {}, {});
                // Fetch facebook id from case and then continue to load data from facebook
                app.api.call('create', url, {'id': this.model.get("id")}, {
                    success: _.bind(function (response) {
                        if (response && response.id && !_.isEmpty(response.id)) {
                            this.data = [];
                            this.data.push({id: response.id});
                        }
                        this.loadFacebookData(options);
                    }, this),
                    error: _.bind(function (err) {
                        this.logMessage("fatal", err);
                    }, this)
                });
            } else {
                this.fetching = false;
            }
        } else {
            this.loadFacebookData(options);
        }
    },
    /**
     * Fetch fata from facebook
     * 
     * @param {object} options
     * @returns {undefined}
     */
    loadFacebookData: function (options) {
        var self = this;

        if (typeof FB != "undefined") {
            this.token = FB.getAccessToken();
        }

        // Check if user is logged in
        if (_.isEmpty(this.token) || _.isEmpty(this.page_token)) {

            if (typeof options == "undefined"
                    || _.isUndefined(options)
                    || _.isEmpty(options)
                    || options.success != false) {
                this.loginToFacebook();//Trigger login and fetch tokens
            } else {
                // Something when wrong judging by {options}
                try {
                    this.logMessage("fatal", "Error occurred while fetching access tokens to page... User: " + App.user.get("user_name"));
                    this.logMessage("fatal", options);

                    this.fetching = false;
                    this.error = true;
                    this.error_message = app.lang.get("LBL_FACEBOOK_DASHLET_TOKEN_ERROR", "Cases");
                    this.render();
                    $('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
                } catch (err) {
                    console.log(err);
                }
            }
        } else {
            if (this.module == "Cases") {
                // Generate tasks for fetching comments & details for all posts
                var tasks = [];
                var ids = [];

                _.each(this.data, _.bind(function (row, index) {
                    ids.push(row.id);
                    row.user_access = this.user_access;// Set user access

                    tasks.push(function (callback) {
                        self.getPostDetails(row, callback);
                    });
                }, this));

                if (ids.length > 0) {
                    tasks.push(_.bind(function (callback) {
                        self.fetchCaseData(ids, callback);
                    }, this));
                } else {
                    tasks.push(function (callback) {
                        callback(null);
                    });
                }

                async.parallel(
                        tasks,
                        _.bind(function (err, results) {
                            //Callback function that is run when 
                            //all tasks in comment_tasks are run.

                            this.fetching = false;
                            this.formatDates();
                            this.render();
                            $('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
                        }, this));
            } else {
                // Start retrieving posts and related data
                FB.api(
                        '/' + this.page_name + '/feed?fields=id,name,from,message,type,object_id,link,created_time,likes,actions,comments{comments{message,from,id,created_time,attachment,likes},message,from,id,created_time,attachment,likes}&limit=' + this.result_limit,
                        'GET',
                        {
                            access_token: this.token
                        },
                _.bind(function (response) {
                    // Is run when call is completed.

                    this.fetching = false;
                    // If "object_id" is set the post is created by page-admin. Ignore these posts.
                    response.data = _.filter(response.data, function (row) {
                        if (!_.isUndefined(row.object_id) && !_.isEmpty(row.object_id)) {
                            return false;
                        }
                        return true;
                    });

                    _.each(response.data, function (row) {
                        row.user_access = self.user_access;// Set user access

                        // Count the number of likes a post has received
                        if (!_.isUndefined(row.likes) && !_.isEmpty(row.likes)) {
                            row.likes_count = row.likes.data.length;
                        } else {
                            row.likes_count = 0;
                        }

                        // Set external link to post
                        if (row.actions && !_.isEmpty(row.actions)) {
                            row.external_link = "";
                            _.each(row.actions, function (action) {
                                if (_.isEmpty(row.external_link) && !_.isUndefined(action.link)) {
                                    row.external_link = action.link;
                                }
                            });
                        } else {
                            row.external_link = "";
                        }

                        if (row.comments && row.comments.data && !_.isEmpty(row.comments.data)) {
                            row.comments = row.comments.data;
                            row.comment_count = row.comments.length;
                            row.has_comments = true;

                            _.each(row.comments, _.bind(function (comment) {
                                // Count the number of likes a post has received
                                if (!_.isUndefined(comment.likes) && !_.isEmpty(comment.likes)) {
                                    comment.likes_count = comment.likes.data.length;
                                } else {
                                    comment.likes_count = 0;
                                }

                                if (comment.comments && comment.comments.data && !_.isEmpty(comment.comments.data)) {
                                    comment.comments = comment.comments.data;
                                    comment.comment_count = comment.comments.length;
                                    comment.has_comments = true;

                                    _.each(comment.comments, _.bind(function (subcomment) {
                                        if (!_.isUndefined(subcomment.likes) && !_.isEmpty(subcomment.likes)) {
                                            subcomment.likes_count = subcomment.likes.data.length;
                                        } else {
                                            subcomment.likes_count = 0;
                                        }
                                    }, this));
                                } else {
                                    comment.comments = [];
                                    comment.comment_count = 0;
                                }
                            }, this));
                        } else {
                            row.comments = [];
                            row.comment_count = 0;
                            //Do not define has_comments as false to make sure .hbs 
                            //can use it to know if the post has comments or not.
                        }
                    });

                    _.extend(this, response);

                    // Generate tasks for fetching comments & details for all posts
                    var tasks = [];
                    var ids = [];
                    _.each(this.data, _.bind(function (row, index) {
                        ids.push(row.id);
                    }, this));

                    if (ids.length > 0) {
                        tasks.push(function (callback) {
                            self.fetchCaseData(ids, callback);
                        });
                    } else {
                        this.no_data = true;
                    }

                    async.parallel(
                            tasks,
                            _.bind(function (err, results) {
                                //Callback function that is run when 
                                //all tasks in comment_tasks are run.

                                // If config hide_has_cases == true, filter entries that already have related Cases
                                if (!_.isUndefined(this.settings.get("hide_has_cases"))
                                        && this.settings.get("hide_has_cases") == true) {

                                    this.data = _.filter(this.data, function (row) {
                                        if (!_.isUndefined(row.has_case) && row.has_case == true) {
                                            return false;
                                        }
                                        return true;
                                    });
                                }

                                this.formatDates();
                                this.render();
                                $('.fa-refresh.fa-spin').removeClass("fa-spin").removeClass('fa-refresh').addClass("fa-cog");
                            }, this));
                }, this));
            }
        }
    },
    /**
     * Fetches data from Cases related to posts
     * 
     * @param {array} ids
     * @param {function} callback
     * @returns {undefined}
     */
    fetchCaseData: function (ids, callback) {
        if (ids && !_.isEmpty(ids)) {
            var url = app.api.buildURL('Cases/get_cases_by_facebook_ids', '', {}, {});

            app.api.call('create', url, {'ids': ids}, {
                success: _.bind(function (response) {
                    // Populate fetched ids to data
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
                    this.logMessage("fatal", err);
                    if (callback) {
                        callback(err);
                    }
                }, this)
            });
        } else {
            if (callback) {
                callback(null);
            }
        }
    },
    /**
     * Call FB-api to fetch post details.
     * Accepts callback-function for use with eg. async.parallel
     * 
     * @param {object} post
     * @param {function} callback
     * @returns {undefined}
     */
    getPostDetails: function (post, callback) {
        var self = this;

        if (post && post.id && !_.isEmpty(post.id)) {
            FB.api(
                    "/" + post.id + "?fields=likes,created_time,from,message,comments{comments{from,created_time,id,likes,message,attachment},from,id,likes,created_time,message,attachment},id,actions",
                    function (response) {
                        if (response && !response.error) {
                            _.each(response, function (val, index) {
                                post[index] = val;
                            });

                            // Set the url to the post
                            if (response.actions && !_.isEmpty(response.actions)) {
                                post.external_link = "";
                                _.each(response.actions, function (action) {
                                    if (!_.isUndefined(action.link)) {
                                        post.external_link = action.link;
                                    }
                                });
                            } else {
                                post.external_link = "";
                            }

                            // Count the number of likes a post has received
                            if (!_.isUndefined(response.likes) && !_.isEmpty(response.likes)) {
                                post.likes_count = response.likes.data.length;
                            } else {
                                post.likes_count = 0;
                            }

                            // Loop through comments
                            if (response.comments && !_.isEmpty(response.comments)) {
                                post.comments = response.comments.data;
                                post.comment_count = post.comments.length;

                                _.each(post.comments, function (row) {
                                    row.user_access = self.user_access;// Set user access

                                    // Count the number of likes a post has received
                                    if (!_.isUndefined(row.likes) && !_.isEmpty(row.likes)) {
                                        row.likes_count = row.likes.data.length;
                                    } else {
                                        row.likes_count = 0;
                                    }

                                    // Set external link to post
                                    if (row.actions && !_.isEmpty(row.actions)) {
                                        row.external_link = "";
                                        _.each(row.actions, function (action) {
                                            if (!_.isUndefined(action.link)) {
                                                row.external_link = action.link;
                                            }
                                        });
                                    } else {
                                        row.external_link = "";
                                    }

                                    if (row.comments && row.comments.data && !_.isEmpty(row.comments.data)) {
                                        row.comments = row.comments.data;
                                        row.comment_count = row.comments.length;
                                        row.has_comments = true;

                                        _.each(row.comments, _.bind(function (comment) {
                                            // Count the number of likes a post has received
                                            if (!_.isUndefined(comment.likes) && !_.isEmpty(comment.likes)) {
                                                comment.likes_count = comment.likes.data.length;
                                            } else {
                                                comment.likes_count = 0;
                                            }

                                            if (comment.comments && comment.comments.data && !_.isEmpty(comment.comments.data)) {
                                                comment.comments = comment.comments.data;
                                                comment.comment_count = comment.comments.length;
                                                comment.has_comments = true;

                                                _.each(comment.comments, _.bind(function (subcomment) {
                                                    if (!_.isUndefined(subcomment.likes) && !_.isEmpty(subcomment.likes)) {
                                                        subcomment.likes_count = subcomment.likes.data.length;
                                                    } else {
                                                        subcomment.likes_count = 0;
                                                    }
                                                }, this));
                                            } else {
                                                comment.comments = [];
                                                comment.comment_count = 0;
                                            }
                                        }, this));
                                    } else {
                                        row.comments = [];
                                        row.comment_count = 0;
                                        //Do not define has_comments as false to make sure .hbs 
                                        //can use it to know if the post has comments or not.
                                    }
                                });
                            } else {
                                post.comments = [];
                                post.comment_count = 0;
                            }
                            
                            self.formatDates();

                            if (callback) {
                                callback(null);
                            }
                        } else if (response && response.error) {
                            /* handle api error */
                            if (console && console.log) {
                                console.log(response.error);
                            }
                            self.logMessage("fatal", response.error);
                            callback(response.error);
                        } else {
                            callback(false);
                        }
                    }
            );
        }
    },
    /**
     * Call FB-api to fetch comments on post. 
     * Accepts callback-function for use with eg. async.parallel
     * 
     * @param {object} post
     * @param {function} callback
     * @returns {undefined}
     */
    getCommentsOnPost: function (post, callback) {
        var self = this;

        if (post && post.id && !_.isEmpty(post.id)) {
            FB.api(
                    "/" + post.id + "/comments?fields=attachment,from,message,created_time,id",
                    function (response) {
                        if (response && !response.error) {
                            // Set the fetched comments in the post-object
                            if (response.data && !_.isEmpty(response.data)) {
                                post.comments = response.data;
                                post.comment_count = post.comments.length;
                                post.has_comments = true;
                            } else {
                                post.comments = [];
                                post.comment_count = 0;
                                //Do not define has_comments as false to make sure .hbs 
                                //can use it to know if the post has comments or not.
                            }

                            if (callback) {
                                callback(null);
                            }
                        } else if (response && response.error) {
                            /* handle api error */
                            if (console && console.log) {
                                console.log(response.error);
                            }
                            self.logMessage("fatal", response.error);
                            callback(response.error);
                        } else {
                            callback(false);
                        }
                    }
            );
        }
    },
    /**
     * Format date times from formats as eg. 2015-11-18T17:17:41+0000 to the users preferences.
     * 
     * @returns {undefined}
     */
    formatDates: function () {
        if (!_.isUndefined(this.data) && !_.isEmpty(this.data)) {
            //Handle all posts
            _.each(this.data, function (row) {
                //Format the created_time on post according to user prefs.
                if (!_.isUndefined(row.created_time)) {
                    row.formatted_created_time = moment(row.created_time).format(moment.getUserDateFormat() + " " + moment.getUserTimeFormat());
                } else {
                    row.formatted_created_time = "";
                }
                //Handle all comments on posts
                if (!_.isUndefined(row.comments) && !_.isEmpty(row.comments)) {
                    _.each(row.comments, function (comment) {
                        if (!_.isUndefined(comment.created_time)) {
                            comment.formatted_created_time = moment(comment.created_time).format(moment.getUserDateFormat() + " " + moment.getUserTimeFormat());
                        } else {
                            comment.formatted_created_time = "";
                        }
                        _.each(comment.comments, function (subcomment) {
                            if (!_.isUndefined(subcomment.created_time)) {
                                subcomment.formatted_created_time = moment(subcomment.created_time).format(moment.getUserDateFormat() + " " + moment.getUserTimeFormat());
                            } else {
                                subcomment.formatted_created_time = "";
                            }
                        });
                    });
                }
            });
        }
    },
    /**
     * Logs message to file
     * 
     * @param {string} level
     * @param {string} message
     * @returns {undefined}
     */
    logMessage: function (level, message) {
        if (_.isUndefined(message) || _.isEmpty(message)) {
            message = "";
        } else if (_.isObject(message)) {
            message = JSON.stringify(message);
        } else {
            message = message.toString();
        }

        var url = app.api.buildURL(undefined, 'logger');
        var params = {
            channel: "Facebook",
            level: level.toLowerCase(),
            message: message
        };
        params.level = "fatal";//Make sure all messages are logged. FBDASH-11

        app.api.call('create', url, params, {
            success: function (data) {
                if (!data.status) {
                    throw 'Failed to write log message {' + message + '} onto server';
                }
            },
            error: function (e) {
                if (console && console.log) {
                    console.log(e);
                }
                throw e;
            }
        });
    },
    /**
     * Script that enables textareas to dynamically grow vertically as user types
     * 
     * @returns {undefined}
     */
    initAutoGrow: function () {
        //pass in just the context as a $(obj) or a settings JS object
        $.fn.autogrow = function (opts) {
            var that = $(this).css({overflow: 'hidden', resize: 'none'}) //prevent scrollies
                    , selector = that.selector
                    , defaults = {
                        context: $(document) //what to wire events to
                        , animate: true //if you want the size change to animate
                        , speed: 200 //speed of animation
                        , fixMinHeight: true //if you don't want the box to shrink below its initial size
                        , cloneClass: 'autogrowclone' //helper CSS class for clone if you need to add special rules
                        , onInitialize: false //resizes the textareas when the plugin is initialized
                    }
            ;
            opts = $.isPlainObject(opts) ? opts : {context: opts ? opts : $(document)};
            opts = $.extend({}, defaults, opts);
            that.each(function (i, elem) {
                var min, clone;
                elem = $(elem);
                //if the element is "invisible", we get an incorrect height value
                //to get correct value, clone and append to the body. 
                if (elem.is(':visible') || parseInt(elem.css('height'), 10) > 0) {
                    min = parseInt(elem.css('height'), 10) || elem.innerHeight();
                } else {
                    clone = elem.clone()
                            .addClass(opts.cloneClass)
                            .val(elem.val())
                            .css({
                                position: 'absolute'
                                , visibility: 'hidden'
                                , display: 'block'
                            })
                            ;
                    $('body').append(clone);
                    min = clone.innerHeight();
                    clone.remove();
                }
                if (opts.fixMinHeight) {
                    elem.data('autogrow-start-height', min); //set min height                                
                }
                elem.css('height', min);

                if (opts.onInitialize && elem.length) {
                    resize.call(elem[0]);
                }
            });
            opts.context
                    .on('keyup paste', selector, resize)
                    ;

            function resize(e) {
                var box = $(this)
                        , oldHeight = box.innerHeight()
                        , newHeight = this.scrollHeight
                        , minHeight = box.data('autogrow-start-height') || 0
                        , clone
                        ;
                if (oldHeight < newHeight) { //user is typing
                    this.scrollTop = 0; //try to reduce the top of the content hiding for a second
                    opts.animate ? box.stop().animate({height: newHeight}, opts.speed) : box.innerHeight(newHeight);
                } else if (!e || e.which == 8 || e.which == 46 || (e.ctrlKey && e.which == 88)) { //user is deleting, backspacing, or cutting
                    if (oldHeight > minHeight) { //shrink!
                        //this cloning part is not particularly necessary. however, it helps with animation
                        //since the only way to cleanly calculate where to shrink the box to is to incrementally
                        //reduce the height of the box until the $.innerHeight() and the scrollHeight differ.
                        //doing this on an exact clone to figure out the height first and then applying it to the
                        //actual box makes it look cleaner to the user
                        clone = box.clone()
                                //add clone class for extra css rules
                                .addClass(opts.cloneClass)
                                //make "invisible", remove height restriction potentially imposed by existing CSS
                                .css({position: 'absolute', zIndex: -10, height: ''})
                                //populate with content for consistent measuring
                                .val(box.val())
                                ;
                        box.after(clone); //append as close to the box as possible for best CSS matching for clone
                        do { //reduce height until they don't match
                            newHeight = clone[0].scrollHeight - 1;
                            clone.innerHeight(newHeight);
                        } while (newHeight === clone[0].scrollHeight);
                        newHeight++; //adding one back eliminates a wiggle on deletion 
                        clone.remove();
                        box.focus(); // Fix issue with Chrome losing focus from the textarea.

                        //if user selects all and deletes or holds down delete til beginning
                        //user could get here and shrink whole box
                        newHeight < minHeight && (newHeight = minHeight);
                        oldHeight > newHeight && opts.animate ? box.stop().animate({height: newHeight}, opts.speed) : box.innerHeight(newHeight);
                    } else { //just set to the minHeight
                        box.innerHeight(minHeight);
                    }
                }
            }
            return that;
        }
    }

})
