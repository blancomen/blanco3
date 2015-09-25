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
    '../view/page/interestView'
], function ($, Bootstrap, Backbone, MainView, MainMenuView, MainFooterView, LoadingView,
     BlogView, SiteView, InterestView) {
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

            app.mainView.contentView = new BlogView();
            app.mainView.renderContent();
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
        }
    });

    return app.Router;
});