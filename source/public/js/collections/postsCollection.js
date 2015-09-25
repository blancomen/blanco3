define([
    'jquery',
    'underscore',
    'backbone',
    '../models/postModel'
], function ($, _, Backbone, Post) {
    'use strict';

    var PostsCollection = Backbone.Collection.extend({
        model: Post
    });

    return PostsCollection;
});