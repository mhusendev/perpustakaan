<?php
session_start();
include "../lib/koneksi.php";
include "../lib/appcode.php";
include "../lib/format.php";

if (isset($_POST['save'])) {
	if($_POST['pk']=="") {
		$valid=1;

		$query=mysql_query("SELECT kode FROM coupon WHERE kode = '".mysql_real_escape_string($_POST['kode'])."'");
		$cek=mysql_num_rows($query);
		if ($cek>0) {
			$valid=0;
			$msg="Kode kupon tidak boleh sama, Buat kupon gagal";
		} else {
			$valid=1;
			$include="";
			if (isset($_POST['include']) && $_POST['include']!=="") {
			    $number = count($_POST['include']);
			    for($i=0; $i<$number; $i++) {
			        if(trim($_POST['include'][$i] != '')) {
			          	$include=$include.'|'.$_POST['include'][$i];
			        }
			    }
			    //$include=substr($include, 1);
			}
			    
			$exclude="";
			if (isset($_POST['exclude']) && $_POST['exclude']!=="") {
			    $number = count($_POST['exclude']);
			    for($i=0; $i<$number; $i++) {
			        if(trim($_POST['exclude'][$i] != '')) {
			          	$exclude=$exclude.'|'.$_POST['exclude'][$i];
			        }
			    }
			    //$exclude=substr($exclude, 1);
			}

			$sql=mysql_query("INSERT INTO coupon (kode, include, exclude, disc_rp, disc_prs, min_order, kurir, ongkir, freeongkir, min_qty, jml_pakai, untuk, mulai, expired, deskripsi) VALUES ('".mysql_real_escape_string($_POST['kode'])."','".mysql_real_escape_string($include)."','".mysql_real_escape_string($exclude)."','".mysql_real_escape_string($_POST['disc_rp'])."','".mysql_real_escape_string($_POST['disc_prs'])."','".mysql_real_escape_string($_POST['min_order'])."','".mysql_real_escape_string($_POST['kurir'])."','".mysql_real_escape_string($_POST['ongkir'])."','".mysql_real_escape_string($_POST['freeongkir'])."','".mysql_real_escape_string($_POST['min_qty'])."','".mysql_real_escape_string($_POST['jml_pakai'])."','".mysql_real_escape_string($_POST['untuk'])."','".mysql_real_escape_string($_POST['mulai'])."','".mysql_real_escape_string($_POST['expired'])."','".mysql_real_escape_string($_POST['deskripsi'])."')");

			if ($sql) {
				$valid=1;
				$msg="Update Coupon Success";
			} else {
				$valid=0;
				$msg="Update Coupon Failed";
			}
		}
	} else {
		$valid=1;

		$include="";
		if (isset($_POST['include']) && $_POST['include']!=="") {
		    $number = count($_POST['include']);
		    for($i=0; $i<$number; $i++) {
		        if(trim($_POST['include'][$i] != '')) {
		          	$include=$include.'|'.$_POST['include'][$i];
		        }
		    }
		    //$include=substr($include, 1);
		}
		    
		$exclude="";
		if (isset($_POST['exclude']) && $_POST['exclude']!=="") {
		    $number = count($_POST['exclude']);
		    for($i=0; $i<$number; $i++) {
		        if(trim($_POST['exclude'][$i] != '')) {
		          	$exclude=$exclude.'|'.$_POST['exclude'][$i];
		        }
		    }
		    //$exclude=substr($exclude, 1);
		}

		$sql=mysql_query("UPDATE coupon SET include='".mysql_real_escape_string($include)."',exclude='".mysql_real_escape_string($exclude)."',disc_rp='".mysql_real_escape_string($_POST['disc_rp'])."',disc_prs='".mysql_real_escape_string($_POST['disc_prs'])."',min_order='".mysql_real_escape_string($_POST['min_order'])."',kurir='".mysql_real_escape_string($_POST['kurir'])."',ongkir='".mysql_real_escape_string($_POST['ongkir'])."',freeongkir='".mysql_real_escape_string($_POST['freeongkir'])."',min_qty='".mysql_real_escape_string($_POST['min_qty'])."',jml_pakai='".mysql_real_escape_string($_POST['jml_pakai'])."',untuk='".mysql_real_escape_string($_POST['untuk'])."',mulai='".mysql_real_escape_string($_POST['mulai'])."',expired='".mysql_real_escape_string($_POST['expired'])."',deskripsi='".mysql_real_escape_string($_POST['deskripsi'])."' WHERE kode='".mysql_real_escape_string($_POST['pk'])."'");
		
		if ($sql) {
			$valid=1;
			$msg="Update Coupon Success";
		} else {
			$valid=0;
			$msg="Update Coupon Failed";
		}
	}

	if ($valid==0) {
		rollback();
		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../coupon.php';</script>";
	} else {
		commit();
		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../coupon.php';</script>";
	}
}

if (isset($_POST['delete'])) {
	$valid=1;
	$query=mysql_query("DELETE FROM coupon WHERE kode='".mysql_real_escape_string($_POST['id_hapus'])."'");
	if (!$query) {
		$valid=0;
		$msg="ERROR : Delete Coupon Failed";
	}

	if($valid==0) {  
		rollback();
		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../coupon.php';</script>";
	} else { 
		commit();
		$msg="Delete Data Success";
		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../coupon.php';</script>";
	}
}
?>