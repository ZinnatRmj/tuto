window.HeaderView = Backbone.View.extend ({

    initialize: function() { //setting the template
      this.template = _.template( tpl.get("#header-template") ); //get the #header template
    },

    render: function() {
      $( this.el ).html( this.template() );

      return this.el; //use the element of the view and render it to the DOM
    },

    events: {
      "click .new" : "newWine" //which will run the new wine function
    },

    newWine: function() {
      app.navigate("#wines/new", true); //the router or navigator that we want to navigate

      return false;
    }
});
