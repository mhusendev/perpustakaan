<?php
session_start();
include "../lib/koneksi.php";
include "../lib/appcode.php";
include "../lib/format.php";

if (isset($_POST['save'])) {
	if ($_POST['id']=="") {
      $kode =  generate_idmember();
	 $query=mysql_query("INSERT INTO member (kduser,nama, ttl,alamat,jabatan,nohp) VALUES ('".$kode."','".mysql_real_escape_string($_POST['nama'])."','".mysql_real_escape_string($_POST['ttl'])."','".mysql_real_escape_string($_POST['alamat'])."','".mysql_real_escape_string($_POST['jabatan'])."','".mysql_real_escape_string($_POST['nohp'])."')");
			    
 if ($query) {
   echo "<script type='text/javascript'>alert('Insert Success');window.location.href = '../member.php';</script>";
	  } else {
			        echo "<script type='text/javascript'>alert('Insert Failed');</script>";
			    }
	       }

     else{ 
  $query1=mysql_query("UPDATE member set nama= '".mysql_real_escape_string($_POST['nama'])."',ttl= '".mysql_real_escape_string($_POST['ttl'])."' ,alamat ='".mysql_real_escape_string($_POST['alamat'])."'
,jabatan ='".mysql_real_escape_string($_POST['jabatan'])."'
,nohp ='".mysql_real_escape_string($_POST['nohp'])."'
   WHERE id='".mysql_real_escape_string($_POST['id'])."'");
			    
 if ($query1) {
   echo "<script type='text/javascript'>alert('update Success');window.location.href = '../member.php';</script>";
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