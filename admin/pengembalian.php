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
   
</head>

<body id="page-top" onload="process()">

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
<?php 
$sql=mysql_query("SELECT * From member where kduser='".mysql_real_escape_string($_GET['kdm'])."'");
$data = mysql_fetch_array($sql);


?>
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-600">Data Peminjaman<?php echo "  ".$data['nama'] ?></h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              
            </div>
           <!--  <div class="card-header py-3">
              <a href="#" data-toggle="modal" class="add"data-target="#newBrandModal2"><i class="fas fa-book imp"></i> Import From CSV</a>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                       <th>No</th>
                      <th>Kode buku</th>
                      <th>Judul</th>
                      <th>Pengarang</th>
                        <th>waktu pinjam</th>
                         <th>Batas Waktu</th>
                         <th>Aksi</th>
                   
                    </tr>
                  </thead>
                  <tbody>
     <?php
                    $n=1;
                    $sql=mysql_query("SELECT b.judul,m.pengarang,p.kdpinjam,p.tglpinjam,p.tglpengembalian,p.id_user ,p.kdbuku,p.kduser,b.penerbit  From peminjaman p JOIN stok_buku b ON p.kdbuku=b.isbn JOIN master_buku m ON b.judul=m.judul WHERE p.kduser ='".mysql_real_escape_string($_GET['kdm'])."'" );
                    while ($row = mysql_fetch_array($sql)) {
                      echo '<tr>
                        <td>'.$n.'</td>
                                <td>'.$row['kdbuku'].'</td>
                                <td>'.$row['judul'].'</td>
                                  <td>'.$row['pengarang'].'</td>
                                 <td>'.$row['tglpinjam'].'</td>
                                  <td>'.$row['tglpengembalian'].'</td>
                                  
                                   <td> <a href="#" class="btn btn-small text-info edit_button" data-toggle="modal" data-target="#newBrandModal"
                          data-kdpinjam="'.$row['kdpinjam'].'"
                          data-judul="'.$row['judul'].'"
                          data-kdb="'.$row['kdbuku'].'"
                            data-kdm="'.$row['kduser'].'"
                           data-pengarang="'.$row['pengarang'].'"
                          data-tglpinjam="'.$row['tglpinjam'].'"
                           data-tglpengembalian="'.$row['tglpengembalian'].'"
                            data-penerbit="'.$row['penerbit'].'"
                         ">
                        <i class="fas fa-sign-out-alt"></i></a>  </td>
                               
                                ';
                      $n++;
                    }
                    ?> 
                  </tbody>
                </table>
              </div>
            </div>
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
          <h5 class="modal-title" id="exampleModalLabel">Pengembalian</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/member_module.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
          <input type="hidden" class="form-control kdm" name="kdm">
            <input type="hidden" class="form-control kdpinjam" name="kdpinjam">
            <div class="form-group">
            <label>judul</label>
              <input type="hidden" class="form-control kdb" id="kdb" name="kdb" >
              <input type="text" class="form-control judul" id="judul" name="judul" readonly>
            </div>

            <div class="row">
            <div class="col-md-6">
              <div class="form-group">
              <label>pengarang</label>
              <input type="text" class="form-control pengarang" id="pengarang" name="pengarang" readonly>
            </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
              <label>penerbit</label>
              <input type="text" class="form-control penerbit" id="penerbit" name="penerbit" readonly>
            </div>
            </div>
            </div>
             
            
           
            <div class="row"><div class="col-md-6">
                <div class="form-group text-input">
             <label>tgl pinjam</label>
              <input type="text" class="form-control tglpinjam" id="tglpinjam" name="tglpinjam" readonly>
            </div>
            
            </div>

             <div class="col-md-6"><div class="form-group text-input">
             <label>Batas waktu</label>
              <input type="text" class="form-control tglpengembalian" id="tglpengembalian" name="tglpengembalian" readonly>
            </div></div>
            </div>
            <div class="row">
              <div class="col-md-6">
                 <div class="form-group text-input">
             <label>tgl pengembalian</label>
              <input type="text" class="form-control kembali" id="kembali" name="kembali" value="YYYY-mm-dd" placeholder="YYYY-mm-dd">
            </div>
              </div>
              <div class="col-md-4">
                 
             <label>telat</label>
              <input type="text" class="form-control telat" id="telat" name="telat" readonly>
                

            </div>
              <div class="col-md-2">
               <div class="form-group text-input"></div>
              <br>
                hari
              </div>

               
            </div>
           <div class="form-group text-input">
             <label>denda</label>
              <input type="text" class="form-control denda" id="denda" name="denda" readonly>
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
  <?php include "part/js.php"; ?>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
<script type="text/javascript">


  $(document).on( "click", '.edit_button',function(e) {
    var kdpinjam = $(this).data('kdpinjam');
    var judul = $(this).data('judul');
    var pengarang = $(this).data('pengarang');
       var tglpinjam = $(this).data('tglpinjam');
       var tglpengembalian = $(this).data('tglpengembalian');
       var penerbit =$(this).data('penerbit');

    var kdb = $(this).data('kdb');
     var kdm = $(this).data('kdm');


    
    $(".kdpinjam").val(kdpinjam);
    $(".judul").val(judul);
    $(".pengarang").val(pengarang);
       $(".tglpinjam").val(tglpinjam);
              $(".tglpengembalian").val(tglpengembalian);
              $(".kdb").val(kdb);
               $(".kdm").val(kdm);
               $(".penerbit").val(penerbit);
                   
  
  });

 
  var element = document.getElementById("trx");
  element.classList.add("active");
</script>
<script type="text/javascript">
  $(document).ready(
  function() {
    $("#frmCSVImport").on(
    "submit",
    function() {

      $("#response").attr("class", "");
      $("#response").html("");
      var fileType = ".csv";
      var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+("
          + fileType + ")$");
      if (!regex.test($("#file").val().toLowerCase())) {
        $("#response").addClass("error");
        $("#response").addClass("display-block");
        $("#response").html(
            "Invalid File. Upload : <b>" + fileType
                + "</b> Files.");
        return false;
      }
      return true;
    });
  })

  // js ajax

  var xmlHttp = createXmlHttpRequestObject();

// membuat obyek XMLHttpRequest

function createXmlHttpRequestObject()
{
    var xmlHttp;

    // cek untuk browser IE

    if(window.ActiveXObject)
    {
       try
       {
          xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
       }
       catch (e)
       {
          xmlHttp = false;
       }
    }
// cek untuk browser Firefox atau yang lain
else
{
    try
    {
       xmlHttp = new XMLHttpRequest();
    }
    catch (e)
    {
         xmlHttp = false;
    }
}

// muncul pesan apabila obyek XMLHttpRequest gagal dibuat

if (!xmlHttp) alert("Obyek XMLHttpRequest gagal dibuat");
else
return xmlHttp;
}

// melakukan request secara asynchronous dengan XMLHttpRequest ke 
// server

function process()
{
    // akan diproses hanya bila obyek XMLHttpRequest tidak sibuk

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
    {
       // mengambil nama dari text box (form)

       tglkembali = 
         encodeURIComponent(document.getElementById("kembali").value);
        batas=
        encodeURIComponent(document.getElementById("tglpengembalian").value);
       // merequest file cek.php di server secara asynchronous

       xmlHttp.open("GET", "ajax/cekdenda.php?tgkb=" + tglkembali+"&batas="+batas, true);

       // mendefinisikan metode yang dilakukan apabila memperoleh
       // response server

       xmlHttp.onreadystatechange = handleServerResponse;

       // membuat request ke server

       xmlHttp.send(null);

    }
    else
        { 
         // Jika server sibuk, request akan dilakukan lagi setelah
         // satu detik

         setTimeout('process()', 1000);
        }
}

// fungsi untuk metode penanganan response dari server

function handleServerResponse()
{
    // jika proses request telah selesai dan menerima respon

    if (xmlHttp.readyState == 4)
    {
       // jika request ke server sukses
 
       if (xmlHttp.status == 200)
       {
          // mengambil dokumen XML yang diterima dari server

          xmlResponse = xmlHttp.responseXML;

          // memperoleh elemen dokumen (root elemen) dari xml

          xmlDocumentElement = xmlResponse.documentElement;

          // membaca data elemen

          hasil = xmlDocumentElement.firstChild.data;
          
          // akan mengupdate tampilan halaman web pada elemen bernama 
          // respon
 
          if (hasil=="0") {
            document.getElementById("telat").value = "0" ;

          }else{
     
           document.getElementById("telat").value = hasil ;


          <?php 

        $myquery=mysql_query("select*from setting");
$res = mysql_fetch_array($myquery);

          ?>
          dendauang = <?php echo $res['denda']; ?> ;

          total = dendauang * hasil;
 ksong = 
         encodeURIComponent(document.getElementById("telat").value);
          if (ksong ==  "0") {
 document.getElementById("denda").value="0";
          }else{
             document.getElementById("denda").value=total;
          }

         
          

         }
          
        

          // request akan dilakukan lagi setelah
          // satu detik (automatic request)

          setTimeout('process()', 1000);
       }
       else
       {
          // akan muncul pesan apabila terjadi masalah dalam mengakses 
          // server (selain respon 200)

          alert("Terjadi masalah dalam mengakses server " +
          xmlHttp.statusText);
       }
    }
}

  </script>