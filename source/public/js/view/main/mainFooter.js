define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/main/footer.html'
],
function ($, _, Backbone, mainFooterTemplate) {
    'use strict';

    app.MainFooterView = Backbone.View.extend({
        tagName: "div",
        tpl: _.template(mainFooterTemplate),

        initialize: function () {
            this.render();
        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        }
    });

    return app.MainFooterView;
});