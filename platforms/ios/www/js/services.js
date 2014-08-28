angular.module('starter.services', [])

/**
 * A simple example service that returns some data.
 */
.factory('Friends', function() {
  // Might use a resource here that returns a JSON array

  // Some fake testing data
  var friends = [
    { id: 0, name: 'Scruff McGruff', address: 'Dublin, Ireland' },
    { id: 1, name: 'G.I. Joe', address: 'New York City, NY' },
    { id: 2, name: 'Miss Frizzle', address: 'Manila Philipines' },
    { id: 3, name: 'Ash Ketchum', address: 'Buenos Aires, Argentina' }
  ];

  return {
    all: function() {
      return friends;
    },
    get: function(friendId) {
      // Simple index lookup
      return friends[friendId];
    }
  }
})
.factory('Bares', function() {
  // Might use a resource here that returns a JSON array

  // Some fake testing data
  var bares = [
    { id: 0, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', stars:5 },
    { id: 1, name: 'El Corte Ingles', address: 'New York City, NY', logo:'img/img2.jpg', stars:5 },
    { id: 2, name: 'Coyote Ugly', address: 'Manila Philipines', logo:'img/img3.jpg', stars:5 },
    { id: 3, name: 'Kokomo', address: 'Buenos Aires, Argentina', logo:'img/img4.jpg', stars:5 }
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
