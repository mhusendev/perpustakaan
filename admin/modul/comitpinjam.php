<?php
session_start();
include "../lib/koneksi.php";
include "../lib/appcode.php";
include "../lib/format.php";

$user=$_SESSION['id_user'];

$idp = generatepinjam();
$tskrg= date('Y-m-d');
$tglbalik=date('Y-m-d',strtotime('+7 days',strtotime($tskrg)));
if (isset($_GET['kduser'])) {
	  
      $sqlid=mysql_query("SELECT*FROM tmp_peminjaman WHERE kduser='".mysql_real_escape_string($_GET['kduser'])."'");

      $data = mysql_fetch_array($sqlid);

      if ($data == null) {
      	echo "<script type='text/javascript'>alert('Data tidak boleh Kosong');window.location.href = '../cekpinjam.php';</script>";
      	# code...
      }


      else {

            $query3=mysql_query("select  t.id,m.kduser,m.nama,b.isbn,b.judul,b.kategori,b.penerbit,b.stok  from member m JOIN tmp_peminjaman t ON m.kduser=t.kduser JOIN stok_buku b ON t.kdbuku=b.isbn  WHERE t.kduser = '".$_GET['kduser']."' ");
            $stkcek=mysql_fetch_array($query3);

if ($stkcek['stok']<0) {
 echo "<script type='text/javascript'>alert('Buku yang sama Melebihi stok kurangi buku yang sama');window.location.href = '../cekpinjam.php';</script>";
}
else{

$tot = mysql_num_rows($query3);

             $historipinjam=mysql_query("SELECT b.judul,m.pengarang,p.kdpinjam,p.tglpinjam,p.tglpengembalian,p.id_user From peminjaman p JOIN stok_buku b ON p.kdbuku=b.isbn JOIN master_buku m ON b.judul=m.judul WHERE p.kduser ='".mysql_real_escape_string($_GET['kduser'])."'" );
             $jmlhsebelum = mysql_num_rows($historipinjam);
              $settenggat =mysql_query("select * from setting");
              $restenggat = mysql_fetch_array($settenggat);
            $batasan = $restenggat['maxpinjam'];
            $tot2 = $tot + $jmlhsebelum;

           if ($tot2 > $batasan) {
                 echo "<script type='text/javascript'>alert('Peminjaman Melebihi Ketentuan!');window.location.href = '../peminjaman.php?kdm=".$_GET['kduser']."';</script>";
           } else{

       $sql =mysql_query("INSERT into peminjaman (kduser,kdbuku,tglpinjam) SELECT kduser,kdbuku,tglpinjam FROM tmp_peminjaman WHERE kduser ='".mysql_real_escape_string($_GET['kduser'])."'");

       	$sqldel =mysql_query("DELETE FROM tmp_peminjaman where kduser='".mysql_real_escape_string($_GET['kduser'])."' ");
       if ($sql) {

       $sqlup = mysql_query("UPDATE peminjaman set kdpinjam ='".$idp."',tglpengembalian='".mysql_real_escape_string($tglbalik)."', id_user='".$user."' WHERE kduser='".mysql_real_escape_string($_GET['kduser'])."' AND tglpinjam='".mysql_real_escape_string($tskrg)."' ");


       echo "<script type='text/javascript'>alert('Transaksi Peminjaman Berhasil');window.location.href = '../cekpinjam.php';</script>";

       	# code...
       } else{
echo "<script type='text/javascript'>alert('Transaksi Peminjaman Gagal');window.location.href = '../cekpinjam.php';</script>";

       }

}
      }
}
	 }
?>