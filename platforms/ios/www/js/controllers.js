angular.module('starter.controllers', [])

.controller('DashCtrl', function($scope, Bares, $ionicPopover) {
    $ionicPopover.fromTemplateUrl('templates/popover.html', function(popover) {
      $scope.popover = popover;
    });
  	$scope.bares = Bares.all();
})

.controller('FriendsCtrl', function($scope) {
      //
})

.controller('FavoritosCtrl', function($scope, Bares) {
  $scope.bares = Bares.all();
})

.controller('FavoritosDetailCtrl', function($scope, $stateParams, Bares) {
  $scope.bar = Bares.get($stateParams.barId);
})

.controller('AccountCtrl', function($scope) {
  $scope.settingsList = [
    { text: "Wireless", checked: true },
    { text: "GPS", checked: false },
    { text: "Bluetooth", checked: false }
  ];

  $scope.pushNotificationChange = function() {
    console.log('Push Notification Change', $scope.pushNotification.checked);
  };
  
  $scope.pushNotification = { checked: true };
  $scope.emailNotification = 'Subscribed';
})

.controller('HoyCtrl', function($scope, Bares) {
  $scope.bares = Bares.all();
});