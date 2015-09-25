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
        }
    });
    return app.MainView;
});