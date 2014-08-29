angular.module('starter.filters', []).filter('ranking', function() {
	return function(input){
	// <i class="icon ion-heart" ng-show="bar.favorite"></i>
	var range = [],
		estrellas="<i class=\"ion-ios7-star\" ng-show=\"bar.stars\"></i>";
	for(var i=0;i<input;i++) {
		range.push(i);
	}
    return range;
    //return input ? '\f1e0' : '\f1df';
  };
});