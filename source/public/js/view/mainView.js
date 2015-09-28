define([
    'jquery',
    'underscore',
    'backbone'
],
function ($, _, Backbone) {
    'use strict';

    app.MainView = Backbone.View.extend({
        el: $("#app"),

        headerView: false,
        contentView: false,
        footerView: false,

        events: {
          'click .logout' : 'logout'
        },

        initialize: function () {

        },

        render: function () {
            var el = this.$el;
            var header  = el.find('.app-header');
            var footer  = el.find('.app-footer');

            header.html(this.headerView.$el);
            this.renderContent();
            footer.html(this.footerView.$el);

            return this;
        },

        renderContent: function() {
            var content = this.$el.find('.app-content');
            content.html(this.contentView.$el);
        },

        logout: function() {
            console.log("HELL");
            this.deleteCookie('PHPSESSID', null);
            location.reload();
            return false;
        },

        deleteCookie: function(name) {
            document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
    });
    return app.MainView;
});