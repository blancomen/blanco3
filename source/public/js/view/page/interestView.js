define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/page/interest.html'
],
function ($, _, Backbone, blogTemplate) {
    'use strict';
    app.InterestView = Backbone.View.extend({
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

    return app.InterestView;
});