define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/post/post.html'
],
function ($, _, Backbone, postTempalte) {
    'use strict';
    app.PostView = Backbone.View.extend({
        //events:{
        //    'click .photo': 'auth'
        //},
        tpl: _.template(postTempalte),
        tagName: 'div',
        className:'post-wrap',
        initialize: function () {
            this.render();
        },

        render: function () {
            this.$el.append(this.tpl(this.model.toJSON()));
            return this;
        }
    });

    return app.PostView;
});