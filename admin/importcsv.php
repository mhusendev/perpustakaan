<?php
include"lib/koneksi.php";

 if ($_FILES['csv']['size'] > 0) {

    //get the csv file
    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");

    //loop through the csv file and insert into database
    do {
        if ($data[0]) {
            mysql_query("INSERT INTO master_buku (judul,pengarang, kategori) VALUES
                (
                    '".addslashes($data[0])."',
                    '".addslashes($data[1])."',
                    '".addslashes($data[2])."'
                )
            ");
        }
    } while ($data = fgetcsv($handle,3000,",","'"));
    //

    //redirect
  echo "<script type='text/javascript'>alert('Import Success');window.location.href = 'slider.php';</script>"; die;

}

?>
