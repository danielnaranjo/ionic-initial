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
// not working as suppost to 
.filter("maxLength", function(){
    return function(text,max){
        if(text !== null){
            if(text.length > max){
                return text.substring(0,max) + "...";
            }
        }
    };
})
// Separar de volver parametros
.filter('separados', function() {
	return function(input){
	var coords=input.split(','); // OK
    return coords[0]+':'+coords[1];
	};
})
// ok!
.filter('distancia', function(){
	return function(input,gps){
		var posicion=input.split(','); // OK
		var coords=gps.split(','); // OK
		// String a Numero
		Lat1=parseFloat(posicion[0]);
		Lon1=parseFloat(posicion[1]);
		Lat2=parseFloat(coords[0]);
		Lon2=parseFloat(coords[1]);
		//console.log('** '+Lat1+','+Lon1+','+coords[0]+','+coords[1]); //OK!
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
		metros=parseInt(calculateDistance(Lon2,Lat2,Lon1,Lat1)); // OK
		//console.log(metros);
		return metros+" mts";
	};
});