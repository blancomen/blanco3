define([
    'jquery',
    'bootstrap',
    'backbone',
    '../view/mainView',
    '../view/main/mainMenu',
    '../view/main/mainFooter',
    '../view/page/loadingView',
    '../view/page/blogView',
    '../view/page/siteView',
    '../view/page/interestView',
    '../view/page/addPostView',

    '../view/error404View',
    '../collections/postsCollection'
], function ($, Bootstrap, Backbone, MainView, MainMenuView, MainFooterView, LoadingView,
     BlogView, SiteView, InterestView, AddPostView,
     Error404View, PostsCollection) {
    'use strict';

    app.Router = Backbone.Router.extend({
        routes: {
            '': 'getMainPage',
            'blog': 'getBlogPage',
            'site': 'getSitePage',
            'interest': 'getInterestPage',
            'feed/:feed': 'getFeed',
            'feed/tag/:tag': 'getFeedTag',
            'feed/user/:user_id': 'getFeedUser',

            'post/add': 'getPostAddView',

            "*actions" : "show404Page"
        },
        initialize: function () {
            app.mainView = new MainView({ router: this });
            app.mainView.headerView = new MainMenuView();
            app.mainView.contentView = new LoadingView();
            app.mainView.footerView = new MainFooterView();

            app.mainView.render();
        },

        getMainPage: function () {
            this.renderLoadingView();
            window.location.hash = '/feed/main';
        },
        getBlogPage: function() {
            this.renderLoadingView();
        },
        getSitePage: function() {
            this.renderLoadingView();

            app.mainView.contentView = new SiteView();
            app.mainView.renderContent();
        },
        getInterestPage: function() {
            this.renderLoadingView();

            app.mainView.contentView = new InterestView();
            app.mainView.renderContent();
        },

        getFeed: function(feed) {
            this.renderLoadingView();

            var postsCollection = new PostsCollection();

            postsCollection.fetch({
                url: '?action=get/feed&feed=' + feed
            }).complete(function() {
                app.mainView.contentView = new BlogView({postsCollection: postsCollection});
                app.mainView.renderContent();
            });
        },
        getFeedTag: function(tag) {
            var postsCollection = new PostsCollection();

            postsCollection.fetch({
                url: '?action=get/feed&feed=tag:' + tag
            }).complete(function() {
                app.mainView.contentView = new BlogView({postsCollection: postsCollection});
                app.mainView.renderContent();
            });
        },
        getFeedUser: function(userId) {
            var postsCollection = new PostsCollection();

            postsCollection.fetch({
                url: '?action=get/feed&feed=user:' + userId
            }).complete(function() {
                app.mainView.contentView = new BlogView({postsCollection: postsCollection});
                app.mainView.renderContent();
            });
        },

        getPostAddView: function() {
            app.mainView.contentView = new AddPostView();
            app.mainView.renderContent();
        },

        renderLoadingView: function() {
            app.mainView.contentView = new LoadingView();
            app.mainView.renderContent();
        },

        getPosts: function () {
            return $.ajax({
                method: 'get',
                url: '/',
                data: {
                    action: 'get/posts'
                },
                success: function(response) {
                    app.photosCollection = new PostsCollection(response);
                    console.log(response);
                }
            })
        },

        show404Page: function() {
            app.mainView.contentView = new Error404View();
            app.mainView.renderContent();
        }
    });

    return app.Router;
});