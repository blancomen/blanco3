define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/page/auth/login.html'
],
function ($, _, Backbone, loginTemplate) {
    'use strict';
    app.AuthView = Backbone.View.extend({
        events:{
          'submit #login': 'auth'
        },

        tagName: "div",
        tpl: _.template(loginTemplate),

        initialize: function () {
          this.render();
        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        },

        auth: function(e) {
            //e.preventDefault();

            var data = $('#login').serialize();
            $.post('?action=login&' + data, function(response) {
                if (!response.auth) {
                    alert('Invalid login or password');
                } else {
                    window.location.hash = '/feed/main';
                    location.reload();
                }
            });

            return false;
        }
    });

    return app.AuthView;
});