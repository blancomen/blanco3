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

    '../collections/postsCollection',
], function ($, Bootstrap, Backbone, MainView, MainMenuView, MainFooterView, LoadingView,
     BlogView, SiteView, InterestView,
     PostsCollection) {
    'use strict';

    app.Router = Backbone.Router.extend({
        routes: {
            '': 'getMainPage',
            'blog': 'getBlogPage',
            'site': 'getSitePage',
            'interest': 'getInterestPage'
            //'main/:id': 'getPost',
            //'access_token=:token': 'getAccessToken'
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
            window.location.hash = 'blog';
        },
        getBlogPage: function() {
            this.renderLoadingView();

            var postsCollection = new PostsCollection();

            postsCollection.fetch({
                url: '?action=get/posts'
            }).complete(function() {
                app.mainView.contentView = new BlogView({postsCollection: postsCollection});
                app.mainView.renderContent();
            });

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
        }
    });

    return app.Router;
});