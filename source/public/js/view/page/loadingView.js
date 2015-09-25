define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/main/loading.html'
],
function ($, _, Backbone, loadingTemplate) {
    'use strict';
    app.LoadingView = Backbone.View.extend({
        //events:{
        //  'click .auth': 'auth'
        //},

        tagName: "div",
        tpl: _.template(loadingTemplate),

        initialize: function () {
          this.render();
        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        }
    });

    return app.LoadingView;
});