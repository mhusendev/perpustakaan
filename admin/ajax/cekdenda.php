<?php

header('Content-Type: text/xml');
include "../lib/koneksi.php";
$tglkembali = $_GET['tgkb'];
$batas = $_GET['batas'];



echo '<response>';




$tgl = date_create(date($tglkembali));
$tglbts = date_create(date($batas)) ;
$s =date_diff($tgl,$tglbts);
 
 if ($tgl!= null) {
 	# code...
 
 
      	echo $s->format('%a');}
      	else{

      		echo "0";
      	}
      	# code...





echo '</response>';

?>
