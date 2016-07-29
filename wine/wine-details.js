window.WineView = Backbone.View.extend({ //creating wine view
  initialize: function() {
    this.template =_.template( tpl.get('#wine-details-template') ); //create template

    this.model.bind ( 'change', this.render, this); //setup model binding, when there is a change to the model
    //we can render that change immediately
  },

  render: function() {
    $( this.el ).html( this.template( this.model.toJSON())); //render template

    return this.el;
  },

  events : {
    'click save': 'saveWine',
    'click delete': 'deleteWine',
  },

  saveWine : function () {
    this.model.set ({
      name: $( '#name').val(),
      grapes: $( '#grapes').val(),
      country: $( '#country').val(),
      region: $( '#region').val(),
      year: $( '#year').val(),
      description: $( '#description').val(),
    });

    if (this.model.isNew()) {
      var self = this;

    app.wineList.create( this.model, {
          success: function() {
            app.navigate( 'wines' + self.model.id, false );
          }
        }); //winelist = collection of all the wine & stored in the app router here
    } else {
      this.model.save();
    }
    return false;
  },

  deleteWine: function () {
    this.model.destroy({
      success : function ( ) {
        alert('Wine was deleted successfully');
        window.history.back();
      }
    });
    return false;
  }

});
