$(document).ready(function() {
	// begin 
	
	/* validate */ 
  $("#formsos").validate({
	  debug: false,
	  rules: {
		  comentarios: "required"
	  },
	  messages: {
		  comentarios: " * "
	  },
	  submitHandler: function(form) {
		  $.post('php/sos.php', $("#formsos").serialize(), function(data) {
			  $('#messagesos').html("<div class='alert alert-success'>" + data + "</div>");
			  $("#formsos")[0].reset();
			  setTimeout(function() {
				  $('#messagesos').hide();
			},3000);
		  });
	  }
  });


var miubicacion = [], ciudad = "", pais = "", Lat = "", Lon = "";
// Carga la GEO de HTML5
function showPosition(position) {
	miubicacion[0] = position.coords.latitude; //.toFixed(3);
	miubicacion[1] = position.coords.longitude; //.toFixed(3);
	console.log(miubicacion);
	// Compruebo que hay contenido?
	if (!miubicacion) {
		setTimeout(function() {
			setTimeout(function() {
				console.log(miubicacion[0]+','+miubicacion[1]);
			}, 3000);
		}, 2000);
	}
}
// Mensajes de Errores de GEO
function onError() {
	// Delay to..
	setTimeout(function() {
		// Set Latitute and Longitute by IP
		miubicacion[0]=Lat;
		miubicacion[1]=Lon;
		console.log("Geolocation failed. This message will not show again. Fix it with "+miubicacion);
	}, 2000);
}
/* Muestra Geo segun IP */
function WhereAmI() {
	$.getJSON('http://www.freegeoip.net/json/', function(location) {
		//Lat=location.latitude;
		//Lon=location.longitude;
		ciudad=location.city;
		pais=location.country_name;
		dip=location.ip;
		console.log('OK '+pais +' '+ ciudad);
	});
}
/* Geolocalization HTML5 */
function checkPosition() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition, onError);
	} else {
		onError();
	}
}
 // end 
  } );