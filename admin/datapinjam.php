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

<body id="page-top">

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

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Peminjam</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a href="#" data-toggle="modal" class="add"data-target="#newBrandModal"><i class="fas fa-list"></i> Export to Excel</a>
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
                      <th>Kode Member</th>
                      <th>Nama</th>
                      
                      <th>Total pinjam</th>
                      
                     
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
     <?php
                    $n=1;
                    $sql=mysql_query("SELECT m.*, t.transaksi, t.kduser from member m RIGHT join (SELECT kduser, COUNT(kduser) as transaksi FROM peminjaman GROUP by kduser) t ON m.kduser=t.kduser" );
                    while ($row = mysql_fetch_array($sql)) {
                      echo '<tr>
                                <td>'.$n.'</td>
                                <td>'.$row['kduser'].'</td>
                                  <td>'.$row['nama'].'</td>
                                 <td>Meminjam '.$row['transaksi'].' Buku</td>
                             
                      
                                  <td style="width:180px;"><a href="viewpinjam.php?kduser='.$row['kduser'].'"> <i class="fas fa-eye"></i> Lihat</a>  </td>
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
  <?php include "part/js.php"; ?>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
<script type="text/javascript">
  $(function() {
    $('.jenis').change(function(){
      if($('.jenis').val() == 'slider') {
        $('.sedang').prop('placeholder','Text sedang (posisi di paling atas)');
        $('.form-group').show(250);
      } if($('.jenis').val() == 'banner') {
        $('.text-input').hide(250);
      } if($('.jenis').val() == 'youtube') {
        $('.sedang').prop('placeholder','Judul Video');
        $('.pertama').show(250);
        $('.kedua').hide(250);
      }
    });
  });

  $(document).on( "click", '.edit_button',function(e) {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    var ttl = $(this).data('ttl');
       var alamat = $(this).data('alamat');
       var jabatan = $(this).data('jabatan');
var nohp = $(this).data('nohp');


    
    $(".id").val(id);
    $(".nama").val(nama);
    $(".ttl").val(ttl);
       $(".alamat").val(alamat);
              $(".jabatan").val(jabatan);
                     $(".nohp").val(nohp);
  
  });

  $(document).on( "click", '.add',function(e) {
    var id = $(this).data(' ');
    var judul = $(this).data(' ');
    var kategori = $(this).data(' ');
 var pengarang = $(this).data(' ');
    
   
    $(".id").val('');
    $(".nama").val('');
    $(".ttl").val(ttl);
       $(".alamat").val('');
              $(".jabatan").val('');
                     $(".nohp").val('');
  });

  $(document).on( "click", '.hapus_button',function(e) {
    var id_hapus = $(this).data('id_hapus');
    $(".id_hapus").val(id_hapus);
  });
  
  var element = document.getElementById("mstr");
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