angular.module('starter.controllers', ['ionic','leaflet-directive', 'ngCordova'])

.controller('DashCtrl', function($scope, $ionicPopup, $ionicLoading, $http, Bares, MyService){
  $scope.data = {};
  $scope.bares = Bares.all();
  $scope.clearSearch = function() {
    $scope.data.query = '';
  };
  /* Load location via IP */
  var myURL="http://www.freegeoip.net/json/";  //OK!
  $http({method: "GET", url: myURL}).
      success(function(data) {
        $scope.dip=data.ip;
        $scope.country=data.country_name;
        $scope.city=data.city;
        $scope.zipcode=data.zipcode;
        $scope.geo=data.latitude+','+data.longitude;
        //$scope.navTitle = data.city +""+data.country_name;
        console.log("Success!");
      }).
      error(function(error) {
        console.log("Request failed "+error.message);
    });
  /* Show popup while loading geolocation */
  $scope.navTitle = "Cargando ubicacion..";
  /* popup */
  $scope.loading = $ionicLoading.show({
    template: 'Por favor, espere..'
  });
  /* Run geolocation API */
  navigator.geolocation.getCurrentPosition(function(pos) {
    var coords = $scope.currentLocation = [pos.coords.longitude, pos.coords.latitude];
    console.log(coords);
    $scope.mygeo=pos.coords.latitude+','+pos.coords.longitude;
    /* Paso data entre controladores */
    MyService.data.mygeo = $scope.mygeo;
    /* Cambio el titulo */
    $scope.navTitle = "Estas cerca de "+parseInt(coords[0])+","+parseInt(coords[1]);
    /* Muestro titulo segun ciudad/pais */
    if($scope.city!=="" || $scope.city!=="undefined") {
      $scope.navTitle = "Locales en "+$scope.city;
      console.log('city:'+$scope.city);
    } else {
      $scope.navTitle = "Cercanos en "+$scope.country;
      console.log('city:'+$scope.city+' '+$scope.country);
    }
    $ionicLoading.hide();
  }, function(error) {
    $ionicPopup.alert({
      title: 'Error: No ha sido posible ubicarte. ' + error.message
    }).then(function(res) {
      $ionicLoading.hide();
      // not working
    });
  });

/*
// http://maps.googleapis.com/maps/api/distancematrix/json?origins=41.0170249,-3.8526283&destinations=41.0270249,-3.8526283
$http.get('http://localhost:8888/api/locals')
  .success(function(data){
    $scope.bares=data;
  })
  .error(function(e){
    console.log(e.name);
  });
*/

}) // End DashCtrl

.controller('DetailCtrl', function($scope, $http, $ionicActionSheet, $ionicPopup, $stateParams, Bares, MyService) {
  $scope.bar = Bares.get($stateParams.barId);
  /* Viene de DashCtrl */
  $scope.mygeo = MyService.data.mygeo;
  $scope.showActionsheet = function() {
    $ionicActionSheet.show({
      titleText: '<h4>Compartir</h4>',
      buttons: [
        { text: 'Facebook <i class="icon ion-social-facebook"></i>' },
        { text: 'Twitter <i class="icon ion-social-twitter"></i>' },
      ],
      cancelText: 'Cancelar',
      cancel: function() {
        console.log('CANCELLED');
      }
    });
  }; // End Scope acciones
  $scope.showConfirm = function(x) {
     var confirmPopup = $ionicPopup.confirm({
       title: 'Gracias por preferirnos!',
       template: 'No olvides mencionar que encontraste el restaurante en Bares!'
     });
     confirmPopup.then(function(res) {
       if(res) {
         document.location = x;
       }
     });
   }; // Llamar
})

.controller('MapaCtrl', function($scope, $ionicActionSheet, $ionicPopup, $location, Bares, MyService) {
  $scope.bares = Bares.all();
  /* Viene de DashCtrl */
  $scope.mygeo = MyService.data.mygeo;

  angular.extend($scope, {
    // Madrid
    center: {
      lat: 40.4378271,
      lng: -3.6795367,
      zoom: 15
    },
    markers: {
      centro: {
        lat: 40.4378271,
        lng: -3.6795367,
        message: "Madrid",
        focus: false,
        draggable: false
      },
    },
    defaults: {
        scrollWheelZoom: false
    }
  });
  /* parametros por URL */
  $scope.$on("MapaCtrl", function(event, centerHash) {
    $location.search({ c: centerHash });
    console.log("url", centerHash);
  });

  if(window.document.URL.split('c')[2]==="") {
    navigator.geolocation.getCurrentPosition(function(pos) {
      $scope.center.lat=pos.coords.latitude;
      $scope.center.lng=pos.coords.longitude;
      // $scope.center.markers.center.lat= $scope.center.lat;
      // $scope.center.markers.center.lng= $scope.center.lng;
      $ionicLoading.hide();
      console.log('Fired  geolocation! ');
      // var lat = pos.coords.latitude;
      // var lon = pos.coords.longitude;
      // var myCoords = lat+','+lon;
      // console.log('@'+myCoords);
    }, function(error) {
      //alert('Unable to get location: ' + error.message);
      $ionicPopup.alert({
        title: 'Es necesario que active la localizacion / ' + error.message
      });
    });
  };
  /* Reemplaza ubicacion actual por la geolocalizada */
  $scope.centerOnMe = function(v) {
    v=v.replace(',',':');
    window.location.href = "#/tab/mapa?c="+v+":15";
  };


  /* Viene de DashCtrl */
  //$scope.mygeo = MyService.data.mygeo;

        // var contentString = "<div><p><strong>Te ubicamos en España</strong>, para mejorar tu experiencia<br>";
        // contentString+= "debes hacer clic en el boton de Localización:</p>";
        // contentString+= "<p align=\"center\"><button class=\"button button-icon icon ion-compass\" ng-click=\"centerOnMe()\" ></button>";
        // contentString+= "</p></div>";

}) // end MapCtrl

.controller('HoyCtrl', function($scope, $http, $ionicActionSheet, $ionicPopup, Bares, MyService) {
  $scope.bares = Bares.all();
  /* Viene de DashCtrl */
  $scope.mygeo = MyService.data.mygeo;

  // $scope.showAlert = function() {
  //    var alertPopup = $ionicPopup.alert({
  //      title: 'Gracias por preferirnos!',
  //      template: 'No olvides mencionar que encontraste el restaurante en Bares!'
  //    });
  //    alertPopup.then(function(res) {
  //      console.log('Thank you for not eating my delicious ice cream cone');
  //    });
  //  };
// A confirm dialog
   $scope.showConfirm = function(x) {
     var confirmPopup = $ionicPopup.confirm({
       title: 'Gracias por preferirnos!',
       template: 'No olvides mencionar que encontraste el restaurante en Bares!'
     });
     confirmPopup.then(function(res) {
       if(res) {
         document.location = x;
       // } else {
       //   console.log('You are not sure');
       }
     });
   }; // end confirm()
   $scope.showActionsheet = function() {
    $ionicActionSheet.show({
      titleText: '<h4>Compartir</h4>',
      buttons: [
        { text: 'Facebook <i class="icon ion-social-facebook"></i>' },
        { text: 'Twitter <i class="icon ion-social-twitter"></i>' },
      ],
      cancelText: 'Cancelar',
      cancel: function() {
        console.log('CANCELLED');
      }
    });
  }; // End Scope acciones
  /* Reemplaza ubicacion actual por la geolocalizada */
  $scope.centerOnMe = function(v) {
    v=v.replace(',',':');
    window.location.href = "#/tab/mapa?c="+v+":15";
  }; // centerOne
})

.controller('FavoritosCtrl', function($scope, $http, $ionicPopup, $ionicLoading) {
    /* popup */
    $scope.loading = $ionicLoading.show({
      template: 'Por favor, espere..'
    });
    var app = this;
    $http.get("http://servidor.web.ve/api/locales")
      .success(function(data) {
        app.locales = data;
        $ionicLoading.hide();
      });
});


// .controller('FavoritosDetailCtrl', function($scope, $stateParams, Bares) {
//   $scope.bar = Bares.get($stateParams.barId);
// });

// .controller('AccountCtrl', function($scope) {
//   $scope.settingsList = [
//     { text: "Fotografias", checked: true },
//     { text: "Localizacion", checked: true },
//     { text: "Facebook", checked: false },
//     { text: "Twitter", checked: false }
//   ];

//   $scope.pushNotificationChange = function() {
//     console.log('Push Notification Change', $scope.pushNotification.checked);
//   };
  
//   $scope.pushNotification = { checked: true };
//   $scope.emailNotification = 'Subscribed';
// });