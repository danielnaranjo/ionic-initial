<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');

	include('config.php');
	include('conexion.php');	

	$sql_locales="SELECT * FROM locals WHERE status=1";// LIMIT 0,1
  	$result_locales=mysql_query($sql_locales) or die("Error: No se pudo completar esta operacion. Error 0001");
  	$row_locales=mysql_fetch_array($result_locales);
  	$totales=mysql_num_rows($result_locales);

  	//echo "["; // start object
  	//echo '"locals":'; // starts locals
  	if($totales>0) {
  		echo "{";
  		do {

			$sql_menus="SELECT * FROM menus WHERE rID='".$row_locales[0]."' AND status=1 ORDER BY mID";
			$result_menus=mysql_query($sql_menus) or die("Error: No se pudo completar esta operacion. Error 0002");
			$row_menus=mysql_fetch_array($result_menus);
			$total_menus=mysql_num_rows($result_menus);

			$sql_promos="SELECT * FROM promos WHERE rID='".$row_locales[0]."' AND status=1 ORDER BY dID DESC";
			$result_promos=mysql_query($sql_promos) or die("Error: No se pudo completar esta operacion. Error 0003");
			$row_promos=mysql_fetch_array($result_promos);
			$total_promos=mysql_num_rows($result_promos); 

			$sql_photos="SELECT * FROM photos WHERE rID='".$row_locales[0]."' AND status=1 ORDER BY pID DESC";
			$result_photos=mysql_query($sql_photos) or die("Error: No se pudo completar esta operacion. Error 0004");
			$row_photos=mysql_fetch_array($result_photos);
			$total_photos=mysql_num_rows($result_photos); 

			$sql_comments="SELECT * FROM comments WHERE rID='".$row_locales[0]."' AND status=1 ORDER BY cID DESC";
			$result_comments=mysql_query($sql_comments) or die("Error: No se pudo completar esta operacion. Error 0005");
			$row_comments=mysql_fetch_array($result_comments);
			$total_comments=mysql_num_rows($result_comments); 

			echo '"rID" : "'.$row_locales['rID'].'", ';
			echo '"name" : "'.$row_locales['name'].'", ';
			echo '"description" : "'.$row_locales['description'].'", ';
			echo '"cuisine" : "'.$row_locales['cuisine'].'", ';
			echo '"address" : "'.$row_locales['address'].'", ';
			echo '"city" : "'.$row_locales['city'].'", ';
			echo '"state" : "'.$row_locales['state'].'", ';
			echo '"country" : "'.$row_locales['country'].'", ';
			echo '"phone" : "'.$row_locales['phone'].'", ';
			echo '"email" : "'.$row_locales['email'].'", ';
			echo '"web" : "'.$row_locales['web'].'", ';
			echo '"twitter" : "'.$row_locales['twitter'].'", ';
			echo '"facebook" : "'.$row_locales['facebook'].'", ';
			echo '"logo" : "'.$row_locales['logo'].'", ';
			echo '"geo" : "'.$row_locales['gps'].'", ';
			echo '"businesshours" : "'.$row_locales['businesshours'].'", ';
			echo '"payments" : "'.$row_locales['payments'].'", ';
			echo '"range" : "'.$row_locales['range'].'", ';
			echo '"features" : "'.$row_locales['features'].'", ';
			echo '"observaciones" : "'.$row_locales['observaciones'].'", ';
			echo '"registered" : "'.$row_locales['registered'].'", ';

			echo '"menus" : ['; // start menu
	/* 		if($total_menus>0) {
				echo "{";
				echo '"start" : "'.$row_menus['start'].'", ';
				echo '"main" : "'.$row_menus['main'].'", ';
				echo '"desserts" : "'.$row_menus['desserts'].'", ';
				echo '"drink" : "'.$row_menus['drink'].'", ';
				echo '"cafe" : "'.$row_menus['cafe'].'", ';
				echo '"note" : "'.$row_menus['note'].'", ';
				echo '"discount" : "'.$row_menus['discount'].'", ';
				echo '"price" : "'.$row_menus['price'].'", ';
				echo '"currency" : "'.$row_menus['currency'].'", ';
				echo '"validFrom" : "'.$row_menus['validFrom'].'", ';
				echo '"validTo" : "'.$row_menus['validTo'].'" ';
				echo "}, ";
			} */
			echo '],'; // end menus

			echo '"promos" : ['; // start promos
/* 			if($total_promos>0) {
				echo "{";
				echo '"coupon" : "'.$row_promos['coupon'].'", ';
				echo '"promo" : "'.$row_promos['promo'].'", ';
				echo '"conditions" : "'.$row_promos['conditions'].'", ';
				echo '"stock" : "'.$row_promos['stock'].'", ';
				echo '"notes" : "'.$row_promos['notes'].'", ';
				echo '"validFrom" : "'.$row_promos['validFrom'].'", ';
				echo '"validTo" : "'.$row_promos['validTo'].'" ';
				echo "}, ";
			} */
			echo '],'; // end promos

			echo '"photos" : ['; // start photos
/*			if($total_photos>0) {
	 			echo "{";
				echo '"photo" : "'.$row_photos['photo'].'", ';
				echo '"username" : "'.$row_photos['username'].'", ';
				echo '"date" : "'.$row_photos['date'].'" ';
				echo "}, ";
			} */
			echo '],'; // end photos

			echo '"comments" : ['; // start comments
/* 			if($total_comments>0) {
				echo "{";
				echo '"title" : "'.$row_comments['title'].'", ';
				echo '"text" : "'.$row_comments['text'].'", ';
				echo '"name" : "'.$row_comments['name'].'", ';
				echo '"email" : "'.$row_comments['email'].'", ';
				echo '"starts" : "'.$row_comments['starts'].'", ';
				echo '"date" : "'.$row_comments['date'].'" ';
				echo "}, ";
			} */
			echo '] '; // end comments
			echo "}, "; // locales
  		} while ($row_locales=mysql_fetch_array($result_locales));
  		//echo '}'; // starts locals
  	} // end totales

  	//echo "]"; // end object
?>