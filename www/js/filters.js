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
		var Lat1 = "",Lon1 = "",Lat2 = "",Lon2 = "",metros = "",miubicacion=[];
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
		// if (navigator.geolocation) {
		// 	navigator.geolocation.getCurrentPosition(function(position){
		// 		Lat2 = position.coords.latitude;
		// 		Lon2 = position.coords.longitude;
		// 	});
		// } else {
		// 	console.log("Geolocation failed.");
		// }

		function showPosition(position) {
			miubicacion[0] = position.coords.latitude;
			miubicacion[1] = position.coords.longitude;
			//console.log("*"+miubicacion[0]+','+miubicacion[1]);
			//alert(miubicacion[0]+','+miubicacion[1]);
			return miubicacion[0],miubicacion[1];
		}
		function onError(){
			console.log("Geolocation failed.");
		}

		//function checkPosition() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition, onError);
				console.log(Lon1+","+Lat1+","+miubicacion[0]);
			} else {
				onError();
			}
		//}
		//var distancia=checkPosition();

		//console.log(Lon1+","+Lat1+","+miubicacion);
		metros=calculateDistance(parseFloat(Lon2),parseFloat(Lat2),Lon1,Lat1);
		//console.log(metros+","+Lon1+","+Lat1+","+Lon2+","+Lat2+" metros")
		return metros+" metros";
		//return metros+" metros";
//
	};
});