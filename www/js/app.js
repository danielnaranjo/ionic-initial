// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
angular.module('starter', [
  'ionic',
  'starter.controllers',
  'starter.services',
  'starter.filters'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if(window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if(window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider

    // setup an abstract state for the tabs directive
    .state('tab', {
      url: "/tab",
      abstract: true,
      templateUrl: "templates/tabs.html"
    })

    // Each tab has its own nav history stack:

    .state('tab.buscador', {
      url: '/buscador',
      views: {
        'tab-buscador': {
          templateUrl: 'templates/tab-buscador.html',
          controller: 'DashCtrl'
        }
      }
    })

    .state('tab.mapa', {
      url: '/mapa',
      views: {
        'tab-mapa': {
          templateUrl: 'templates/tab-mapa.html',
          controller: 'MapaCtrl'
        }
      }
    })

    .state('tab.map-detalle', {
      url: '/map/:barId',
      views: {
        'map-detalle': {
          templateUrl: 'templates/map-detalle.html',
          controller: 'VerMapaCtrl'
        }
      }
    })

    .state('tab.tab-detalle', {
      url: '/bar/:barId',
      views: {
        'tab-mapa': {
          templateUrl: 'templates/tab-detalle.html',
          controller: 'DetailCtrl'
        }
      }
    })
    
    .state('tab.favoritos', {
      url: '/favoritos',
      views: {
        'tab-favoritos': {
          templateUrl: 'templates/tab-favoritos.html',
          controller: 'FavoritosCtrl'
        }
      }
    })

    // .state('tab.favoritos-detail', {
    //   url: '/fav/:barId',
    //   views: {
    //     'tab-favoritos': {
    //       templateUrl: 'templates/favoritos-detail.html',
    //       controller: 'FavoritosDetailCtrl'
    //     }
    //   }
    // })

    .state('tab.hoy', {
      url: '/hoy',
      views: {
        'tab-hoy': {
          templateUrl: 'templates/tab-hoy.html',
          controller: 'HoyCtrl'
        }
      }
    });

    // .state('tab.ajustes', {
    //   url: '/ajustes',
    //   views: {
    //     'tab-ajustes': {
    //       templateUrl: 'templates/tab-ajustes.html',
    //       controller: 'AccountCtrl'
    //     }
    //   }
    // });

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/tab/buscador');

});

