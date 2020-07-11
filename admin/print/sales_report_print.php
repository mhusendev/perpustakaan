<?php
	session_start();
	include "../lib/koneksi.php";
	include "../lib/appcode.php";
	include "../lib/format.php";
  
	if(!isset($_SESSION['id_user']) && !isset($_SESSION['grup']))
	{
	    header('Location:../login.php'); 
	}

	header("Content-type: application/vnd-ms-excel");
 
	header("Content-Disposition: attachment; filename=SalesReport.xls");
?>
<style type="text/css">
	th {
		font-weight: bold;
	}
</style>
<table border="1" style="border: 1px solid black">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Invoice</th>
			<th>Nama</th>
			<th>Telp</th>
			<th>Via</th>
			<th>Brand</th>
			<th>Nama Produk</th>
			<th>QTY</th>
			<th>Harga</th>
			<th>Disc Produk (Rp)</th>
			<th>Disc Produk (%)</th>
			<th>Bruto</th>
			<th>Disc Inv (Rp)</th>
			<th>Disc Inv (%)</th>
			<th>Net Total</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$n=1;
		$add="";
		if(isset($_GET['tgl1'])&&isset($_GET['tgl2'])) {
            $via="";
            if ($_GET['via']=='all') {
              $via="";
            } else {
              $via="and c.nm_acc = '".$_GET['via']."'";
            }
		}
		$sql=mysql_query("select a.id_so1, a.tgl_so, b.nm_cust, b.hp, c.nm_acc, a.disc_nominal, a.disc_persen, a.net_total from so1 a join tb_cust b on a.id_customer=b.id_cust join tb_account c on a.via=c.id_acc where a.tgl_so >= '".$_GET['tgl1']."' and a.tgl_so <= '".$_GET['tgl2']."' ".$via." order by a.tgl_so desc");
		while ($row = mysql_fetch_array($sql)) {
			echo '
		<tr>
			<td style="vertical-align:middle">'.$n.'</td>
			<td style="vertical-align:middle">'.date('d-m-Y', strtotime($row['tgl_so'])).'</td>
			<td style="vertical-align:middle">'.$row['id_so1'].'</td>
			<td style="vertical-align:middle">'.$row['nm_cust'].'</td>
			<td style="vertical-align:middle">'.$row['hp'].'</td>
			<td style="vertical-align:middle">'.$row['nm_acc'].'</td>
			';
			$query=mysql_query("select GROUP_CONCAT(c.nm_kategori SEPARATOR '<br>') brand, GROUP_CONCAT(b.nm_product SEPARATOR '<br>') product, GROUP_CONCAT(a.qty SEPARATOR '<br>') qty, GROUP_CONCAT(a.harga SEPARATOR '<br>') harga, GROUP_CONCAT(a.disc_nominal SEPARATOR '<br>') disr, GROUP_CONCAT(a.disc_persen SEPARATOR '<br>') disp, GROUP_CONCAT(a.total SEPARATOR '<br>') total from so2 a join product b on a.id_bahan=b.id_product join tb_kategori c on b.brand=c.id_kategori where a.id_so1='".$row['id_so1']."'");
			while ($cell = mysql_fetch_array($query)) {
				echo '
			<td>'.$cell['brand'].'</td>
			<td>'.$cell['product'].'</td>
			<td>'.$cell['qty'].'</td>
			<td>'.$cell['harga'].'</td>
			<td>'.$cell['disr'].'</td>
			<td>'.$cell['disp'].'</td>
			<td>'.$cell['total'].'</td>
				';
			}
			echo '
			<td style="vertical-align:middle">'.$row['disc_nominal'].'</td>
			<td style="vertical-align:middle">'.$row['disc_persen'].'</td>
			<td style="vertical-align:middle">'.$row['net_total'].'</td>
		</tr>
			';
			$n++;
		}
		?>
	</tbody>
</table>