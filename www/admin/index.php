<?php
	session_start();
	header("Cache-control: private");
	include('config.php');
	include('conexion.php');

	if($_SESSION['editor']=="") { header("Location: login.php?msg=error"); }
	if($_GET['accion']=="salir") { session_unregister('editor'); header("Location: login.php?msg=goodbye"); }	

  function fechas($x) {
    $sep=explode("/", $x);
    $dd=$sep[0]; 
    $mm=$sep[1]; 
    $anno=$sep[2];
    $fecha=$anno."-".$mm."-".$dd;
    return $fecha;     
    }
  function formato($x,$c) {
    $sep=explode("-", $x);
    $dd=$sep[2]; 
    $mm=$sep[1]; 
    $anno=$sep[0];
    if($c==true) {
      $fecha=$dd."/".$mm;
    } else {
      $fecha=$dd."/".$mm."/".$anno;
    }
    return $fecha;     
    }
  function ranking($x) {
    $estrellas="";
    for($i=0; $i<$x; $i++) {
      $estrellas.= "<i class=\"fa fa-star\" style=\"color:#f4e42a\"></i>";
    }
    return $estrellas;
  }
  function archivoNombre($nombre) {
    $valor=strtolower($nombre); // Ej. NOMBRE.DOC a nombre.doc
    $sep=explode(".",$valor);
    $extension=$sep[1];
    return $extension;
  }
  function activo($s) {
    if($_GET['section']==$s) {
      return "class=\"active\"";
    }
  }	
  // administrador
  $sql_seller="SELECT * FROM administradores WHERE iduser='".$_SESSION['iduser']."'";
  $result_seller=mysql_query($sql_seller) or die("Error: No se pudo completar esta operacion. Error CON001");
  $row_seller=mysql_fetch_array($result_seller);
  $total_seller=mysql_num_rows($result_seller);
  // Total de visitas
  $sql_total="SELECT * FROM locals WHERE aID='".$row_seller['iduser']."' ";
  $result_total=mysql_query($sql_total) or die("Error: No se pudo completar esta operacion. Error CON002");
  $row_total=mysql_fetch_array($result_total);
  $totales=mysql_num_rows($result_total);
  if($row_seller['nivel']!=1) {
  if($totales==0 && $_GET['section']!='locals' && $_GET['action']!='new') { echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?section=locals&action=new\">"; }
  }
  // Comentarios total
  $sql_vol="SELECT * FROM comments WHERE rID='".$row_total['rID']."'";
  $result_vol=mysql_query($sql_vol) or die("Error: No se pudo completar esta operacion. Error CON003");
  $volumen=mysql_fetch_array($result_vol);
  $volumenes=mysql_num_rows($result_vol);
  
  // Este mes
  $sqlm="SELECT SUM(stock), COUNT(*) FROM promos WHERE rID='".$row_total['rID']."' AND MONTH(validTo) =".date('m')." AND YEAR(validTo) =".date('Y');
  $resultm=mysql_query($sqlm) or die("Error: No se pudo completar esta operacion. Error CON004");
  $rowm=mysql_fetch_array($resultm);
  
  // mes anterior
  $sqla="SELECT SUM(stock), COUNT(*) FROM promos WHERE rID='".$row_total['rID']."' AND MONTH(validTo) =".date('m')." -1 AND YEAR(validTo) =".date('Y');
  $resulta=mysql_query($sqla) or die("Error: No se pudo completar esta operacion. Error CON004");
  $rowa=mysql_fetch_array($resulta);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Administrador</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="app.css"/>

</head>
<body>
    <div class="navbar" role="navigation">  <!-- navbar-inverse  navbar-fixed-top-->
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?section=dashboard"><?=$row_total['name'];?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="javascript:;" style="text-transform:capitalize">Hola <? echo $_SESSION['editor']?></a></li>
            <li><a href="?section=dashboard">Dashboard</a></li>
            <? if($row_seller['nivel']==1) { ?>
            <li><a href="?section=panel&nivel=1">Menu administrativo</a></li>
            <? } ?>
            <li><a href="?accion=salir">Salir</a></li>
          </ul>
        </div>
      </div>
    </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-3 col-md-2 sidebar">
          
            <ul class="nav nav-sidebar">
              <li><a href="?section=dashboard">Dashboard</a></li>
              <li><a href="?section=locals&action=<? if($totales>0) { echo "edit&rID=".$row_total['rID']; } else { echo "new"; } ?>">Locales</a></li>
            <? if($row_total>0) { ?>
              <li><a href="?section=maps&action=geo&rID=<?=$row_total['rID']; ?>">Ubicación</a></li>
              <li><a href="?section=menus&action=new">Menus diarios</a></li>
              <li><a href="?section=promos&action=new">Cupones promocionales</a></li>
            </ul>
            <ul class="nav nav-sidebar">
              <li><a href="?section=comments&action=all&rID=<?=$row_total['rID'];?>">Comentarios</a></li>
              <li><a href="?section=photos&action=all&rID=<?=$row_total['rID'];?>">Fotografias</a></li>
              <? } ?>
            </ul>
            
            <ul class="nav nav-sidebar">
              <li><a href="#sos" data-toggle="modal" data-target="#sos">Soporte técnico</a></li>
            </ul>
            
            <ul class="nav nav-sidebar">
            <li><a href="?accion=salir">Salir</a></li>
            </ul>
            
            <p>
            	<small>v.1.0 
            	<!-- #BeginDate format:Am3m -->09/06/2014  20:11<!-- #EndDate -->
            	</small>
            </p>
          </div>
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="margin-top:50px">
            <h1 class="page-header nomobile">Dashboard</h1>

            <div class="row nomobile">
              <div class="col-xs-6 col-sm-3">
                <div class="main-box infographic-box">
                  <i class="fa fa-calendar emerald-bg"></i>
                  <span class="headline">Este mes</span>
                  <h2 class="value"><?php echo $rowm[1] ?></h2>
                  <span class="headline" style="margin-top:-7px">&nbsp;</span>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3">
                <div class="main-box infographic-box">
                  <i class="fa fa-calendar-o emerald-bg"></i>
                  <span class="headline">Mes anterior</span>
                  <h2 class="value"><?php echo $rowa[1] ?></h2>
                  <span class="headline" style="margin-top:-7px">&nbsp;</span>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3">
                <div class="main-box infographic-box">
                  <i class="fa fa-comments emerald-bg"></i>
                  <span class="headline">Comentarios</span>
                  <h2 class="value"><?php if($volumenes>0) { echo $volumen[0]; } else { echo "0"; } ?></h2>
                  <span class="headline" style="margin-top:-7px">&nbsp;</span>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3">
                <div class="main-box infographic-box">
                  <i class="fa fa-eye emerald-bg"></i>
                  <span class="headline">Visitas</span>
                  <h2 class="value"><?php if($totales>0) { echo $row_total['visit']; } else { echo "0"; } ?></h2>
                  <span class="headline" style="margin-top:-7px">&nbsp;</span>
                </div>
              </div>
            </div>
<?php
  if($_GET['section']=="dashboard" || $_GET['section']=="") {
  // menus
  $sql_menus="SELECT * FROM menus WHERE rID='".$row_total['rID']."' ORDER BY mID DESC LIMIT 0,30";
  $result_menus=mysql_query($sql_menus) or die("Error: No se pudo completar esta operacion. Error ME005");
  $row_menus=mysql_fetch_array($result_menus);
  $total_menus=mysql_num_rows($result_menus); 
  // comentarios
  $sql_comments="SELECT * FROM comments WHERE rID='".$row_total['rID']."' ORDER BY date DESC LIMIT 0,10";
  $result_comments=mysql_query($sql_comments) or die("Error: No se pudo completar esta operacion. Error CO006");
  $row_comments=mysql_fetch_array($result_comments);
  $total_comments=mysql_num_rows($result_comments);
  // coupones
  // SELECT * FROM promos WHERE rID='".$row_total['rID']."' ORDER BY validTo DESC LIMIT 0,10
  $sql_redeem="SELECT redeem.name, redeem.email, redeem.redeem, promos.coupon FROM redeem, promos WHERE redeem.rID='".$row_total['rID']."' AND promos.dID=redeem.dID ORDER BY redeem DESC LIMIT 0,10";
  $result_redeem=mysql_query($sql_redeem) or die("Error: No se pudo completar esta operacion. Error RE007");
  $row_redeem=mysql_fetch_array($result_redeem);
  $total_redeem=mysql_num_rows($result_redeem); 
?>            
            <div class="row">
              <div class="col-md-4">
                <h3>Menus activos 
                  <a href="?section=menus&action=new" title="Nuevo" data-toggle="tooltip" ><i class="fa fa-pencil text-muted"></i></a>
                  <a href="#vermenus" data-toggle="modal" data-target="#vermenus" title="Ver" data-toggle="tooltip"><i class="fa fa-eye text-muted"></i></a> 
                </h3>
                <ul class="list-unstyled">
                  <? if($total_menus>0) { do {?>
                  <li><a href="?section=menus&action=edit&mID=<? echo $row_menus['mID'] ?>" title="Editar" data-toggle="tooltip" >Menu <? echo formato($row_menus['validFrom'],true) ?> al <? echo formato($row_menus['validTo'],true) ?></a> <a href="?section=menus&action=edit&mID=<? echo $row_menus['mID'] ?>" title="Editar" data-toggle="tooltip"><i class="fa fa-pencil-square-o text-muted"></i></a></li>
                  <? } while($row_menus=mysql_fetch_array($result_menus)); } else { ?>
                  <li><a href="?section=menus&action=new" title="Nuevo" data-toggle="tooltip" >No tienes menus publicados</a></li>
                  <? } ?>
                </ul>
              </div>
              <div class="col-md-4">
                <h3>Ultimos Comentarios <a href="?section=comments&action=all&rID=<?=$row_total['rID'];?>" title="Ver" data-toggle="tooltip"><i class="fa fa-eye text-muted"></i></a></h3>
                <ul class="list-unstyled">
                  <? if($total_comments>0) { do {?>
                  <li><? echo $row_comments['title'] ?> por <a href="mailto:<? echo $row_comments['email'] ?>?subject=feedback"><? echo $row_comments['name'] ?></a>  (<? echo formato($row_comments['date'],true) ?>) <?=ranking($row_comments['stars']) ?> <a href="mailto:<? echo $row_comments['email'] ?>?subject=feedback" title="Contactar" data-toggle="tooltip"><i class="fa fa-reply text-muted"></i></a> <a href="?section=comments&action=flag&cID=<?=$row_comments['cID']?>" title="Desactivar" data-toggle="tooltip"><i class="fa fa-flag text-danger"></i></a></li>
                  <? } while($row_comments=mysql_fetch_array($result_comments)); } else { ?>
                  <li><a href="javascript:;">No tienes comentarios</a></li>
                  <? } ?>
                </ul>
              </div>
              <div class="col-md-4">
                <h3>Ultimos cupones <a href="#verpromos" data-toggle="modal" data-target="#verpromos" title="Ver" data-toggle="tooltip"><i class="fa fa-eye text-muted"></i></a></h3>
                <ul class="list-unstyled">
                  <? if($total_redeem>0) { do {?>
                  <li><? echo $row_redeem['coupon'] ?> por <a href="mailto:<? echo $row_redeem['email'] ?>?subject=feedback" title="Contactar" data-toggle="tooltip"><? echo $row_redeem['name'] ?></a></li>
                  <? } while($row_redeem=mysql_fetch_array($result_redeem)); } else { ?>
                  <li><a href="javascript:;">No tienes cupones reclamados</a></li>
                  <? } ?>
                </ul>
              </div>
            </div><!-- dashboard -->
<?php } //dashboard ?>

<!-- administrativo -->
<?php
  if($_GET['section']=="panel" && $_GET['nivel']==1) {
  // menus
  $sql_menus="SELECT * FROM menus  ORDER BY mID DESC LIMIT 0,25";
  $result_menus=mysql_query($sql_menus) or die("Error: No se pudo completar esta operacion. Error ME005");
  $row_menus=mysql_fetch_array($result_menus);
  $total_menus=mysql_num_rows($result_menus); 
  // comentarios
  $sql_comments="SELECT * FROM comments ORDER BY date DESC LIMIT 0,25";
  $result_comments=mysql_query($sql_comments) or die("Error: No se pudo completar esta operacion. Error CO006");
  $row_comments=mysql_fetch_array($result_comments);
  $total_comments=mysql_num_rows($result_comments);
  // coupones
  $sql_redeem="SELECT redeem.name, redeem.email, redeem.redeem, promos.coupon FROM redeem, promos WHERE promos.dID=redeem.dID ORDER BY redeem DESC LIMIT 0,25";
  $result_redeem=mysql_query($sql_redeem) or die("Error: No se pudo completar esta operacion. Error RE007");
  $row_redeem=mysql_fetch_array($result_redeem);
  $total_redeem=mysql_num_rows($result_redeem); 
?>            
            <div class="row">
              <div class="col-md-4">
                <h3>Menus activos 
                  <a href="?section=menus&action=new" title="Nuevo" data-toggle="tooltip" ><i class="fa fa-pencil text-muted"></i></a>
                  <a href="#vermenus" data-toggle="modal" data-target="#vermenus" title="Ver" data-toggle="tooltip"><i class="fa fa-eye text-muted"></i></a> 
                </h3>
                <ul class="list-unstyled">
                  <? if($total_menus>0) { do {?>
                  <li><a href="?section=menus&action=edit&mID=<? echo $row_menus['mID'] ?>" title="Editar" data-toggle="tooltip" >Menu <? echo formato($row_menus['validFrom'],true) ?> al <? echo formato($row_menus['validTo'],true) ?></a> <a href="?section=menus&action=edit&mID=<? echo $row_menus['mID'] ?>" title="Editar" data-toggle="tooltip"><i class="fa fa-pencil-square-o text-muted"></i></a></li>
                  <? } while($row_menus=mysql_fetch_array($result_menus)); } else { ?>
                  <li><a href="?section=menus&action=new" title="Nuevo" data-toggle="tooltip" >No tienes menus publicados</a></li>
                  <? } ?>
                </ul>
              </div>
              <div class="col-md-4">
                <h3>Ultimos Comentarios <a href="?section=comments&action=all&rID=<?=$row_total['rID'];?>" title="Ver" data-toggle="tooltip"><i class="fa fa-eye text-muted"></i></a></h3>
                <ul class="list-unstyled">
                  <? if($total_comments>0) { do {?>
                  <li><? echo $row_comments['title'] ?> por <a href="mailto:<? echo $row_comments['email'] ?>?subject=feedback"><? echo $row_comments['name'] ?></a>  (<? echo formato($row_comments['date'],true) ?>) <?=ranking($row_comments['stars']) ?> <a href="mailto:<? echo $row_comments['email'] ?>?subject=feedback" title="Contactar" data-toggle="tooltip"><i class="fa fa-reply text-muted"></i></a> <a href="?section=comments&action=flag&cID=<?=$row_comments['cID']?>" title="Desactivar" data-toggle="tooltip"><i class="fa fa-flag text-danger"></i></a></li>
                  <? } while($row_comments=mysql_fetch_array($result_comments)); } else { ?>
                  <li><a href="javascript:;">No tienes comentarios</a></li>
                  <? } ?>
                </ul>
              </div>
              <div class="col-md-4">
                <h3>Ultimos cupones <a href="#verpromos" data-toggle="modal" data-target="#verpromos" title="Ver" data-toggle="tooltip"><i class="fa fa-eye text-muted"></i></a></h3>
                <ul class="list-unstyled">
                  <? if($total_redeem>0) { do {?>
                  <li><? echo $row_redeem['coupon'] ?> por <a href="mailto:<? echo $row_redeem['email'] ?>?subject=feedback" title="Contactar" data-toggle="tooltip"><? echo $row_redeem['name'] ?></a></li>
                  <? } while($row_redeem=mysql_fetch_array($result_redeem)); } else { ?>
                  <li><a href="javascript:;">No tienes cupones reclamados</a></li>
                  <? } ?>
                </ul>
              </div>
            </div><!-- dashboard -->
<?php } //dashboard ?>
<!-- administrativo -->

<?php if($_GET['section']=="menus" && $_GET['action']=="new") { ?>
<?php

  if($_POST) {

    $sql="INSERT INTO menus VALUES (NULL, 
      '".$rID."',
      '".$start."',
      '".$main."',
      '".$desserts."',
      '".$drink."',
      '".$cafe."',
      '".$note."',
      '".$discount."',
      '".$price."',
      '".$currency."',
      '".fechas($validFrom)."',
      '".fechas($validTo)."',
      '1')";
    mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error ME008");
    echo '<div class="alert alert-success" role="alert">Se ha publicado el menu</div>';
    echo '<meta http-equiv="refresh" content="3;URL=?section=dashboard">';
  }
?>
            <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Menus</h1>
              </div>
            </div>
            <form action="" method="post" id="form" name="form" class="form-inline" role="form">
              <input type="hidden" id="rID" name="rID" value="<? echo $row_total['rID']; ?>">
              <input type="hidden" id="currency" name="currency" value="Euro">
              <div class="row">  
                <div class="col-md-4">
                  <h3>Entradas</h3>
                  <textarea name="start" id="start" rows="20" class="form-control"></textarea>
                </div>
                <div class="col-md-4">
                  <h3>Principal</h3>
                  <textarea name="main" id="main" rows="20" class="form-control"></textarea>
                </div>
                <div class="col-md-4">
                  <h3>Postres</h3>
                  <textarea name="desserts" id="desserts" rows="20" class="form-control"></textarea>
                </div>
              </div>
              <div class="row" style="margin:20px 0;">
                <div class="col-md-12">
                  <h3>Complementarios</h3>
                  <div class="form-inline">
                    <div class="input-group">
                      <label>Bebidas</label>
                      <input type="text" id="drink" name="drink" value="No" placerholder="No" class="form-control"><br/>
                    </div>
                    <div class="input-group">
                      <label>Cafe</label>
                      <input type="text" id="cafe" name="cafe" value="No" placerholder="No" class="form-control"><br/>
                    </div>
                    <div class="input-group">
                      <label>Precio (ej. 20.00)</label>
                      <input type="text" id="price" name="price" placerholder="20.00" class="form-control"><br/>
                    </div>
                    <div class="input-group">
                      <label>Descuento (ej. 10%)</label>
                      <select class="form-control" id="discount" name="discount" >
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin:20px 0;">
                <div class="col-md-12">
                    <div class="input-group">
                      <label>Valido desde</label>
                      <input type="text" id="validFrom" name="validFrom" class="form-control">
                    </div>
                    <div class="input-group">
                      <label>Valido hasta</label>
                      <input type="text" id="validTo" name="validTo" class="form-control"><br/>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="input-group">
                    <p style="margin:50px 0;">
                      <button type="submit" class="btn btn-default">Agregar menu</button>
                    </p>
                  </div>
                </div>
              </div>
            </form>
<?php } // new menus ?>

<?php if($_GET['section']=="menus" && $_GET['action']=="edit") { 

  $sql="SELECT * FROM menus WHERE mID='".$_GET['mID']."'";
  $result=mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error ME009");
  $row=mysql_fetch_array($result);
  $total=mysql_num_rows($result); 

  if($_POST) {

    $sql="UPDATE menus SET start='".$start."', main='".$main."', desserts='".$desserts."', drink='".$drink."', cafe='".$cafe."', note='".$note."', discount='".$discount."', price='".$price."', currency='".$currency."', validFrom='".fechas($validFrom)."', validTo='".fechas($validTo)."' WHERE mID='".$mID."' ";
    mysql_query($sql) or die(mysql_error()." $sql");
    echo '<div class="alert alert-success" role="alert">Se ha actualiado el menu</div>';
    echo '<meta http-equiv="refresh" content="3;URL=?section=dashboard">';
  }
?>
            <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Menus</h1>
              </div>
            </div>
            <form action="" method="post" id="form" name="form" class="form-inline" role="form">
              <input type="hidden" id="rID" name="rID" value="<? echo $row['rID']; ?>">
              <input type="hidden" id="mID" name="mID" value="<? echo $_GET['mID']; ?>">
              <input type="hidden" id="currency" name="currency" value="Euro">
              <div class="row">  
                <div class="col-md-4">
                  <h3>Entradas</h3>
                  <textarea name="start" id="start" rows="20" class="form-control"><? echo $row['start']; ?></textarea>
                </div>
                <div class="col-md-4">
                  <h3>Principal</h3>
                  <textarea name="main" id="main" rows="20" class="form-control"><? echo $row['main']; ?></textarea>
                </div>
                <div class="col-md-4">
                  <h3>Postres</h3>
                  <textarea name="desserts" id="desserts" rows="20" class="form-control"><? echo $row['desserts']; ?></textarea>
                </div>
              </div>
              <div class="row" style="margin:20px 0;">
                <div class="col-md-12">
                  <h3>Complementarios</h3>
                  <div class="form-inline">
                    <div class="input-group">
                      <label>Bebidas</label>
                      <input type="text" id="drink" name="drink" value="<? echo $row['drink']; ?>" placerholder="No" class="form-control"><br/>
                    </div>
                    <div class="input-group">
                      <label>Cafe</label>
                      <input type="text" id="cafe" name="cafe" value="<? echo $row['cafe']; ?>" placerholder="No" class="form-control"><br/>
                    </div>
                    <div class="input-group">
                      <label>Precio (ej. 20.00)</label>
                      <input type="text" id="price" name="price" placerholder="20.00" value="<? echo $row['price']; ?>" class="form-control"><br/>
                    </div>
                    <div class="input-group">
                      <label>Descuento (ej. 10%)</label>
                      <select class="form-control" id="discount" name="discount" >
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    </div>

                  </div>
                </div>
              </div>
              <div class="row" style="margin:20px 0;">
                <div class="col-md-12">
                    <div class="input-group">
                      <label>Valido desde</label>
                      <input type="text" id="validFrom" name="validFrom" class="form-control" value="<? echo $row['validFrom']; ?>">
                    </div>
                    <div class="input-group">
                      <label>Valido hasta</label>
                      <input type="text" id="validTo" name="validTo" class="form-control" value="<? echo $row['validTo']; ?>"><br/>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="input-group">
                    <p style="margin:50px 0;">
                      <button type="submit" class="btn btn-default">Actualizar menu</button>
                    </p>
                  </div>
                </div>
              </div>
            </form>
<?php } //editar menus ?>

<?php if($_GET['section']=="promos" && $_GET['action']=="new") { 

  if($_POST) {

    $sql="INSERT INTO promos VALUES (NULL, 
      '".$rID."',
      '".$coupon."',
      '".fechas($validFrom)."',
      '".fechas($validTo)."',
      '".$promo."',
      '".$conditions."',
      '".$stock."',
      '".$notes."',
      '1')";
    mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error PN010");
    echo '<div class="alert alert-success" role="alert">Se ha publicado con exito</div>';
    echo '<meta http-equiv="refresh" content="3;URL=?section=dashboard">';
  }
?>
            <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Cupones promocionales <a href="#verpromos" data-toggle="modal" data-target="#verpromos" title="Ver" data-toggle="tooltip"><i class="fa fa-eye text-muted"></i></a></h1>
              </div>
            </div>
            <form action="" method="post" id="form" name="form" role="form">
              <input type="hidden" id="rID" name="rID" value="<? echo $row_total['rID']; ?>">
              <div class="row" style="margin:20px 0;">
                <div class="col-md-4">
                    <div class="input-group">
                      <label>Cupon</label>
                      <input type="text" id="coupon" name="coupon" placerholder="ej. CAFEGRATIS" class="form-control">
                    </div>
                    <div class="input-group">
                      <label>Promoción</label>
                      <input type="text" id="promo" name="promo" placerholder="50 cafes gratis" class="form-control">
                    </div>
                    <div class="input-group">
                      <label>Cupones disponibles</label>
                      <select class="form-control" id="stock" name="stock" >
                      <option>No</option>
                      <option>5</option>
                      <option>10</option>
                      <option>20</option>
                      <option>30</option>
                      <option>40</option>
                      <option>50</option>
                    </select>
                    </div>                    
                  </div>
                <div class="col-md-4">
                    <div class="input-group">
                      <label>Valido desde</label>
                      <input type="text" id="validFrom" name="validFrom" class="form-control">
                    </div>
                    <div class="input-group">
                      <label>Valido hasta</label>
                      <input type="text" id="validTo" name="validTo" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                      <label>Condiciones</label>
                      <input type="text" id="conditions" name="conditions" placerholder="ej. Compra minima 20 Euros" class="form-control">
                    </div>
                    <div class="input-group">
                      <label>Observaciones</label>
                      <input type="text" id="notes" name="notes" placerholder="ej. Compra minima 20 Euros" class="form-control">
                    </div>
                    <div class="input-group">
                      <p style="margin:50px 0;">
                        <button type="submit" class="btn btn-default">Agregar codigo promocional</button>
                      </p>
                    </div>
                </div>
              </div>
            </form>
<?php } // new promos ?>
<?php if($_GET['section']=="promos" && $_GET['action']=="edit") { 

  $sql="SELECT * FROM promos WHERE dID='".$_GET['dID']."'";
  $result=mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error PE011");
  $row=mysql_fetch_array($result);
  $total=mysql_num_rows($result); 

  if($_POST) {

    $sql="UPDATE promos SET 
    coupon='".$coupon."',
    validFrom='".fechas($validFrom)."',
    validTo='".fechas($validTo)."',
    promo='".$promo."',
    conditions='".$conditions."',
    stock='".$stock."',
    notes='".$notes."',
    validFrom='".fechas($validFrom)."', 
    validTo='".fechas($validTo)."' 
    WHERE mID='".$mID."' ";
    mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error PE014");
    echo '<div class="alert alert-success" role="alert">Se ha actualiado el menu</div>';
    echo '<meta http-equiv="refresh" content="3;URL=?section=dashboard">';
  }
?>
            <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Promociones</h1>
              </div>
            </div>
            <form action="" method="post" id="form" name="form" role="form">
              <input type="hidden" id="rID" name="rID" value="<? echo $row['rID']; ?>">
              <input type="hidden" id="dID" name="dID" value="<? echo $_GET['dID']; ?>">
              <input type="hidden" id="currency" name="currency" value="Euro">
              <div class="row" style="margin:20px 0;">
                <div class="col-md-4">
                    <div class="input-group">
                      <label>Cupon</label>
                      <input type="text" id="coupon" name="coupon" placerholder="ej. CAFEGRATIS" class="form-control" value="<?=$row['coupon'] ?>">
                    </div>
                    <div class="input-group">
                      <label>Promoción</label>
                      <input type="text" id="promo" name="promo" placerholder="50 cafes gratis" class="form-control" value="<?=$row['promo'] ?>">
                    </div>
                    <div class="input-group">
                      <label>Cupones disponibles</label>
                      <select class="form-control" id="stock" name="stock" >
                      <option>No</option>
                      <option>5</option>
                      <option>10</option>
                      <option>20</option>
                      <option>30</option>
                      <option>40</option>
                      <option>50</option>
                    </select>
                    </div>                    
                  </div>
                <div class="col-md-4">
                    <div class="input-group">
                      <label>Valido desde</label>
                      <input type="text" id="validFrom" name="validFrom" class="form-control" value="<?=$row['validFrom'] ?>">
                    </div>
                    <div class="input-group">
                      <label>Valido hasta</label>
                      <input type="text" id="validTo" name="validTo" class="form-control" value="<?=$row['validTo'] ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                      <label>Condiciones</label>
                      <input type="text" id="conditions" name="conditions" placerholder="ej. Compra minima 20 Euros" class="form-control" value="<?=$row['conditions'] ?>">
                    </div>
                    <div class="input-group">
                      <label>Observaciones</label>
                      <input type="text" id="notes" name="notes" placerholder="ej. Compra minima 20 Euros" class="form-control" value="<?=$row['notes'] ?>">
                    </div>
                    <div class="input-group">
                      <p style="margin:50px 0;">
                        <button type="submit" class="btn btn-default">Actualizar codigo promocional</button>
                      </p>
                    </div>
                </div>
              </div>
            </form>
<?php } //editar promos ?>


<?php if($_GET['section']=="comments" && $_GET['action']=="flag") { ?>
           <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Comentarios</h1>
              </div>
            </div>
<?
    $sql="UPDATE comments SET status=0 WHERE cID='".$_GET['cID']."' ";
    mysql_query($sql) or die(mysql_error());
    echo '<div class="alert alert-success" role="alert">Se ha desactivado el comentario</div>';
    echo '<meta http-equiv="refresh" content="5;URL=?section=dashboard">';
?>
<?php } //comments ?>

<?php if($_GET['section']=="comments" && $_GET['action']=="all") { 
  $sql="SELECT * FROM comments WHERE rID='".$_GET['rID']."' AND status=1";
  $result=mysql_query($sql) or die( mysql_error());
  $row=mysql_fetch_array($result);
  $total=mysql_num_rows($result); 
?>
            <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Comentarios</h1>
              </div>
            </div>
           <div class="row">
              <? if($total>0) { do { ?>
              <div class="col-md-3">
                <h3 style="margin:0;"><?=$row['title']; ?></h3>
                <p><?=ranking($row['stars'])?></p>
                <p><?=$row['text']; ?></p>
                <small>
                  Publicado por <a href="mailto:<?=$row['email']; ?>?subject=Feedback"><?=$row['name']; ?></a> (<?=formato($row['date'],true);?>) 
                  <a href="?section=comments&action=flag&cID=<?=$row['cID']?>" title="Desactivar" data-toggle="tooltip"><i class="fa fa-flag text-danger"></i></a>
                </small>
              </div>
              <? } while($row=mysql_fetch_array($result)); } else { ?>
              <div class="col-md-3">
                <h3>No hay comentarios publicados</h3>
              </div>
              <? } ?>
            </div>
<?php } //photos new ?>

<?php if($_GET['section']=="photos" && $_GET['action']=="all") { 
  $sql="SELECT * FROM photos WHERE rID='".$_GET['rID']."' AND status=1";
  $result=mysql_query($sql) or die( mysql_error());
  $row=mysql_fetch_array($result);
  $total=mysql_num_rows($result); 
?>
            <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Fotografias publicadas por usuarios</h1>
              </div>
            </div>
           <div class="row">
              <? if($total>0) { do { ?>
              <div class="col-md-3">
                <img src="../photos/<?=$row['photo']; ?>" alt="foto" class="img-responsive">
                <p>
                  Publicado por <a href="mailto:<?=$row['email']; ?>?subject=Feedback Sobre imagen"><?=$row['username']; ?></a> (<?=formato($row['date'],true);?>) 
                  <a href="?section=photos&action=flag&pID=<?=$row['pID']?>" title="Desactivar" data-toggle="tooltip"><i class="fa fa-flag text-danger"></i></a>
                </p>
              </div>
              <? } while($row=mysql_fetch_array($result)); } else { ?>
              <div class="col-md-3">
                <h3>No hay fotos publicadas</h3>
              </div>
              <? } ?>
            </div>
<?php } //photos new ?>

<?php if($_GET['section']=="photos" && $_GET['action']=="flag") { ?>
           <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Fotografias publicadas por usuarios</h1>
              </div>
            </div>
<?
    $sql="UPDATE photos SET status=0 WHERE pID='".$_GET['pID']."' ";
    mysql_query($sql) or die(mysql_error());
    echo '<div class="alert alert-success" role="alert">Se ha desactivado la fotografia</div>';
    echo '<meta http-equiv="refresh" content="5;URL=?section=dashboard">';
?>
<?php } //photos flag ?>


<?php if($_GET['section']=="locals" && $_GET['action']=="new") { 

if($_POST) {
    if (trim($_FILES['logo']['name'])!="") { 
        $path="../logos/";
        $archivo=date('Ym').'-'.md5(date('dmYHis')).".jpg";
        move_uploaded_file($_FILES['logo']['tmp_name'], $path.$archivo);
        }
    $sql="INSERT INTO locals VALUES (NULL, 
      '".$_SESSION['iduser']."',
      '".$name."',
      '".$description."',
      '".$cuisine."',
      '".$address."',
      '".$city."',
      '".$state."',
      '".$country."',
      '".$phone."',
      '".$email."',
      '".$web."',
      '".$twitter."',
      '".$facebook."',
      '".$archivo."',
      'No definido',
      '".$businesshours."',
      '".$payments."',
      'No definido',
      '".$features."',
      'No definido',
      '".date('Y-m-D')."',
      '0',
      '1')";
    mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error LN012");
    echo '<div class="alert alert-success" role="alert">Se ha agregado su establecimiento</div>';
    echo '<meta http-equiv="refresh" content="5;URL=?section=dashboard">';
}

?>
           <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Local (Restaurante, Bar, Cafe)</h1>
              </div>
            </div>
            <form role="form" action="" method="post" enctype="multipart/form-data" name="form" id="form">
              <input type="hidden" id="aID" name="aID" value="<?=$_SESSION['iduser']?>">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="ej. La pulperia de Victoria">
                  </div>
                  <div class="form-group">
                    <label>Especialidad</label>
                    <input type="text" class="form-control" id="cuisine" name="cuisine" placeholder="ej. Pasta, Mariscos">
                  </div>
                  <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Descripción">
                  </div>
                  <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Dirección">
                  </div>
                  <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="ej. Madrid">
                  </div>
                  <div class="form-group">
                    <label>Estado/Provincia/Departamento</label>
                    <input type="text" class="form-control" id="state" name="state" placeholder="ej. Madrid">
                  </div>
<!--                   <div class="form-group">
                    <label>Pais</label>
                    <input type="text" class="form-control" id="country" placeholder="Pais">
                  </div> -->
                  <input type="hidden" id="country" name="country" value="España">
                </div><!-- izq -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Telefono</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="ej. 915XXXXXX">
                  </div>
                  <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="ej. reservaciones@mirestaurante.es">
                  </div>
                  <div class="form-group">
                    <label>Sitio web</label>
                    <input type="text" class="form-control" id="web" name="web" placeholder="ej. www.mirestaurante.es">
                  </div>
                  <div class="form-group">
                    <label>Twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="ej. @mirestaurantes">
                  </div>
                  <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="ej. Facebook.com/mirestaurantes">
                  </div>     
                </div><!-- cent -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Horarios</label>
                    <input type="text" class="form-control" id="businesshours" name="businesshours" placeholder="ej. 11:00 a 23:00hrs">
                  </div>
                  <div class="form-group">
                    <label>Formas de pago</label>
                    <input type="text" class="form-control" id="payments" name="payments" placeholder="ej. Visa, Master, Amex, Sodexho Pass">
                  </div>
                  <div class="form-group">
                    <label>Caracteristicas</label>
                    <input type="text" class="form-control" id="features" name="features" placeholder="ej. WIFI,Valet,Parking,Terraza">
                  </div>
                  <div class="form-group">
                    <label>Logotipo</label>
                    <input type="file" id="logo" name="logo">
                    <p class="help-block">Formatos permitidos: PNG, JPG, GIF</p>
                  </div>
                  <button type="submit" class="btn btn-default">Agregar un local</button>  
                </div><!-- der -->
              </div>
          

            </form>
<?php } //locals new ?>
<?php if($_GET['section']=="locals" && $_GET['action']=="edit") { 

  $sql="SELECT * FROM locals WHERE rID='".$_GET['rID']."'";
  $result=mysql_query($sql) or die( mysql_error());
  $row=mysql_fetch_array($result);
  $total=mysql_num_rows($result); 

if($_POST) {

    if (trim($_FILES['logo']['name'])!="") { 
        $path="../logos/";
        $archivo=date('Ym').'-'.md5(date('dmYHis')).".jpg";
        move_uploaded_file($_FILES['logo']['tmp_name'], $path.$archivo);
        $actualizar=", logo='".$archivo."'"; 
        }
    $sql="UPDATE locals SET
      name='".$name."',
      description='".$description."',
      cuisine='".$cuisine."',
      address='".$address."',
      city='".$city."',
      state='".$state."',
      country='".$country."',
      phone='".$phone."',
      email='".$email."',
      web='".$web."',
      twitter='".$twitter."',
      facebook='".$facebook."',
      businesshours='".$businesshours."',
      payments='".$payments."',
      features='".$features."'
      $actualizar
      WHERE aID='".$aID."' ";
    mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error LE013");
    echo '<div class="alert alert-success" role="alert">Se ha agregado su establecimiento</div>';
    echo '<meta http-equiv="refresh" content="5;URL=?section=dashboard">';
}

?>
           <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">Local (Restaurante, Bar, Cafe)</h1>
              </div>
            </div>
            <form role="form" action="" method="post" enctype="multipart/form-data" name="form" id="form">
              <input type="hidden" id="aID" name="aID" value="<?=$_SESSION['iduser']?>">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="ej. La pulperia de Victoria" value="<?=$row['name']?>">
                  </div>
                  <div class="form-group">
                    <label>Especialidad</label>
                    <input type="text" class="form-control" id="cuisine" name="cuisine" placeholder="ej. Pasta, Mariscos" value="<?=$row['cuisine']?>">
                  </div>
                  <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Descripción" value="<?=$row['description']?>">
                  </div>
                  <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="<?=$row['address']?>">
                  </div>
                  <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="ej. Madrid" value="<?=$row['city']?>">
                  </div>
                  <div class="form-group">
                    <label>Estado/Provincia/Departamento</label>
                    <input type="text" class="form-control" id="state" name="state" placeholder="ej. Madrid" value="<?=$row['state']?>">
                  </div>
<!--                   <div class="form-group">
                    <label>Pais</label>
                    <input type="text" class="form-control" id="country" placeholder="Pais">
                  </div> -->
                  <input type="hidden" id="country" name="country" value="<?=$row['country']?>">
                </div><!-- izq -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Telefono</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="ej. 915XXXXXX" value="<?=$row['phone']?>">
                  </div>
                  <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="ej. reservaciones@mirestaurante.es" value="<?=$row['email']?>">
                  </div>
                  <div class="form-group">
                    <label>Sitio web</label>
                    <input type="text" class="form-control" id="web" name="web" placeholder="ej. www.mirestaurante.es" value="<?=$row['web']?>">
                  </div>
                  <div class="form-group">
                    <label>Twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="ej. @mirestaurantes" value="<?=$row['twitter']?>">
                  </div>
                  <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="ej. Facebook.com/mirestaurantes" value="<?=$row['facebook']?>">
                  </div>  
                  <? if($row['gps']!=""){?>
                  <div class="form-group">
                    <label>Ubicación / Geolocalización <a href="?section=maps&action=geo&rID=<?=$row['rID']?>"><i class="fa fa-pencil text-muted"></i></a></label>
                    <input type="text" class="form-control" value="<?=$row['gps']?>" disabled>
                  </div>
                  <? } ?>     
                </div><!-- cent -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Horarios</label>
                    <input type="text" class="form-control" id="businesshours" name="businesshours" placeholder="ej. 11:00 a 23:00hrs" value="<?=$row['businesshours']?>">
                  </div>
                  <div class="form-group">
                    <label>Formas de pago</label>
                    <input type="text" class="form-control" id="payments" name="payments" placeholder="ej. Visa, Master, Amex, Sodexho Pass" value="<?=$row['payments']?>">
                  </div>
                  <div class="form-group">
                    <label>Caracteristicas</label>
                    <input type="text" class="form-control" id="features" name="features" placeholder="ej. WIFI,Valet,Parking,Terraza" value="<?=$row['features']?>">
                  </div>
                  <div class="form-group">
                    <label>Logotipo (Opcional)</label>
                    <input type="file" id="logo" name="logo">
                    <p class="help-block">Formatos permitidos: PNG, JPG, GIF. Dejar en blanco sino desea actualizar el logotipo (<a href="../logos/<?=$row['logo']?>">Ver imagen actual</a>)</p>
                  </div>
                  <button type="submit" class="btn btn-default">Actualizar la información</button> <a href="javascript:;" class="btn btn-danger">Eliminar</a>
                </div><!-- der -->
              </div>
            </form>
<?php } //locals new ?>
<?php if($_GET['section']=="maps" && $_GET['action']=="geo") { ?>
<script src='https://api.tiles.mapbox.com/mapbox.js/v2.0.1/mapbox.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/v2.0.1/mapbox.css' rel='stylesheet' />
           <div class="row">
              <div class="col-md-12">
                <h1 class="page-header">
                  Ubicación por geolocalización y/o GPS 
                  <a href="#" id="geolocate"><i class="fa fa-location-arrow"></i></a>
                  <div id="caja">
                    <form action="" class="form-horizontal" role="form" method="post">
                      <input type="hidden" id="rID" name="rID" value="<?=$_GET['rID']; ?>">
                      <input type="hidden" name="geo" id="geo">
                      <button type="submit" class="btn btn-success">Actualizar <i class="fa fa-check white"></i></button>
                    </form>
<?
  if($_POST) {
    $sql="UPDATE locals SET gps='".$geo."' WHERE rID='".$rID."' ";
    mysql_query($sql) or die(mysql_error());
    echo '<div class="alert alert-success" role="alert">Se ha actualizado la localización</div>';
    echo '<meta http-equiv="refresh" content="5;URL=?section=dashboard">';
  }
?>
                  </div>
                </h1>
              </div>
            </div>
  <div id="map"></div>
<script src='https://code.jquery.com/jquery-1.11.0.min.js'></script>
<script>
L.mapbox.accessToken = 'pk.eyJ1IjoiZGFuaWVsbmFyYW5qbyIsImEiOiJ0d05EUmZZIn0.RmU3L89clZJdei0WCb-lYA';
var geolocate = document.getElementById('geolocate');
var map = L.mapbox.map('map', 'examples.map-i86nkdio',{
    // Disable default double-click behavior.
    doubleClickZoom: false
});
var myLayer = L.mapbox.featureLayer().addTo(map);
var Lat="";
var Lon="";
// This uses the HTML5 geolocation API, which is available on
// most mobile browsers and modern browsers, but not in Internet Explorer
//
// See this chart of compatibility for details:
// http://caniuse.com/#feat=geolocation
if (!navigator.geolocation) {
    geolocate.innerHTML = 'Geolocation is not available';
} else {
    geolocate.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();
        map.locate();
    };
}

// Once we've got a position, zoom and center the map
// on it, and add a single marker.
map.on('locationfound', function(e) {
    map.fitBounds(e.bounds);
    Lat = e.latlng.lat;
    Lon = e.latlng.lng;
    $('#caja').css('display','inline-block');
    $('#geo').val(Lat+','+Lon);
    myLayer.setGeoJSON({
        type: 'Feature',
        geometry: {
            type: 'Point',
            coordinates: [e.latlng.lng, e.latlng.lat]
        },
        properties: {
            'title': 'Estas en '+Lat+','+Lon+'.<br/>Haz clic en "Actualizar" para continuar.',
            'marker-color': '#ff8888',
            'marker-symbol': 'cafe',
            'draggable': true
        }
    });

    // And hide the geolocation button
    geolocate.parentNode.removeChild(geolocate);
})
.on('dblclick', function(e) {
    // Zoom exactly to each double-clicked point
    map.setView(e.latlng, map.getZoom() + 5);
});

// If the user chooses not to allow their location
// to be shared, display an error message.
map.on('locationerror', function() {
    geolocate.innerHTML = 'Position could not be found';
});


</script>

<?php } //photos flag ?>


          </div><!-- real time-->
      </div><!-- row -->
</div>
<!-- modal -->     
<div id="sos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:400px; height:auto; background-color:#FFF;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Soporte tecnico  o feedback</h3>
  </div>
  <div class="modal-body">
	    <div id="messagesos"></div>
         <form action="php/sos.php" method="post" enctype="multipart/form-data" id="formsos">
         <input name="nombres" type="hidden" value="<?php echo $row_seller['nombres'] ?>">
         <input name="email" type="hidden" value="<?php echo $row_seller['email'] ?>">
        <p>Es necesario que complete el siguiente formulario:</p>
          <strong>Comentarios:</strong><br />
          <textarea name="comentarios" cols="40" rows="15" id="comentarios" required  class="form-control"></textarea></p>
        <input name="Submit" type="submit" value="Enviar" id="enviar"  class="btn" />
  	</form>
  </div>
</div>

<div id="verpromos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:400px; height:auto; background-color:#FFF;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Cupones promocionales</h3>
  </div>
<?
  $sql="SELECT * FROM promos WHERE rID='".$row_total['rID']."'";
  $result=mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error PE011");
  $row=mysql_fetch_array($result);
  $total=mysql_num_rows($result); 
?>
  <div class="modal-body">
    <ul>
      <? if($total>0) { do { ?>
      <li><a href="?section=promos&action=edit&dID=<?=$row['dID']; ?>&coupon=<?=$row['coupon']; ?>"><?=$row['coupon']; ?></a>. (Validez <?=formato($row['validFrom'],true); ?> - <?=formato($row['validTo'],false); ?>) <a href="?section=promos&action=edit&dID=<?=$row['dID']; ?>&coupon=<?=$row['coupon']; ?>"><i class="fa fa-pencil-square-o"></i></a></li>
      <? } while($row=mysql_fetch_array($result)); } else { ?>
      <li>No tienes cupones publicados, agregar <a href="?section=promos&action=new">nuevo</a> <a href="?section=promos&action=new"><i class="fa fa-pencil"></i></a></li>
      <? } ?>
    </ul>
  </div>
</div> 

<div id="vermenus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:400px; height:auto; background-color:#FFF;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Menus disponibles</h3>
  </div>
<?
  $sql="SELECT * FROM menus WHERE rID='".$row_total['rID']."' ";
  $result=mysql_query($sql) or die("Error: No se pudo completar esta operacion. Error PE011");
  $row=mysql_fetch_array($result);
  $total=mysql_num_rows($result); 
?>
  <div class="modal-body">
    <ul>
      <? if($total>0) { do { ?>
      <li><a href="?section=menus&action=edit&mID=<?=$row['mID']; ?>">Menu <? echo formato($row['validFrom'],true) ?> al <? echo formato($row['validTo'],true) ?></a> <a href="?section=menus&action=edit&mID=<?=$row['mID']; ?>"><i class="fa fa-pencil-square-o"></i></a></li>
      <? } while($row=mysql_fetch_array($result)); } else { ?>
      <li>No tienes cupones publicados, agregar <a href="?section=menus&action=new">nuevo</a> <a href="?section=promos&action=new"><i class="fa fa-pencil"></i></a></li>
      <? } ?>
    </ul>
  </div>
</div>       
<!-- modal -->





<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="main.js"></script>
<script>
$(document).ready(function() {
    $('[rel="tooltip"]').tooltip();

    /* jQuery UI datepicker */
    $( "#validFrom" ).datepicker();
    $( "#validTo" ).datepicker();

    $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '<Ant',
      nextText: 'Sig>',
      currentText: 'Hoy',
      monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      weekHeader: 'Sm',
      dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);
     /* jQuery UI datepicker */
  });
</script>

</body>
</html>
