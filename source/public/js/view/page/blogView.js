define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/page/blog.html'
],
function ($, _, Backbone, blogTemplate) {
    'use strict';
    app.BlogView = Backbone.View.extend({
        //events:{
        //  'click .auth': 'auth'
        //},

        tagName: "div",
        tpl: _.template(blogTemplate),

        initialize: function () {
            this.render();
        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        }
    });

    return app.BlogView;
});