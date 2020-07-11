<?php
  session_start();
  include "lib/koneksi.php";
  include "lib/format.php";
  
    if(!isset($_SESSION['id_user']) && !isset($_SESSION['grup']))
    {
        header('Location:login.php'); 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "part/head.php"; ?>
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
      .pb-100 {
          padding-bottom:1rem;
      }
      .chosen-container {
          width:100%;
      }
  </style>
</head>

<body id="page-top" onload="tampil()">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include "part/sidebar.php"; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include "part/topbar.php"; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
<?php  $queri2 =mysql_query("SELECT b.judul,m.pengarang,p.kdpinjam,p.tglpinjam,p.tglpengembalian,p.id_user From peminjaman p JOIN stok_buku b ON p.kdbuku=b.isbn JOIN master_buku m ON b.judul=m.judul WHERE p.kduser ='".mysql_real_escape_string($_GET['kdm'])."'");
                    $jumlah= mysql_num_rows($queri2);

                    ?>
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Peminjaman</h1>
             

          <!-- DataTales Example -->
          <div class="row" style="padding: 10px;">
           <div class="col-md-12 col-xs-12 col-lg-12">
             <?php 
                    $query=mysql_query("SELECT * From member where kduser ='".mysql_real_escape_string($_GET['kdm'])."'");
                    $data = mysql_fetch_array($query);

                   
                      $settenggat =mysql_query("select * from setting");
              $restenggat = mysql_fetch_array($settenggat);
            $batasan = $restenggat['maxpinjam'];

                       $visible="";
                       $txt=""; ;
                  if  ($jumlah >=$batasan) {
                       $visible ="hidden";
                    $txt ="<center><h3>Batas Peminjaman Sudah Maksimal</h3></center>";
                    
                      # code...
                    }  else{

                    
                    }
             ?>
              <?php echo $txt; ?>
              
              <form name="form1"   <?php echo $visible; ?> >
            <div class="row">
              <div class="col-md-6">
                
                 <div class="form-group">
              <input type="text" class="form-control kdm" id="kdm" name="kdm" placeholder="Input Kode Member" value="<?php echo $data['kduser']; ?>" readonly>
            </div>
              <div class="form-group">
                            <label>Judul Buku</label>
                          <select class="chosen-select kdb" name="kdb"  id="kdb" style="width: 100%">
                               <option>Pilih Judul Buku</option>
                                <?php
                                $sql=mysql_query("SELECT * FROM stok_buku ORDER BY judul ASC");
                                while ($row=mysql_fetch_array($sql)) {
                                  if($row['stok']<1){}else{
                                  echo '
                                <option value="'.$row['isbn'].'"><p style="hidden;">'.$row['isbn'].'</p>--'.$row['judul'].'['.$row['kategori'].']</option>
                                  ';
                                }
                                }
                                ?>
                              </select>
                        </div>
           
          

              </div>
              
              <div class="col-md-6">
                 <div class="form-group">
              <input type="text" class="form-control nm" id="nm" name="nm" placeholder="Nama Member" value="<?php echo $data['nama']; ?>" readonly>
            </div>
            
           
            

              </div>


            </div>

          <div class="modal-footer">

            <input type="button"  value="Add" onclick="simpan()"  >
          </div>
        </form>
           </div>
           

         </div>
          <div class="card shadow mb-4" <?php echo $visible; ?>>
         
           <!--  <div class="card-header py-3">
              <a href="#" data-toggle="modal" class="add"data-target="#newBrandModal2"><i class="fas fa-book imp"></i> Import From CSV</a>
            </div> -->
            <div class="card-body"onload="tampil()">
              <div class="table-responsive"  id="data">
             
              </div>
            </div>

            <a  id="dsimpan" href="modul/comitpinjam.php?kduser=<?php echo $_GET['kdm'] ?>" style="margin-left: 3%;" ><i class="fas fa-save"></i>Simpan</a>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include "part/footer.php"; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <?php include "part/scrolltop.php"; ?>

  <!-- Logout Modal-->
  <?php include "part/modal.php"; ?>
  <!-- NEW BRAND MODAL -->
  <div class="modal fade" id="newBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Input Member</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/member_module.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" class="form-control id" name="id">
            <div class="form-group">
              <input type="text" class="form-control nama" id="nama" name="nama" placeholder="Nama Member">
            </div>
             <div class="form-group">
              <input type="date" class="form-control ttl" id="ttl" name="ttl" placeholder="Tanggal lahir">
            </div>
           
            <div class="form-group text-input">
              <input type="text" class="form-control alamat" id="alamat" name="alamat" placeholder="Alamat">
            </div>
            <div class="form-group text-input">
              <input type="text" class="form-control jabatan" id="jabatan" name="jabatan" placeholder="Profesi">
            </div>
          
           <div class="form-group text-input">
              <input type="text" class="form-control nohp" id="nohp" name="nohp" placeholder="Nomor HP">
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="DeleteBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Slider</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/slider_module.php" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Delete this slider?
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-danger" name="delete" value="Delete">
          </div>
        </form>
      </div>
    </div>
  </div>


 <div class="modal fade" id="newBrandModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

     <form class="form-horizontal" action="importcsv.php" id="frmCSVImport"method="post" name="uploadCSV"
    enctype="multipart/form-data">
    <div class="input-row" style="padding: 20px;">
        <label class="col-md-4 control-label">Choose CSV File</label> <input
            type="file" name="csv" id="csv" accept=".csv" lass="form-control">
        <button type="submit" id="submit" name="import"
            class="btn btn-primary btn-submit">Import</button>
        <br>

    </div>
    <div id="labelError"></div>
</form>
      </div>
    </div>
  </div>
    <!-- Bootstrap core JavaScript-->
 <link rel="stylesheet" href="chosen/docsupport/prism.css">
  <link rel="stylesheet" href="chosen/chosen.css">
  <!-- Bootstrap core JavaScript-->
  <?php include "part/js.php"; ?>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
 <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
</body>

</html>

<!-- sc choosen config -->
<script type="text/javascript">
  var config = {
   
    '.chosen-select'     : {width:"100%"}
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }

 
</script>

<!-- sc crud realtime ajax -->
<script type="text/javascript">
  
  var xxmlhttp = createxxmlhttpRequestObject();

function createxxmlhttpRequestObject()
{
  var xxmlhttp;
  if (window.ActiveXObject)
  {
    try
    {
      xxmlhttp=new ActiveXObject("Microsoft.xxmlhttp");
    }
    catch (e)
    {
      xxmlhttp= false;
    }
  }
  else
  {
    try
    {
      xxmlhttp=new XMLHttpRequest();
    }
    catch(e)
    {
      xxmlhttp=false;
    }
  }

if (!xxmlhttp) alert ("Object xxmlhttpRequest gagal dibuat !");
else
return xxmlhttp;
}

function tampil()
{
  if (xxmlhttp.readyState ==4 || xxmlhttp.readyState ==0 )
  {   
     kdm   =encodeURIComponent(document.getElementById("kdm").value);
    xxmlhttp.open ("GET","ajax/peminjaman.php?op=tampildata&kdm="+kdm,true);
    xxmlhttp.onreadystatechange = handleServerResponse;
    xxmlhttp.send(null);
  }
  else
  setTimeout('tampil()',1000);
}

function simpan()
{
  
  if (xxmlhttp.readyState==4 || xxmlhttp.readyState==0)
  {
    kdm   =encodeURIComponent(document.getElementById("kdm").value);
    buku  =encodeURIComponent(document.getElementById("kdb").value);
  
    /* kesalahan semula: kurang tanda sama dengan setelah op=simpandata&&nim */ 
    xxmlhttp.open("GET","ajax/peminjaman.php?op=simpandata&kdm="+kdm+"&kdb="+buku,true);
    xxmlhttp.onreadystatechange = handleServerResponse;
    xxmlhttp.send(null);
  }
  else
  setTimeout('simpan()',1000);
}

function hapus(id,kdm,kdb)
{
  if (xxmlhttp.readyState==4 || xxmlhttp.readyState==0)
  {
    xxmlhttp.open("GET","ajax/peminjaman.php?op=hapusdata&id="+id+"&kdm="+kdm+"&kdb="+kdb,true);
    xxmlhttp.onreadystatechange = handleServerResponse;
    xxmlhttp.send(null);
  }
  else
  setTimeout('hapus()',1000);
}
  
function handleServerResponse()
{
  if (xxmlhttp.readyState==4)
  {
    if (xxmlhttp.status == 200)
    {

      var xmlResponse = xxmlhttp.responseXML;
      xmlRoot =xmlResponse.documentElement;
      idArray = xmlRoot.getElementsByTagName("idpj");
      juduArray =xmlRoot.getElementsByTagName("judul");
      penerbitArray = xmlRoot.getElementsByTagName("penerbit");
      namaArray=xmlRoot.getElementsByTagName("namausr")
      kdmArray = xmlRoot.getElementsByTagName("kodeusr");
      kdbArray = xmlRoot.getElementsByTagName("kodebuk");
      html = "<table class=\"table table-bordered\" id=\"dataTable\" width=\"100% \" cellspacing=\"0\"><thead><tr><th>Nama user</th><th>Kode Buku</th><th>Judul</th><th>Penerbit</th><th>Options</th></tr></thead>";
      
      for (var i=0; i<kdmArray.length; i++)
      {
        html += "<tbody><tr><td>" + namaArray.item(i).firstChild.data + "</td><td>" + kdbArray.item(i).firstChild.data + "</td><td>"+juduArray.item(i).firstChild.data+"</td><td>"+penerbitArray.item(i).firstChild.data+"</td><td><a href=\"ajax/peminjaman.php\" onclick=\"hapus('"+idArray.item(i).firstChild.data+"','"+kdmArray.item(i).firstChild.data+"','"+kdbArray.item(i).firstChild.data+"'); return false;\"> <i class=\"fas fa-trash\"></i>Hapus</a></td></tr></tbody>";
      }
      html = html + "</table>";
      document.getElementById("data").innerHTML = html;



                  






    }
    else
    {
      alert("Ada kesalahan dalam mengakses server : " + xxmlhttp.statusText);
    }
  }
}
  

</script>
<script type="text/javascript">
  

</script>