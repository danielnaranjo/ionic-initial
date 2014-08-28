angular.module('starter.services', [])

/**
 * A simple example service that returns some data.
 */
.factory('Bares', function() {

  var bares = [
    { id: 0, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', stars:1 },
    { id: 1, name: 'El Corte Ingles', address: 'New York City, NY', logo:'img/img2.jpg', stars:5 },
    { id: 2, name: 'Coyote Ugly', address: 'Manila Philipines', logo:'img/img3.jpg', stars:2 },
    { id: 3, name: 'Kokomo', address: 'Buenos Aires, Argentina', logo:'img/img4.jpg', stars:4 },{ id: 0, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', stars:1 },
    { id: 4, name: 'El Corte Ingles', address: 'New York City, NY', logo:'img/img2.jpg', stars:5 },
    { id: 5, name: 'Coyote Ugly', address: 'Manila Philipines', logo:'img/img3.jpg', stars:2 },
    { id: 6, name: 'Kokomo 4', address: 'Buenos Aires, Argentina', logo:'img/img4.jpg', stars:4 },{ id: 0, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', stars:1 },
    { id: 7, name: 'El Corte Ingles 3', address: 'New York City, NY', logo:'img/img2.jpg', stars:5 },
    { id: 8, name: 'Coyote Ugly 2', address: 'Manila Philipines', logo:'img/img3.jpg', stars:2 },
    { id: 9, name: 'Kokomo 2', address: 'Caracas, Venezuela', logo:'img/img4.jpg', stars:4 }

  ];

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
