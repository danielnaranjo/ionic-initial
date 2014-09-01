angular.module('starter.filters', [])

// Ranking estrellas
.filter('ranking', function() {
	// http://stackoverflow.com/questions/11873570/angularjs-for-loop-with-numbers-ranges
	return function(input){
	var range = [];
	for(var i=0;i<input;i++) {
		range.push(i);
	}
    return range;
	};
})//;

.filter('distancia', function() {
	return function(input){
		var posicion=input.split(','),myLat=0,myLon=0,lat=0,lon=0,metros=0,distancia;
		myLat=parseFloat(posicion[0]);
		myLon=parseFloat(posicion[1]);
		// console.log('** '+myLat+','+myLon);
		// distancia
		if(navigator.geolocation) {
			window.navigator.geolocation.getCurrentPosition(function(pos){
				lat = pos.coords.latitude;
				lon = pos.coords.longitude;
				// console.log(lat+","+lon); 
			}, function(error) {
				alert("Error","Ha occurrido un error: "+error.code);
				// error.code can be:
				// 0: unknown error
				// 1: permission denied
				// 2: position unavailable (error response from locaton provider)
				// 3: timed out
			});
		}
		var calculateDistance = function (lat1, lon1, lat2, lon2) {
			var R = 6371; // km
			var dLat = (lat2-lat1).toRad();
			var dLon = (lon2-lon1).toRad();
			var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * Math.sin(dLon/2) * Math.sin(dLon/2);
			var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
			var d = R * c;
			return d;
		}
		Number.prototype.toRad = function() {
			return this * Math.PI / 180;
		};
		window.navigator.geolocation.getCurrentPosition(function(pos){
			metros = calculateDistance(pos.coords.longitude, pos.coords.latitude, parseFloat(posicion[1]), parseFloat(posicion[0]));
			console.log(metros); 
			distancia=metros;
			return distancia;
		});
		//console.log('myPos: '+lat+","+lon +" "+metros); 
		//console.log(calculateDistance(lon,lat,parseFloat(posicion[1]),parseFloat(posicion[0])));
		return distancia +" metros";
	};
});
/* */
