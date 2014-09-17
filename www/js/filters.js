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
})
//;
.filter('distancia', function(){
	return function(input){
		//console.log(input);
		
		var posicion=input.split(',');
		// Inicializo variables
		var Lat1=0,Lon1=0,Lat2=0,Lon2=0,miubicacion=[];
		// String a Numero

		Lat1=parseFloat(posicion[0]);
		Lon1=parseFloat(posicion[1]);
		//console.log('** '+myLat+','+myLon); //OK!

		function calculateDistance(lat1, lon1, lat2, lon2) {
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

		// distancia
/*		if(navigator.geolocation) {
			window.navigator.geolocation.getCurrentPosition(function(pos){
				Lat = pos.coords.latitude;
				Lon = pos.coords.longitude;
				console.log(Lat+","+Lon+' > '+myLat+','+myLon); // OK!
				//meters=calculateDistance(lon,lat,myLon,myLat);
				//console.log(lon+","+lat+" + "+myLon+","+myLat+" = "+meters); // OK
			}, function(error) {
				alert('Es necesario que active la localizacion / ' + error.message);
				// error.code can be:
				// 0: unknown error
				// 1: permission denied
				// 2: position unavailable (error response from locaton provider)
				// 3: timed out
			});
		} // end geolocation
		//return parseInt(calculateDistance(lon,lat,myLon,myLat))+" metros";
		return Lon+","+Lat+","+myLon+","+myLat+" metros";
*/
function showPosition(position) {
	miubicacion[0] = position.coords.latitude; //.toFixed(3);
	miubicacion[1] = position.coords.longitude; //.toFixed(3);
	console.log(miubicacion);
	console.log(parseInt(calculateDistance(parseFloat(miubicacion[1]),parseFloat(miubicacion[0]),Lon1,Lat1))+" metros");
}
//console.log("* "+miubicacion[1]+","+miubicacion[0]);
function onError() {
	console.log("Geolocation failed.");
} // end onError()

if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(showPosition, onError);
	//return parseInt(calculateDistance(parseFloat(Lon2),parseFloat(Lat2),Lon1,Lat1))+" metros";
	return Lon1+","+Lat1+","+miubicacion[1]+","+miubicacion[0];
	//console.log(calculateDistance(parseFloat(Lon2),parseFloat(Lat2),Lon1,Lat1)+" metros");
} else {
	onError();
}
//
	};
});