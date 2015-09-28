define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/error404.html'
],
function ($, _, Backbone, errorTempalte) {
    'use strict';
    app.Error404View = Backbone.View.extend({
        //events:{
        //    'click .photo': 'auth'
        //},
        tpl: _.template(errorTempalte),
        tagName: 'div',
        className:'post-wrap',
        initialize: function () {
            this.render();

        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        }
    });

    return app.Error404View;
});