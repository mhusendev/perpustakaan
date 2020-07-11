<?php

header('Content-Type: text/xml');
include "../lib/koneksi.php";
$nama = $_GET['kdm'];



echo '<response>';


$sql= mysql_query("select * from member where kduser ='".mysql_real_escape_string($_GET['kdm'])."'");

$myFamily = mysql_fetch_array($sql);



if ($sql)
     echo "Data ".htmlentities($myFamily['nama'])." Ditemukan";


else if (trim($nama) == '')
     echo 'Hai orang asing, silakan tulis namamu';



else
     echo '&lt;strong&gt;' . htmlentities($nama) . 
          '&lt;/strong&gt;, Anda bukan anggota keluarga saya';


echo '</response>';

?>
