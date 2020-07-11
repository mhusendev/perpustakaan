<?php
session_start();
include "../lib/koneksi.php";
include "../lib/appcode.php";
include "../lib/format.php";

if (isset($_POST['save'])) {
	if ($_POST['id']=="") {

	 $query=mysql_query("INSERT INTO stok_buku (judul,pengarang, kategori) VALUES ('".mysql_real_escape_string($_POST['judul'])."','".mysql_real_escape_string($_POST['pengarang'])."','".mysql_real_escape_string($_POST['kategori'])."')");
			    
 if ($query) {
   echo "<script type='text/javascript'>alert('Insert Success');window.location.href = '../slider.php';</script>";
	  } else {
			        echo "<script type='text/javascript'>alert('Insert Failed');</script>";
			    }
	       }

     else{ 
  $query1=mysql_query("UPDATE master_buku set judul= '".mysql_real_escape_string($_POST['judul'])."',set pengarang= '".mysql_real_escape_string($_POST['pengarang'])."' ,kategori ='".mysql_real_escape_string($_POST['kategori'])."' WHERE id='".mysql_real_escape_string($_POST['id'])."'");
			    
 if ($query1) {
   echo "<script type='text/javascript'>alert('update Success');window.location.href = '../slider.php';</script>";
	  } else {
			        echo "<script type='text/javascript'>alert('update Failed');</script>";
			    }
	       }
          } 


	        

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