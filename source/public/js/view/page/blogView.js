define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/page/blog.html',
    'text!templates/page/feed/title.html',
    'view/post/postView'
],
function ($, _, Backbone, blogTemplate, feedTitleTemplate, PostView) {
    'use strict';
    app.BlogView = Backbone.View.extend({
        //events:{
        //  'click .auth': 'auth'
        //},

        tagName: "div",
        tpl: _.template(blogTemplate),
        tplTitle: _.template(feedTitleTemplate),
        postsCollection: false,

        initialize: function (data) {
            this.postsCollection = data.postsCollection;
            this.render();
        },

        render: function () {
            this.$el.append(this.tplTitle());

            if (this.postsCollection.size() <= 0) {
                this.$el.html(this.tpl());
                return this;
            }

            this.postsCollection.each(function (item) {
                var item = new PostView({model: item});
                this.$el.append(item.el);
            }, this);

            return this;
        }
    });

    return app.BlogView;
});