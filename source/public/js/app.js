var paths = {
    jquery: 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min',
    bootstrap: 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min',
    underscore: 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min',
    backbone: 'https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min',
    text: 'https://cdnjs.cloudflare.com/ajax/libs/require-text/2.0.12/text.min'
};

require.config({
    shim: {
        bootstrap: {
            exports: 'Bootstrap'
        },
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: [
                'underscore',
                'jquery'
            ],
            exports: 'Backbone'
        }
    },
    baseUrl: 'js/',
    paths: paths
});

require([
    'jquery',
    'underscore',
    'backbone',
    'routers/router'
], function ($, _, Backbone, Router) {
    app.router = new Router();
    Backbone.history.start();
});


