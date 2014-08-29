angular.module('starter.filters', []).filter('ranking', function() {
	// http://stackoverflow.com/questions/11873570/angularjs-for-loop-with-numbers-ranges
	return function(input){
	var range = [];
	for(var i=0;i<input;i++) {
		range.push(i);
	}
    return range;
  	};
});