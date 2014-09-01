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
		var posicion=input.split(','),
			myLat=0,
			myLon=0,
			lat=0,
			lon=0,
			metros=0,
			distancia=[];
		// String a Numero
		myLat=parseFloat(posicion[0]);
		myLon=parseFloat(posicion[1]);
		//console.log('** '+myLat+','+myLon); //OK!

		function calculateDistance(lat1, lon1, lat2, lon2) {
			var R = 6371; // km
			var dLat = (lat2-lat1).toRad();
			var dLon = (lon2-lon1).toRad();
			var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * Math.sin(dLon/2) * Math.sin(dLon/2);
			var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
			var d = R * c;
			/* Hack to prevent wrong calculations because there is not values */
			//if(lat1==0 || lon1==0){
			//Error: No hay valores de localizacion
			//	return 0;
			//} else {
				// Only two decimals.toFixed(2)
				return d;
			//}
		}
		Number.prototype.toRad = function() {
			return this * Math.PI / 180;
		};

		// distancia
		var meters;
		if(navigator.geolocation) {
			window.navigator.geolocation.getCurrentPosition(function(pos){
				lat = pos.coords.latitude;
				lon = pos.coords.longitude;
				console.log(lat+","+lon+' > '+myLat+','+myLon); // OK!
				distancia.push(calculateDistance(lon,lat,myLon,myLat));
				//meters=calculateDistance(lon,lat,myLon,myLat);
				//console.log(lon+","+lat+" + "+myLon+","+myLat+" = "+meters); // OK
				//console.log(meters +" metros"); // OK
				return calculateDistance(lon,lat,myLon,myLat) +" metros";
			}, function(error) {
				alert('Es necesario que active la localizacion / ' + error.message);
				// error.code can be:
				// 0: unknown error
				// 1: permission denied
				// 2: position unavailable (error response from locaton provider)
				// 3: timed out
			});
			//console.log(pos.coords.longitude+","+pos.coords.latitude+" + "+myLon+","+myLat); // OK
			
			//return meters;
		}
		//window.navigator.geolocation.getCurrentPosition(function(pos){
			//metros = calculateDistance(pos.coords.longitude, pos.coords.latitude, parseFloat(posicion[1]), parseFloat(posicion[0]));
			//console.log(pos); 
			//console.log(metros);
			//return distancia;
		//});
		//console.log('myPos: '+pos.coords.latitude+","+pos.coords.longitude +" "+metros); 
		//console.log(calculateDistance(lon,lat,myLon,myLat));
		//distancia.push(calculateDistance(lon,lat,myLon,myLat));
		//return distancia +" metros";
		//distancia="";
	};
});
/* */
