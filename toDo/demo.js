$(document).ready( function () {
    $("#main").css('background', 'blue');
    $("#main").css('min-height', '800px');

var ImageView = Backbone.View.extend({
  template: _.template( $(''#image-tpl''));
  initialize: function (opt) {

  },
  render: function () {
    return this.model.toJSON();
  },
});

var imageModel = Backbone.Model.extend({
  defaults: {
    'cat' : ' ',
    'dog': ' ',
  }
});

var imageView = new ImageView ({
  model: new imageModel({
    'cat' : 'kity',
    'dog': 'lucky',
  });
  imageView.render();
});

});
