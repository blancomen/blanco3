define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/main/menu.html'
],
function ($, _, Backbone, mainMenuTemplate) {
    'use strict';
    app.MainMenuView = Backbone.View.extend({
        tagName: "div",
        tpl: _.template(mainMenuTemplate),

        initialize: function () {
            this.render();
        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        }
    });

    return app.MainMenuView;
});