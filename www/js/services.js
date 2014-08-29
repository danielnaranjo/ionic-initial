angular.module('starter.services', [])

/**
 * A simple example service that returns some data.
 */
.factory('Bares', function() {

  var bares = [
    { id: 0, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', gps: {lat:-8,lon:-66}, promo: 'Happy hour 17-19hrs', wifi: true, parking: true, stars:3, favorite: true },
    { id: 1, name: 'El Corte Ingles', address: 'New York City, NY', logo:'img/img2.jpg', gps: {lat:-8,lon:-66}, promo: 'Ladies nigth', wifi: true, parking: false, stars:5, favorite: false },
    { id: 2, name: 'Coyote Ugly', address: 'Manila Philipines', logo:'img/img3.jpg', gps: {lat:-8,lon:-66}, promo: 'After hours', wifi: true, parking: false, stars:2, favorite: false },
    { id: 3, name: 'Kokomo', address: 'Buenos Aires, Argentina', logo:'img/img4.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:4, favorite: false },
    { id: 11, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:1, favorite: false },
    { id: 4, name: 'El Corte Ingles', address: 'New York City, NY', logo:'img/img2.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:5, favorite: false },
    { id: 5, name: 'Coyote Ugly', address: 'Manila Philipines', logo:'img/img3.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:2, favorite: false },
    { id: 6, name: 'Kokomo 4', address: 'Buenos Aires, Argentina', logo:'img/img4.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:4, favorite: true },
    { id: 10, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:4, favorite: false },
    { id: 7, name: 'El Corte Ingles 3', address: 'New York City, NY', logo:'img/img2.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:5, favorite: false },
    { id: 8, name: 'Coyote Ugly 2', address: 'Manila Philipines', logo:'img/img3.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:2, favorite: true },
    { id: 9, name: 'Kokomo 2', address: 'Caracas, Venezuela', logo:'img/img4.jpg', gps: {lat:-8,lon:-66}, promo: '', wifi: true, parking: false, stars:4, favorite: true }

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
