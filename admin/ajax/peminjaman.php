<?php

header('Content-Type: text/xml');
include '../lib/koneksi.php';
include '../lib/appcode.php';
echo '<hasil>';
$kdm=$_GET['kdm'];
$kdb=$_GET['kdb'];
$id=$_GET['id'];


$op=$_GET['op'];


if ($op == "tampildata")
{
	$query="select  t.id,m.kduser,m.nama,b.isbn,b.judul,b.kategori,b.penerbit  from member m JOIN tmp_peminjaman t ON m.kduser=t.kduser JOIN stok_buku b ON t.kdbuku=b.isbn  WHERE t.kduser = '".$kdm."'";
	$hasil=mysql_query($query);
}
else if ($op=="simpandata")
{
	$query="insert into tmp_peminjaman (kduser,kdbuku,tglpinjam) values ('".$kdm."','".$kdb."','".date('Y-m-d')."')";
	mysql_query($query);
	$query="select  t.id,m.kduser,m.nama,b.isbn,b.judul,b.kategori,b.penerbit  from member m JOIN tmp_peminjaman t ON m.kduser=t.kduser JOIN stok_buku b ON t.kdbuku=b.isbn  WHERE t.kduser = '".$kdm."'";
	
  $querimin=mysql_query("select * from stok_buku where isbn ='".$kdb."'");

  $data = mysql_fetch_array($querimin);

  $stok = $data['stok'] - 1;

  $queriup = mysql_query("UPDATE stok_buku set stok ='".$stok."' where isbn ='".$kdb."'  ");
  
	$hasil=mysql_query($query);

  

}
else if ($op == "hapusdata")
{
   $query = "DELETE FROM tmp_peminjaman WHERE kduser = '".$kdm."' AND id ='".$id."'";
   mysql_query($query);
$query="select  t.id,m.kduser,m.nama,b.isbn,b.judul,b.kategori,b.penerbit  from member m JOIN tmp_peminjaman t ON m.kduser=t.kduser JOIN stok_buku b ON t.kdbuku=b.isbn  WHERE t.kduser = '".$kdm."'";

$queriplus=mysql_query("select * from stok_buku where isbn ='".$kdb."'");

  $data2 = mysql_fetch_array($queriplus);

  $stok2 = $data2['stok'] + 1;

  $queriupd = mysql_query("UPDATE stok_buku set stok ='".$stok2."' where isbn ='".$kdb."'  ");

   $hasil = mysql_query($query);
}

while ($data = mysql_fetch_array($hasil))
{
   echo "<pjm>";
     echo "<idpj>".$data['id']."</idpj>";
   echo "<kodeusr>".$data['kduser']."</kodeusr>";
      echo "<namausr>".$data['nama']."</namausr>";
   echo "<kodebuk>".$data['isbn']."</kodebuk>";
     echo "<judul>".$data['judul']."</judul>";
        echo "<kategori>".$data['kategori']."</kategori>";
           echo "<penerbit>".$data['penerbit']."</penerbit>";
   echo "</pjm>";
}

echo '</hasil>';

?>