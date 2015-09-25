define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/page/blog.html',
    'view/post/postView'
],
function ($, _, Backbone, blogTemplate, PostView) {
    'use strict';
    app.BlogView = Backbone.View.extend({
        //events:{
        //  'click .auth': 'auth'
        //},

        tagName: "div",
        tpl: _.template(blogTemplate),
        postsCollection: false,

        initialize: function (data) {
            this.postsCollection = data.postsCollection;
            this.render();
        },

        render: function () {
            this.postsCollection.each(function (item) {
                var item = new PostView({model: item});
                this.$el.append(item.el);
            }, this);

            return this;
        }
    });

    return app.BlogView;
});