<?php
session_start();
include "../lib/koneksi.php";
include "../lib/appcode.php";
include "../lib/format.php";

if (isset($_POST['save'])) {
	  
      $sqlid=mysql_query("SELECT*FROM master_buku WHERE id='".mysql_real_escape_string($_POST['judul'])."'");

      $data = mysql_fetch_array($sqlid);

	 $query=mysql_query("INSERT INTO stok_buku (judul,penerbit,tahun_terbit,isbn,stok,kategori) VALUES ('".mysql_real_escape_string($data['judul'])."','".mysql_real_escape_string($_POST['penerbit'])."','".mysql_real_escape_string($_POST['thn'])."','".mysql_real_escape_string($_POST['isbn'])."','".mysql_real_escape_string($_POST['stok'])."','".mysql_real_escape_string($data['kategori'])."')");
			    
 if ($query) {
   echo "<script type='text/javascript'>alert('Insert Success');window.location.href = '../stokbuku.php';</script>";
	  } else {
			        echo "<script type='text/javascript'>alert('Insert Failed');window.location.href = '../stokbuku.php';</script>";
			    }
	       

}

else {
if ($_POST['id2']){


	       $query=mysql_query("SELECT*FROM stok_buku WHERE id ='".mysql_real_escape_string($_POST['id2'])."'");

	       $row=mysql_fetch_array($query);

	       $jumlah = $_POST['stoktmbh'] + $row['stok'];

	       $querystok=mysql_query("UPDATE stok_buku SET stok='".mysql_real_escape_string($jumlah)."' WHERE id='".mysql_real_escape_string($_POST['id2'])."'");


if ($query) {
   echo "<script type='text/javascript'>alert('Operation Success');window.location.href = '../stokbuku.php';</script>";
	  } else {
			        echo "<script type='text/javascript'>alert('Operation Failed');window.location.href = '../stokbuku.php';</script>";
			    }

   
          } }
	        

// if (isset($_POST['delete'])) {
// 	$valid=1;
// 	$query=mysql_query("DELETE FROM slider WHERE id='".mysql_real_escape_string($_POST['id_hapus'])."'");
// 	if (!$query) {
// 		$valid=0;
// 		$msg="ERROR : Delete Data Failed";
// 	}

// 	if($valid==0) {  
// 		rollback();
// 		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../slider';</script>";
// 	} else { 
// 		commit();
// 		$msg="Delete Data Success";
// 		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../slider';</script>";
// 	}
// }
?>