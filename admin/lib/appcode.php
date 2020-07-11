<?php
	function generate_key_short($prefix,$nama,$bulan,$tahun)
	{
		$flag=0;
		$ambil_data=mysql_query("select * from tb_setup where nama_setup='".$nama."' ");
		while($row = mysql_fetch_array($ambil_data))
		{
			$flag=1;
			$no_id="".$prefix."".$bulan."".$tahun."".str_pad($row['ket3'], 4, 0, STR_PAD_LEFT)."";
			mysql_query("update tb_setup set ket3=".$row['ket3']."+1 where nama_setup='".$nama."'");
		}
		
		if ($flag==0)
		{
			mysql_query("insert into tb_setup values('','".$nama."','','',2) ");
			$no_id="".$prefix."".$bulan."".$tahun."0001";
		}
		return $no_id;
	}
				
	function generate_key($prefix,$nama,$bulan,$tahun)
	{
		$flag=0;
		$ambil_data=mysql_query("select * from tb_setup where nama_setup='".$nama."' and ket1='".$bulan."' and ket2='".$tahun."'");
		while($row = mysql_fetch_array($ambil_data))
		{
			$flag=1;
			$no_id="".$prefix."".$bulan."".$tahun."".str_pad($row['ket3'], 4, 0, STR_PAD_LEFT)."";
			mysql_query("update tb_setup set ket3=".$row['ket3']."+1 where nama_setup='".$nama."' and ket1='".$bulan."' and ket2='".$tahun."' ");
		}
		
		if ($flag==0)
		{
			mysql_query("insert into tb_setup values('','".$nama."','".$bulan."','".$tahun."',2) ");
			$no_id="".$prefix."".$bulan."".$tahun."0001";
		}
		return $no_id;
	}

	function generate_idmember() {
		$sql = "SELECT max(kduser) AS last FROM member";
		$query = mysql_query($sql) or die (mysql_error());
	 
		$kode_faktur = mysql_fetch_array($query);
	 
		if($kode_faktur){
			$nilai = substr($kode_faktur['last'], 7, 3);
			$kode = (int) $nilai;
	 
			//tambahkan sebanyak + 1
			$kode = $kode + 1;
			$auto_kode = "RDS". date('Y') .str_pad($kode, 3, "0",  STR_PAD_LEFT);
		} else {
			$auto_kode = "RDS". date('Y') ."001";
		}
		return $auto_kode;
	}

	function generatepinjam() {
		$sql = "SELECT max(kdpinjam) AS last FROM peminjaman";
		$query = mysql_query($sql) or die (mysql_error());
	 
		$kode_faktur = mysql_fetch_array($query);
	 
		if($kode_faktur){
			$nilai = substr($kode_faktur['last'], 7, 3);
			$kode = (int) $nilai;
	 
			//tambahkan sebanyak + 1
			$kode = $kode + 1;
			$auto_kode = "pjm". date('Y') .str_pad($kode, 3, "0",  STR_PAD_LEFT);
		} else {
			$auto_kode = "pjm". date('Y') ."001";
		}
		return $auto_kode;
	}
	function generate_idsupp() {
		$sql = "SELECT max(id_supp) FROM tb_supp";
		$query = mysql_query($sql) or die (mysql_error());
	 
		$kode_faktur = mysql_fetch_array($query);
	 
		if($kode_faktur){
			$nilai = substr($kode_faktur[0], 5);
			$kode = (int) $nilai;
	 
			//tambahkan sebanyak + 1
			$kode = $kode + 1;
			$auto_kode = "SUP" .str_pad($kode, 6, "0",  STR_PAD_LEFT);
		} else {
			$auto_kode = "SUP000001";
		}
		return $auto_kode;
	}

	function generate_idproduct() {
		$sql = "SELECT max(id_product) AS last FROM product";
		$query = mysql_query($sql) or die (mysql_error());
	 
		$kode_faktur = mysql_fetch_array($query);
	 
		if($kode_faktur){
			$nilai = substr($kode_faktur['last'] , 7, 3);
			$kode = (int) $nilai;
	 
			//tambahkan sebanyak + 1
			$kode = $kode + 1;
			$auto_kode = "PRO". date('ym') .str_pad($kode, 3, "0",  STR_PAD_LEFT);
		} else {
			$auto_kode = "PRO".date('ym')."001";
		}
		return $auto_kode;
	}
	
	function generate_transaction_key($prefix,$nama,$bulan,$tahun)
	{
		$flag=0;
		$ambil_data=mysql_query("select * from tb_setup where nama_setup='".$nama."' and ket1='".$bulan."' and ket2='".$tahun."'");
		while($row = mysql_fetch_array($ambil_data))
		{
			$flag=1;
			$no_id="".$prefix."/".$tahun."/".$bulan."/".str_pad($row['ket3'], 4, 0, STR_PAD_LEFT)."";
			mysql_query("update tb_setup set ket3=".$row['ket3']."+1 where nama_setup='".$nama."' and ket1='".$bulan."' and ket2='".$tahun."' ");
		}
		
		if ($flag==0)
		{
			mysql_query("insert into tb_setup values('','".$nama."','".$bulan."','".$tahun."',2) ");
			$no_id="".$prefix."/".$tahun."/".$bulan."/0001";
		}
		return $no_id;
	}
	
	function combofield($comboname,$table,$combo_id,$combo_display)
	{
		$sql="select ".$combo_id.",".$combo_display." from ".$table."";
		$data=mysql_query($sql);
		echo "<select name=".$comboname." class='cmb300'>";
		while($row = mysql_fetch_array($data))
		{
			echo "<option value=".$row["".$combo_id.""].">".$row["".$combo_display.""]."</option>";
		}
		echo "</select>";
	}
	
	
	function begin()
	{
	mysql_query("BEGIN");
	}

	function commit()
	{
	mysql_query("COMMIT");
	}

	function rollback()
	{
	mysql_query("ROLLBACK");
	}
	
?>