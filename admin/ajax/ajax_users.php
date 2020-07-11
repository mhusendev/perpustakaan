<?php
	ob_start();
	session_start();

	include "../lib/koneksi.php";

	$username = mysql_real_escape_string($_POST['username']);
	
	if ($_SESSION['id_user']==$username) {
		echo "✔ Username masih tersedia";
	} else {
		$sql=mysql_query("select id_user from tb_user where id_user='".$username."' ");
		$num=mysql_num_rows($sql);
		if ($num>0) {
			echo " ❌ Username tidak tersedia";
		} else {
			echo "✔ Username masih tersedia";
		}
	}
	
	ob_flush();
?>