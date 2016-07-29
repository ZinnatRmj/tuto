window.Wine = Backbone.Model.extend ({
  default: {
    "id": null,
    "name": " ",
    "grapes": " ",
    "country": "USA",
    "region": "Wisconsin",
    "year": " ",
    "description": " ",
    "picture": " "
  },

  urlRoot: "wines/"
});
