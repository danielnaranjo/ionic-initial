angular.module('starter.controllers', [])

.controller('DashCtrl', function($scope, Bares) {
  	$scope.bares = Bares.all();
})

.controller('DetailCtrl', function($scope, $stateParams, Bares) {
  $scope.bar = Bares.get($stateParams.barId);
})

.controller('MapaCtrl', function($scope) {
      // Mapa
})

.controller('HoyCtrl', function($scope, Bares) {
  $scope.bares = Bares.all();
})

.controller('FavoritosCtrl', function($scope, Bares) {
  $scope.bares = Bares.all();
})

.controller('FavoritosDetailCtrl', function($scope, $stateParams, Bares) {
  $scope.bar = Bares.get($stateParams.barId);
})

.controller('AccountCtrl', function($scope) {
  $scope.settingsList = [
    { text: "Fotografias", checked: true },
    { text: "Localizacion", checked: true },
    { text: "Facebook", checked: false },
    { text: "Twitter", checked: false }
  ];

  $scope.pushNotificationChange = function() {
    console.log('Push Notification Change', $scope.pushNotification.checked);
  };
  
  $scope.pushNotification = { checked: true };
  $scope.emailNotification = 'Subscribed';
});