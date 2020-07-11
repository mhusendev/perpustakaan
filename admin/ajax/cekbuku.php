<?php

header('Content-Type: text/xml');
include "../lib/koneksi.php";
$nama = $_GET['kdb'];

// membuat root tag elemen

echo '<response>';

// daftar anggota keluarga
$sql= mysql_query("select * from stok_buku where isbn ='".mysql_real_escape_string($_GET['kdb'])."'");

$myFamily = mysql_fetch_array($sql);

// jika nama berada dalam daftar anggota keluarga

if ($sql)
     echo " ".htmlentities($myFamily['judul']);

// jika nama masih kosong

else if (trim($nama) == '')
     echo 'Hai orang asing, silakan tulis namamu';


// jika nama tidak ada dalam daftar anggota keluarga

else
     echo '&lt;strong&gt;' . htmlentities($nama) . 
          '&lt;/strong&gt;, Anda bukan anggota keluarga saya';

// menutup root tag elemen

echo '</response>';

?>
