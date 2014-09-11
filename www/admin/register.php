<?php
  session_start(); 
  include('config.php');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Administrador</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
  <!--<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->

  <link rel="stylesheet" href="app.css"/>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Administrador</a>
        </div>
      </div>
    </div>
     <div class="container">
          <div class="row">
            <div class="col-md-12">
<?
  if(isset($_POST['submit'])) {
	    include('conexion.php');
    
        $sql="INSERT INTO administradores (nombres, email, usuario, contrasena, fecha, nivel, status) VALUES ('".$n."', '".$e."', '".$u."', '".md5($c)."','".date('Y-m-d')."', '2', '1')";
        mysql_query($sql) or die("Error: No es posible completar esta solicitud, por favor, contacta al admnistrador de este sitio. ");

        $mensaje ="Hola ".$contacto.", \n\n";
        $mensaje.="Gracias por registrarse en nuestra aplicacion, visita ".$URL." para continuar.\n\n";
        $mensaje.="Nombre: ".$n." (".$e.")\n";
        $mensaje.="Usuario: ".$u."\n";
        $mensaje.="Contraseña: ".$c."\n\n";
        $mensaje.="Saludos\n\nEquipo de Marketing\n";
		$mensaje.=$URL."\n\n";
        $mensaje.="*** Cuenta NO monitoreada, por favor, NO responda este mensaje. Informacion enviada desde la direccion IP: ".$_SERVER['REMOTE_ADDR'].", a las ".date('d/m/Y H:i').". Se omite los acentos y tildes para mayor compatibilidad. *** \n";

        $asunto="Hola $n, gracias por registrarte en ".$URL;
        $header="From: Registro <no-responder@".$URL.">"; 

        if($_SERVER['HTTP_ACCEPT_LANGUAGE']=="") {
          exit();
        } else {
          @mail($email, $asunto, $mensaje, $header) or die('Error: No pudo completarse la accion');
          @mail("dnaranjo@gmail.com", $asunto, $mensaje, $header) or die('Error: No pudo completarse la accion');
        }

        $GLOBALS['editor'] = $row['usuario'];
        $GLOBALS['iduser'] = mysql_insert_id();
        session_register("editor");
        session_register("iduser");    

		    echo '<div style="margin:200px auto;">';
        echo '<div class="alert alert-success" role="alert">Redireccionando... (En unos minutos recibira un correo de confirmacion.)</div>';
        echo "<meta http-equiv=\"refresh\" content=\"3;URL=index.php?section=locals&action=new\" />";
		    echo "</div>";
      } 
  else 
      {
?>
         <form class="form-signin" role="form" action="" method="post" id="form" name="form" >
              <h2 class="form-signin-heading">Registrese</h2>
              <input type="text" class="form-control" placeholder="Nombre" id="n" name="n">
              <input type="text" class="form-control" placeholder="E-mail" id="e" name="e">
              <input type="text" class="form-control" placeholder="Usuario" id="u" name="u">
              <input type="password" class="form-control" placeholder="Contraseña" id="c" name="c">
              <input name="submit" type="submit" id="submit" value="Entrar" class="btn btn-lg btn-primary btn-block" >
              <div class="message"></div>
              <p style="margin:20px 0;"><a href="login.php?<?=md5(date('dmYHi'))?>">Login</a> | <a href="forgot.php?<?=md5(date('dmYHi'))?>">Olvide mi contraseña</a></p>
            </form>
<?php
      } // form
?>
			</div>
          </div>
        </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>
</html>