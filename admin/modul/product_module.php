<?php
session_start();
include "../lib/koneksi.php";
include "../lib/appcode.php";
include "../lib/format.php";

if (isset($_POST['save'])) {
	//UNTUK SAVE PRODUCT BARU
	if ($_POST['id']=="") {
        $jml=0;
	    for($i=0; $i<count($_FILES['gambar']['name']); $i++) {
            if($_FILES['gambar']['name'][$i]=="") {
                $jml=1;
            }
            $ekstensi_diperbolehkan = array('png','jpg','bmp','jpeg','gif','PNG','JPG','BMP','JPEG','GIF');
            $gambar = $_FILES['gambar']['name'][$i];
            $x = explode('.', $gambar);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['gambar']['size'][$i];
            $file_tmp = $_FILES['gambar']['tmp_name'][$i];   

            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if($ukuran < 2044070){          
                    move_uploaded_file($file_tmp, '../../images/products/'.$gambar);
                    $path=$path."|images/products/".$_FILES['gambar']['name'][$i];
                } else {
                    echo "<script type='text/javascript'>alert('UKURAN FILE TERLALU BESAR');window.location.href = '../product.php';</script>";
                }
            } else {
                if ($jml==0) {
                    echo "<script type='text/javascript'>alert('EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN');window.location.href = '../product.php';</script>";
                }
            }
        }
        if ($jml==0) {
            $path_real=$path;
        } else {
            $path_real="";
        }
        $tag="";
        $number = count($_POST['tag']);
        for($i=0; $i<$number; $i++) {
            if(trim($_POST['tag'][$i] != '')) {
                $tag=$tag.' #'.$_POST['tag'][$i];
            }
        }
        $tag=substr($tag, 1);
        $id_product=generate_idproduct();
        $query=mysql_query("INSERT INTO product(jenis, id_product, nm_product, tag, berat, short, deskripsi, harga1, harga2, harga3, tgl, gambar, badge) VALUES ('".mysql_real_escape_string($_POST['jenis'])."','".$id_product."','".mysql_real_escape_string($_POST['nm_product'])."','".mysql_real_escape_string($tag)."','".mysql_real_escape_string($_POST['berat'])."','".mysql_real_escape_string($_POST['short'])."','".mysql_real_escape_string($_POST['deskripsi'])."','".mysql_real_escape_string($_POST['harga1'])."','".mysql_real_escape_string($_POST['harga2'])."','".mysql_real_escape_string($_POST['harga3'])."','".mysql_real_escape_string($_POST['tgl'])."','".$path_real."','".mysql_real_escape_string($_POST['badge'])."')");

        if ($query) {
            echo "<script type='text/javascript'>alert('Update Success');window.location.href = '../product.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('Update Failed');window.location.href = '../product.php';</script>";
        }
	
	//UNTUK EDIT PRODUCT
	} else {
        $jml=0;
		for($i=0; $i<count($_FILES['gambar']['name']); $i++) {
            if($_FILES['gambar']['name'][$i]=="") {
                $jml=1;
            }
            $ekstensi_diperbolehkan = array('png','jpg','bmp','jpeg','gif','PNG','JPG','BMP','JPEG','GIF');
            $gambar = $_FILES['gambar']['name'][$i];
            $x = explode('.', $gambar);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['gambar']['size'][$i];
            $file_tmp = $_FILES['gambar']['tmp_name'][$i];   

            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if($ukuran < 2044070){          
                    move_uploaded_file($file_tmp, '../../images/products/'.$gambar);
                    $path=$path."|images/products/".$_FILES['gambar']['name'][$i];
                } else {
                    echo "<script type='text/javascript'>alert('UKURAN FILE TERLALU BESAR');window.location.href = '../product.php';</script>";
                }
            } else {
                if ($jml==0) {
                    echo "<script type='text/javascript'>alert('EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN');</script>";
                }
            }
        }
        if ($jml==0) {
            $path_real=" gambar='".$path."',";
        } else {
            $path_real="";
        }
	    
        $tag="";
        $number = count($_POST['tag']);
            for($i=0; $i<$number; $i++) {
                if(trim($_POST['tag'][$i] != '')) {
                $tag=$tag.'|'.$_POST['tag'][$i];
            }
        }
	    $query=mysql_query("UPDATE product SET jenis='".mysql_real_escape_string($_POST['jenis'])."',nm_product='".mysql_real_escape_string($_POST['nm_product'])."',tag='".mysql_real_escape_string($tag)."',berat='".mysql_real_escape_string($_POST['berat'])."',short='".mysql_real_escape_string($_POST['short'])."',deskripsi='".mysql_real_escape_string($_POST['deskripsi'])."',harga1='".mysql_real_escape_string($_POST['harga1'])."',harga2='".mysql_real_escape_string($_POST['harga2'])."',harga3='".mysql_real_escape_string($_POST['harga3'])."',".$path_real."badge='".mysql_real_escape_string($_POST['badge'])."' WHERE id_product='".mysql_real_escape_string($_POST['id'])."'");

	    if ($query) {
	        echo "<script type='text/javascript'>alert('Update Success');window.location.href = '../product.php';</script>";
	    } else {
	        echo "<script type='text/javascript'>alert('Update Failed');window.location.href = '../product.php';</script>";
	    }
	}
}

if (isset($_POST['delete'])) {
	$valid=1;
	$query=mysql_query("DELETE FROM product WHERE id_product='".mysql_real_escape_string($_POST['id_hapus'])."'");
	if (!$query) {
		$valid=0;
		$msg="ERROR : Delete Data Failed";
	}

	if($valid==0) {  
		rollback();
		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../product.php';</script>";
	} else { 
		commit();
		$msg="Delete Data Success";
		echo "<script type='text/javascript'>alert('".$msg."');window.location.href = '../product.php';</script>";
	}
}
?>