window.StartView = Backbone.View.extend ({
  initialize: function () {
    this.template = _.template ( tpl.get('#start-template'));
  },
  render: function () {
    this.$el.html (this.template());
    return this.el;
  };

});
