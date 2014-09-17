angular.module('starter.services', [])

/**
 * A simple example service that returns some data.
 */


.factory('Bares', function() {
  var bares = [{
      id: 0,
      name: "La Pulpería de Victoria",
      description: "Now that there is the Tec-9, a crappy spray gun from South Miami.",
      cuisine: "Mariscos, Pastas, Aves, Mediterranea",
      address: "Leganitos 10-28013",
      city: "Madrid",
      state: "Madrid",
      country: "Espana",
      phone: "910804929",
      email: "hola@loultimoenlaweb.com",
      web: "www.loultimoenlaweb.com",
      twitter: "@loultimoenlaweb",
      facebook: "faceboook.com/loultimoenlaweb",
      logo:"img/img3.jpg",
      gps: "-11.500,-63.700",
      business: "De 19:00 a 24:00",
      payments: "Visa,MC,Amex,Ticket",
      range: 2,
      menus:[{
        id: 0,
        start:"Ensalada ranchera, Sopa de Lentejas, Carpaccio de Salmon",
        main:"Parrilla mixta, Pollo a la canasta, Pasticcio",
        dessert:"Cheesecake New York Style, Torta de Chocolate",
        validFrom: "2014-09-11",
        validTo: "2014-09-12",
        price: 20
      },{
        id: 1,
        start:"Ensalada de Berro, Crema de verduras",
        main:"Churrasco de Mero, Pollo a la canasta, Pasticcio",
        dessert:"Quesillo de Pina, Torta de Chocolate",
        validFrom: "2014-09-11",
        validTo: "2014-09-12",
        price: 20
      }],
      promos: [{
        dID:0,
        promo:"20 Cafe gratis"
      }],
      features: {},
      comments: [],
      photos: []
    },
    {
      id: 1,
      name: "All You Can Eat",
      description: "Now that there is the Tec-9, a crappy spray gun from South Miami.",
      cuisine: "Mariscos, Pastas, Aves, Mediterranea",
      address: "Leganitos 10-28013",
      city: "Madrid",
      state: "Madrid",
      country: "Espana",
      phone: "910804929",
      email: "hola@loultimoenlaweb.com",
      web: "www.loultimoenlaweb.com",
      twitter: "@loultimoenlaweb",
      facebook: "faceboook.com/loultimoenlaweb",
      logo:"img/img2.jpg",
      gps: "8,-63",
      business: "De 19:00 a 24:00",
      payments: "Visa,MC,Amex,Ticket",
      range: 5,
      menus:[{
        id: 0,
        start:"Ensalada de Berro",
        main:"Churrasco de Mero",
        dessert:"Quesillo de Pina",
        validFrom: "2014-09-11",
        validTo: "2014-09-12",
        price: 10
      }],
      promos: [],
      features: {},
      comments: [],
      photos: []
    }];

  return {
    all: function() {
      return bares;
    },
    get: function(barId) {
      // Simple index lookup
      return bares[barId];
    }
  }
});

/*
.factory('Bares', function($http) {
  var baseURL ="http://localhost:8888/api/locals";
  $http.get(baseURL)
    .success(function(data) {
      $scope.bares = data;
    })
    .error(function(error){
       console.log(error);
    });
  return {
    all: function() {
      return bares;
    },
    get: function(barId) {
      return bares[barId];
    }
  };
});
*/