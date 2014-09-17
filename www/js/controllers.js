angular.module('starter.controllers', ['ionic',])

.controller('DashCtrl', function($scope, $http, Bares){
  //$scope.data = {};
  $scope.bares = Bares.all();
  // $scope.ubicacion = function(x,y,z) {
  //   console.log($scope.x+','+$scope.y+','+$scope.z);
  // };
  $scope.clearSearch = function() {
    $scope.query = '';
  };
/*
$http.get('http://localhost:8888/api/locals')
  .success(function(data){
    $scope.bares=data;
  })
  .error(function(e){
    console.log(e.name);
  });
*/
})

.controller('DetailCtrl', function($scope, $http, $ionicActionSheet, $ionicPopup, $stateParams, Bares) {
  $scope.bar = Bares.get($stateParams.barId);
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

.controller('MapaCtrl', function($scope, $http, $ionicPopup, $ionicLoading, $compile, Bares) {
  $scope.bares = Bares.all();
  //http://codepen.io/ionic/pen/uzngt/
  //console.log('Actual: '+Lat+','+Lon)
      function initialize() {
        var myLatlng = new google.maps.LatLng(40.4378271,-3.6795367);
        var mapOptions = {
          center: myLatlng,
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"),
            mapOptions);
        
        //Marker + infowindow + angularjs compiled ng-click
        var contentString = "<div>"+myLatlng+"</div>";
        var compiled = $compile(contentString)($scope);

        var infowindow = new google.maps.InfoWindow({
          content: compiled[0]
        });

        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Uluru (Ayers Rock)'
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });

        $scope.map = map;
      }
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
          //$scope.loading.hide();
          //console.log(pos); 
          var lat = pos.coords.latitude;
          var lon = pos.coords.longitude;
          //console.log(lat+','+lon);
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
})

.controller('HoyCtrl', function($scope, $http, $ionicActionSheet, $ionicPopup, Bares) {
  $scope.bares = Bares.all();
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
})

.controller('FavoritosDetailCtrl', function($scope, $stateParams, Bares) {
  $scope.bar = Bares.get($stateParams.barId);
});

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