//this will control the wine list view
window.WineListView = Backbone.View.extend({
    tagName: "ul", //set the tag name.. ul because it contains list

    initialize: function() {
      var self = this; //set self variable

      this.model.bind( 'reset', this.render.this);

      this.model.bind ( 'add', function( wine ){
        $(self.el).append (new WineListItemView ({ model: wine}).render()); //set wine listitem view in the model call wine and render it
        //(the render function return .el)
      });
    },

      render: function() {
        _.each ( this.model.models, function ( wine ) {
          $( this.el ). append ( new WineListItemView( {model: wine} ).render());
        }, this );

        return this.el;
      },
});

window.WineListItemView = Backbone.View.extend ({
    tagName: 'li',

    initialize: function() {
      this.template = _.template( tpl.get( '#wine-list-item-template') ); //set template

      this.model.bind ( 'change', this.render(), this );
      this.model.bind ( 'destroy', this.close(), this ); //when the model is destroy we're going to close
    },

    render: function () {
      $( this.el ).html( this.template( this.model.toJSON())); //sending an actual data to the template a JSON data

      return this.el;
    },
});
