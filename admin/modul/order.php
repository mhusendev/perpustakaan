<?php
session_start();
include "../lib/koneksi.php";
include "../lib/appcode.php";
include "../lib/format.php";

$hitungan="n";
$flag=0;

if (isset($_POST['delete'])) {
  if ($_POST['id_hapus']!=="") {
	$select=mysql_query("SELECT total,id_order FROM order_detail WHERE pk ='".mysql_real_escape_string($_POST['id_hapus'])."'");
	$sel=mysql_fetch_array($select);

    $update=mysql_query("UPDATE order_main SET amount = amount-".$sel['total']." WHERE id_order ='".$sel['id_order']."' ");
    
    if (!$update) {
      echo "<script type='text/javascript'>alert('Gagal Update Amount');window.location.href = '../stock-out.php?jns=pending';</script>";
    } else {
      $hapus=mysql_query("DELETE FROM order_detail WHERE pk ='".mysql_real_escape_string($_POST['id_hapus'])."'");
      if (!$hapus) {
        echo "<script type='text/javascript'>alert('Gagal Hapus Produk');window.location.href = '../stock-out.php?jns=pending';</script>";
      } else {
        $hapus2=mysql_query("DELETE FROM pengiriman WHERE id_order = '".$sel['id_order']."'");
        if (!$hapus2) {
          echo "<script type='text/javascript'>alert('Gagal Hapus Pengiriman');window.location.href = '../stock-out.php?jns=pending';</script>";
        } else {
          echo "<script type='text/javascript'>alert('Berhasil Hapus Produk');window.location.href = '../stock-out.php?jns=pending';</script>";
        }
      }
    }
  }
}

if (isset($_POST['konfirmasi'])) {
	if ($_POST['appr']!=="") {
		$select=mysql_query("SELECT status FROM order_main WHERE id_order ='".mysql_real_escape_string($_POST['appr'])."'");
		$sel=mysql_fetch_array($select);
		if ($sel['status']=='n') {
			$update=mysql_query("UPDATE order_main SET status = 'c', approve_time = '".date('Y-m-d H:i:s')."', approve_by = '".$_SESSION['id_user']."' WHERE id_order ='".mysql_real_escape_string($_POST['appr'])."' ");
		    if (!$update) {
		    	echo "<script type='text/javascript'>alert('Gagal Update Status');window.location.href = '../stock-out.php?jns=pending';</script>";
		    } else {
		    	echo "<script type='text/javascript'>alert('Update Status Berhasil');window.location.href = '../stock-out.php?jns=pending';</script>";
		    }
		} else {
			echo "<script type='text/javascript'>alert('Konfirmasikan Pesanan Sesuai urutan!');window.location.href = '../stock-out.php?jns=pending';</script>";
		}
	} else {
		echo "<script type='text/javascript'>alert('Gagal Konfirmasi Pesanan');window.location.href = '../stock-out.php?jns=pending';</script>";
	}
}

if (isset($_POST['resionly'])) {
	if ($_POST['sendresi']!=="") {
		$order=$_POST['sendresi'];
		$select=mysql_query("SELECT status FROM order_main WHERE id_order ='".mysql_real_escape_string($_POST['sendresi'])."'");
		$sel=mysql_fetch_array($select);
		if ($sel['status']=='c') {
			$update=mysql_query("UPDATE order_main SET resi = '".mysql_real_escape_string($_POST['noresi'])."' WHERE id_order ='".mysql_real_escape_string($_POST['sendresi'])."' ");
		    if (!$update) {
		    	echo "<script type='text/javascript'>alert('Gagal Update Status');window.location.href = '../stock-out.php?jns=pending';</script>";
		    	$flag=0;
		    } else {
		    	echo "<script type='text/javascript'>alert('Update Status Berhasil');</script>";
		    	$flag=1;
		    }
		} else {
			echo "<script type='text/javascript'>alert('Konfirmasikan Pesanan Sesuai urutan!');window.location.href = '../stock-out.php?jns=pending';</script>";
			$flag=0;
		}
	} else {
		echo "<script type='text/javascript'>alert('Gagal Konfirmasi Pesanan');window.location.href = '../stock-out.php?jns=pending';</script>";
		$flag=0;
	}
}

if (isset($_POST['paket'])) {
	if ($_POST['sendresi']!=="") {
		$order=$_POST['sendresi'];
		$select=mysql_query("SELECT status,id_cust,amount,ongkir FROM order_main WHERE id_order ='".mysql_real_escape_string($_POST['sendresi'])."'");
		$sel=mysql_fetch_array($select);
		$id_cust=$sel['id_cust'];
		$total_belanja=$sel['amount']-$sel['ongkir'];

		if ($sel['status']=='c') {
			$update=mysql_query("UPDATE order_main SET status = 's', resi = '".mysql_real_escape_string($_POST['noresi'])."' WHERE id_order ='".mysql_real_escape_string($_POST['sendresi'])."' ");
		    if (!$update) {
		    	echo "<script type='text/javascript'>alert('Gagal Update Status');window.location.href = '../stock-out.php?jns=pending';</script>";
		    	$flag=0;
		    } else {
		    	echo "<script type='text/javascript'>alert('Update Status Berhasil');</script>";
		    	
		    	$flag=1;
		    	
		    	$sql="SELECT id_product,qty FROM order_detail WHERE id_order = '".mysql_real_escape_string($_POST['sendresi'])."' ";
				$data=mysql_query($sql);
				while($row = mysql_fetch_array($data))
				{
					$query_3=mysql_query("UPDATE product SET qty=qty -  ".$row['qty']." WHERE id_product = '".$row['id_product']."' ");	
					if(!$query_3) {
						echo "<script type='text/javascript'>alert('Update Stok Gagal');</script>";
					} else {
						$hitungan="y";

						//echo "<script type='text/javascript'>alert('Update Status Berhasil');window.location.href = '../stock-out.php?jns=pending';</script>";
					}
				}
		    }
		} else {
			echo "<script type='text/javascript'>alert('Konfirmasikan Pesanan Sesuai urutan!');window.location.href = '../stock-out.php?jns=pending';</script>";
			$flag=0;
		}
	} else {
		echo "<script type='text/javascript'>alert('Gagal Konfirmasi Pesanan');window.location.href = '../stock-out.php?jns=pending';</script>";
		$flag=0;
	}
}

if (isset($_POST['pesanan'])) {
	if ($_POST['send']!=="") {
		$order=$_POST['send'];
		$select=mysql_query("SELECT status,id_cust,amount,ongkir FROM order_main WHERE id_order ='".mysql_real_escape_string($_POST['send'])."'");
		$sel=mysql_fetch_array($select);
		$id_cust=$sel['id_cust'];
		$total_belanja=$sel['amount']-$sel['ongkir'];

		if ($sel['status']=='c') {
			$update=mysql_query("UPDATE order_main SET status = 's' WHERE id_order ='".mysql_real_escape_string($_POST['send'])."' ");
		    if (!$update) {
		    	echo "<script type='text/javascript'>alert('Gagal Update Status');window.location.href = '../stock-out.php?jns=pending';</script>";
		    } else {
		    	$sql="SELECT id_product,qty FROM order_detail WHERE id_order = '".mysql_real_escape_string($_POST['send'])."' ";
				$data=mysql_query($sql);
				while($row = mysql_fetch_array($data))
				{
					$query_3=mysql_query("UPDATE product SET qty=qty -  ".$row['qty']." WHERE id_product = '".$row['id_product']."' ");	
					if(!$query_3) {
						echo "<script type='text/javascript'>alert('Update Stok Gagal');</script>";
					} else {
						$hitungan="y";

						//echo "<script type='text/javascript'>alert('Update Status Berhasil');window.location.href = '../stock-out.php?jns=pending';</script>";
					}
				}
		    }
		} else {
			echo "<script type='text/javascript'>alert('Konfirmasikan Pesanan Sesuai urutan!');window.location.href = '../stock-out.php?jns=pending';</script>";
		}
	} else {
		echo "<script type='text/javascript'>alert('Gagal Konfirmasi Pesanan');window.location.href = '../stock-out.php?jns=pending';</script>";
	}
}

if ($flag==1) {
	$cari=mysql_query("SELECT email FROM pengiriman WHERE id_order='".$order."'");
	$dt=mysql_fetch_array($cari);
	$email=$dt['email'];

	date_default_timezone_set("Asia/Bangkok");

	$from = "MIME-Version: 1.0\r\n";
	$from .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$from .= "From: RocketDimsum <rocketdimsum@gmail.com>";
	$to = "".$email."";
	//$to = "stevantong@gmail.com";
	$subject = "Order (".$order.") dalam perjalanan!";
	$body = "

	<img src='rocketdimsum.com/images/rocket-dimsum-logo-1.png'>
	<br>
	Hello! Order (".$order.") telah dikirim. 
	<br><br>
	Silahkan lakukan tracking pengiriman anda sesuai kurir order anda. Berikan waktu sekitar 12 jam sebelum resi ter-update di sistem kurir. 
	<br><a href='https://www.jne.co.id/id/tracking/trace'>CEK RESI JNE</a>
	<br><a href='http://sicepat.com/cek-resi'>CEK RESI SICEPAT</a>


	<br><br>

	<b>Nomor resi :</b> <br>
	".$_POST['noresi']."<br>
	<hr></hr>

	No Order : ".$order."	<br><br>	

	<table border=1>
	<tr><td>No</td><td>Nama Produk</td><td>Qty</td><td>Total</td></tr>
	";

	$berat =0;
	$total = 0;
	$x=1;
	$ongkir = 0;
	$fetch= mysql_query("SELECT p.berat,p.nm_product,d.qty,d.total,o.ongkir FROM order_detail d JOIN product p on d.id_product = p.id_product JOIN order_main o on o.id_order = d.id_order WHERE d.id_order='".$order."' ");
	while($row = mysql_fetch_array($fetch))
	{
		$ongkir = $row['ongkir'];
		$berat = $berat+$row['berat'];
		$body=$body. '<tr><td>'.$x.'</td><td>'.$row['nm_product'].'</td><td>'.$row['qty'].'Pcs </td><td>'.money_idr($row['total']).'Pcs </td></tr>';
		$total = $total + $row['total'];
	}
	$total_ongkir = ceil($berat/1000)*$ongkir;

	$body = $body."</table>";

	$body = $body.'<br><b>BERAT</b> '.($berat/1000).' gr';
	$body = $body.'<br><b>ONGKIR</b> '.money_idr($total_ongkir);
	$body = $body.'<br><b>TOTAL</b> '.money_idr($total+$total_ongkir).'<hr></hr><br>';


	$body = $body."".$ket."
	<br>
	<hr></hr>

	<br>Cek status order harap login ke akun anda - <a href='rocketdimsum.com/login'>Login</a> 
	<br>Cek proses pengiriman - <a href='rocketdimsum.com/shipping'> Shipping </a>
	<br>Ada pertanyaan? - <a href='rocketdimsum.com/faq'> FAQ </a>  
	<br><br>
	Thank you for shopping! 

	";

	if(mail($to,$subject,$body,$from))
	{
	$process_status="success";
	}
	else
	{  
	$process_status="failed-email";
	}
	echo "<script type='text/javascript'>alert('".$process_status."')</script>";
}

if ($hitungan=='y') {
	//codingan hitung komisi point
	$i=1; $status="yes"; $id_member=$id_cust;
	while ($status=="yes" && $i<11) {
		$queries=mysql_query("SELECT id_parent FROM member WHERE id_member='".mysql_real_escape_string($id_member)."'");
		while ($komisi=mysql_fetch_array($queries)){
			if ($komisi['id_parent']=='root') {
				$status="no";
				rollback();
				echo "<script type='text/javascript'>alert('Parent = ROOT');</script>";
			} else {
				$sql=mysql_query("SELECT * FROM komisi WHERE level = '".$i."' ORDER BY level ASC");
				$data=mysql_fetch_array($sql);

				$nominal=$data['komisi']*$total_belanja;

				$insert=mysql_query("INSERT INTO point (pk, id_order, id_user, nominal, tgl, status, tgl_redeem, id_redeem) VALUES ('','".$order."','".$komisi['id_parent']."','".$nominal."','".date('Y-m-d H:i:s')."','n','','')");
				if (!$insert) {
					rollback();
					$status="no";
					echo "<script type='text/javascript'>alert('Gagal Hitung Komisi');</script>";
				} else {
					commit();
					$status="yes";
					$id_member=$komisi['id_parent'];
					$i++;
				}
			}
		}
	}
}
?>