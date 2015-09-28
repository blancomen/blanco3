define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/page/addPost.html'
],
function ($, _, Backbone, addPostTemplate) {
    'use strict';
    app.AddPostView = Backbone.View.extend({
        events:{
          'submit #add-post': 'addPost'
        },

        tagName: "div",
        tpl: _.template(addPostTemplate),

        initialize: function () {
          this.render();
        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        },

        addPost: function(event) {
            event.preventDefault();

            var data = $('#add-post').serialize();
            $.post('?action=post/add&' + data, function(response) {
                window.location.hash = '/feed/main';
            });
        }
    });

    return app.AddPostView;
});