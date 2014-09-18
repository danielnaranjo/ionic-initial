angular.module('starter.controllers', ['ionic'])

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
    if($scope.city!=="") {
      $scope.navTitle = "Locales en "+$scope.city;
    } else {
      $scope.navTitle = "Cercanos en "+$scope.country;
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
$http.get('http://localhost:8888/api/locals')
  .success(function(data){
    $scope.bares=data;
  })
  .error(function(e){
    console.log(e.name);
  });
*/

/*
$scope.loading = $ionicLoading.show({
    content: 'Getting current location...',
    showBackdrop: false
  });
  navigator.geolocation.getCurrentPosition(function(pos) {
    var coords = $scope.currentLocation = [pos.coords.longitude, pos.coords.latitude];
    console.log(coords);
    $ionicLoading.hide();
  }, function(error) {
    $ionicPopup.alert({
      title: 'Unable to get location: ' + error.message
    }).then(function(res) {
      $ionicLoading.hide();
      // not working
    });
  });

  $scope.distanceFromHere = function (_item, _startPoint) {
    var start = null;

    var radiansTo = function (start, end) {
      var d2r = Math.PI / 180.0;
      var lat1rad = start.latitude * d2r;
      var long1rad = start.longitude * d2r;
      var lat2rad = end.latitude * d2r;
      var long2rad = end.longitude * d2r;
      var deltaLat = lat1rad - lat2rad;
      var deltaLong = long1rad - long2rad;
      var sinDeltaLatDiv2 = Math.sin(deltaLat / 2);
      var sinDeltaLongDiv2 = Math.sin(deltaLong / 2);
      // Square of half the straight line chord distance between both points.
      var a = ((sinDeltaLatDiv2 * sinDeltaLatDiv2) +
              (Math.cos(lat1rad) * Math.cos(lat2rad) *
                      sinDeltaLongDiv2 * sinDeltaLongDiv2));
      a = Math.min(1.0, a);
      return 2 * Math.asin(Math.sqrt(a));
    };

    if ($scope.currentLocation) {
      start = {
        longitude: $scope.currentLocation[0],
        latitude: $scope.currentLocation[1]
      };
    }
    start = _startPoint || start;

    var end = {
      longitude: _item.lng,
      latitude: _item.lat
    };

    var num = radiansTo(start, end) * 3958.8;
    console.log(Math.round(num * 100) / 100);
    return Math.round(num * 100) / 100;
  };
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

.controller('MapaCtrl', function($scope, $http, $ionicPopup, $ionicLoading, $compile, Bares, MyService) {
  $scope.bares = Bares.all();
  
  /* Viene de DashCtrl */
  $scope.mygeo = MyService.data.mygeo;
  var markers = [];

  /* Consulto si hay valores, sino mando por defecto a Madrid
  if($scope.mygeo!=="") { //10.500,-66.900
    console.log('# '+$scope.mygeo);
    var coords=$scope.mygeo.split(','); // OK
    var myLatlng = new google.maps.LatLng(coords[0],coords[1]);
  } else {
    var myLatlng = new google.maps.LatLng(10.500,-66.900);
  }
 */  

  //http://codepen.io/ionic/pen/uzngt/
  //console.log('Actual: '+coords[0]+','+coords[1]);

      function initialize() {
        var myLatlng = new google.maps.LatLng(40.4378271,-3.6795367);
        var mapOptions = {
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          zoom: 10
        };
        var map = new google.maps.Map(document.getElementById("map"),
            mapOptions);
        
        //Marker + infowindow + angularjs compiled ng-click
        //var contentString = "<div>Estas ubicado en "+$scope.mygeo+"</div>";
        var contentString = "<div><p><strong>Te ubicamos en España</strong>, para mejorar tu experiencia<br>";
        contentString+= "debes hacer clic en el boton de Localización:</p>";
        contentString+= "<p align=\"center\"><button class=\"button button-icon icon ion-compass\" ng-click=\"centerOnMe()\" ></button>";
        contentString+= "</p></div>";
        compiled = $compile(contentString)($scope);

        var infowindow = new google.maps.InfoWindow({
          content: compiled[0],
          position:myLatlng,
          map: map
        });

        // var marker = new google.maps.Marker({
        //   position: myLatlng,
        //   map: map,
        //   title: 'Ubicación'
        // });

        // google.maps.event.addListener(marker, 'click', function() {
        //   infowindow.open(map,marker);
        // });

        $scope.map = map;
      }

      // Add a marker to the map and push to the array.
      $scope.addMarker = function(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
        markers.push(marker);
        console.log('->'+marker);
      };

      //google.maps.event.addDomListener(window, 'load', initialize);
      ionic.Platform.ready(initialize);
        $scope.centerOnMe = function() {
        if(!$scope.map) {
          return;
        }

        $scope.loading = $ionicLoading.show({
          content: 'Cargando ubicacion actual...',
          showBackdrop: false
        });

        navigator.geolocation.getCurrentPosition(function(pos) {
          $scope.map.setCenter(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
          var myLatlng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
          $ionicLoading.hide();
          //console.log('/'+myLatlng); 
          var lat = pos.coords.latitude;
          var lon = pos.coords.longitude;
          var myCoords = lat+','+lon;
          console.log('@'+myCoords);
          $scope.addMarker('Caracas').setMap(map);
        }, function(error) {
          //alert('Unable to get location: ' + error.message);
          $ionicPopup.alert({
            title: 'Es necesario que active la localizacion / ' + error.message
          });
        });
      };
      $scope.clickTest = function() {
        alert('Example of infowindow with ng-click');
      };
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
})

.controller('FavoritosCtrl', function($scope, Bares) {
  $scope.bares = Bares.all();
})

.controller('VerMapaCtrl', function($scope, $stateParams, Bares) {
  $scope.bar = Bares.get($stateParams.barId);
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