angular.module('starter.services', [])

/**
 * A simple example service that returns some data.
 */
.factory('Bares', function() {

  var bares = [
    { id: 0, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '8,-63', promo: '2x1 Bud Light', imgpromo: 'img/cerveza.jpg', wifi: true, parking: true, stars:3, favorite: true, phone: '55512345' },
    { id: 1, name: 'El Corte Ingles', address: 'New York City, NY', logo:'img/img2.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '10.500,-66.900', promo: 'Open Bar', imgpromo: 'img/tequila.jpg', wifi: true, parking: false, stars:5, favorite: false, phone: '55512345' },
    { id: 2, name: 'Coyote Ugly', address: 'Manila Philipines', logo:'img/img3.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: 'Barcadi present: After hours', imgpromo: 'img/bacardi.jpg', wifi: true, parking: false, stars:2, favorite: false, phone: '55512345' },
    { id: 3, name: 'Kokomo', address: 'Buenos Aires, Argentina', logo:'img/img4.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: '', imgpromo: '', wifi: true, parking: false, stars:4, favorite: false, phone: '55512345' },
    { id: 11, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: '', imgpromo: '', wifi: true, parking: false, stars:1, favorite: false, phone: '55512345' },
    { id: 4, name: 'El Corte Ingles', address: 'New York City, NY', logo:'img/img2.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: '', imgpromo: '', wifi: true, parking: false, stars:5, favorite: false, phone: '55512345' },
    { id: 5, name: 'Coyote Ugly', address: 'Manila Philipines', logo:'img/img3.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: '', imgpromo: '', wifi: true, parking: false, stars:2, favorite: false, phone: '55512345' },
    { id: 6, name: 'Kokomo 4', address: 'Buenos Aires, Argentina', logo:'img/img4.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: '', imgpromo: '', wifi: true, parking: false, stars:4, favorite: true, phone: '55512345' },
    { id: 10, name: 'La trucha azul', address: 'Dublin, Ireland', logo:'img/img1.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: '', imgpromo: '', wifi: true, parking: false, stars:4, favorite: false, phone: '55512345' },
    { id: 7, name: 'El Corte Ingles 3', address: 'New York City, NY', logo:'img/img2.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500,-63.700', promo: '', imgpromo: '', wifi: true, parking: false, stars:5, favorite: false, phone: '55512345' },
    { id: 8, name: 'Coyote Ugly 2', address: 'Manila Philipines', logo:'img/img3.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '11.500123,-63.800', promo: '', imgpromo: '', wifi: true, parking: false, stars:2, favorite: true, phone: '55512345' },
    { id: 9, name: 'Kokomo 2', address: 'Caracas, Venezuela', logo:'img/img4.jpg', description: 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they are actually proud of that shit. ', gps: '12.600,-63.000', promo: '', imgpromo: '', wifi: true, parking: false, stars:4, favorite: true, phone: '55512345' }

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
