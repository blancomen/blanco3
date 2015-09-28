define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/page/auth/register.html'
],
function ($, _, Backbone, registerTemplate) {
    'use strict';
    app.RegisterView = Backbone.View.extend({
        events:{
          'submit #register': 'register'
        },

        tagName: "div",
        tpl: _.template(registerTemplate),

        initialize: function () {
            this.render();
        },

        render: function () {
            this.$el.html(this.tpl());
            return this;
        },

        register: function(e) {
            e.preventDefault();

            var data = $('#register').serialize();
            $.post('?action=register&' + data, function(response) {
                if (response.register) {
                    window.location.hash = '/feed/main';
                    location.reload();
                } else {
                    alert(response.message)
                }

            });

            return false;
        }
    });

    return app.RegisterView;
});