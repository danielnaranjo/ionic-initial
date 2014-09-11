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
      $sql="SELECT usuario, iduser, DATE_FORMAT(fecha,'%d/%m/%Y' ) AS ultimo, empresa FROM administradores WHERE usuario='".$u."' AND contrasena='".md5($c)."' AND status=1 ";
      $result=mysql_query($sql) or die(mysql_error());
      $row=mysql_fetch_array($result);
      $total=mysql_num_rows($result);
      $total=1; 

      if($total>0) {      
        $update="UPDATE administradores SET fecha='".date('Y-m-d')."' WHERE iduser='".$row['iduser']."' ";
        $result=mysql_query($update) or die(mysql_error()); 

        $GLOBALS['editor'] = $row['usuario'];
        $GLOBALS['empresa'] = $row['empresa'];
        $GLOBALS['iduser'] = $row['iduser'];
        session_register("editor");
        session_register("empresa");
        session_register("iduser");    

		    echo '<div style="margin:200px auto;">';
        echo "<h3>Redireccionando...</h3>";
        echo "<meta http-equiv=\"refresh\" content=\"3;URL=index.php?section=dashboard\" />";
		    echo "</div>";
        }
      else 
        {
		    echo '<div style="margin:200px auto;">';
        echo "<h3>Error: Intente nuevamente..</h3>";
		    echo "</div>";
        //echo "<meta http-equiv=\"refresh\" content=\"3\" />";
        }
      } 
  else 
      {
?>
         <form class="form-signin" role="form" action="" method="post" id="form" name="form" >
              <h2 class="form-signin-heading">Datos de acceso</h2>
              <input type="usuario" class="form-control" placeholder="Usuario" id="u" name="u" value="<?php echo $_GET['x']?>">
              <input type="password" class="form-control" placeholder="Contraseña" id="c" name="c">
              <input name="submit" type="submit" id="submit" value="Entrar" class="btn btn-lg btn-primary btn-block" >
              <div class="message"></div>
              <p style="margin:20px 0;"><p><a href="register.php?<?=md5(date('dmYHi'))?>">Registrese</a> | <a href="forgot.php?<?=md5(date('dmYHi'))?>">Olvide mi contraseña</a></p>
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