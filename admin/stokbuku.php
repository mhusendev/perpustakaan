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
          <h1 class="h3 mb-2 text-gray-800">Stok Buku</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a href="#" data-toggle="modal" class="add"data-target="#newBrandModal"><i class="fas fa-plus add"></i> Add New</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    
                      <th>Judul</th>
                      <th>Penerbit</th>
                      <th>Tahun</th>
                      <th>Stok</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
     <?php
                    $n=1;
                    $sql=mysql_query("SELECT * FROM stok_buku ORDER BY id DESC");
                    while ($row = mysql_fetch_array($sql)) {
                      echo '<tr>
                             
                                <td>'.$row['judul'].'</td>

                           
                                   <td>'.$row['penerbit'].'</td>
                                     <td>'.$row['tahun_terbit'].'</td>
                                       <td>'.$row['stok'].'</td>
                                          <td><a href=""><i class="fas fa-delete"></i>Delete</a> |  <a href="#" class="btn btn-small text-info edit_button" data-toggle="modal" data-target="#newBrandModal1"
                          data-id="'.$row['id'].'"
                          data-judul="'.$row['judul'].'"
                         
                          data-stok="'.$row['stok'].'">
                        <i class="fas fa-edit"></i> Tambah/kurang Stok</a>  </td> 
                                   
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
  <div class="modal fade pb-100" id="newBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Input Buku Baru</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/stokbuku_modul.php" method="POST" enctype="multipart/form-data">
         
           

          <div class="modal-body">
            <input type="hidden" class="form-control id" name="id">

             <div class="form-group">
                            <label>Judul Buku</label>
                          <select class="chosen-select judul" name="judul"  id="judul" style="width: 100%">
                               <option>Pilih Judul Buku</option>
                                <?php
                                $sql=mysql_query("SELECT * FROM master_buku ORDER BY judul ASC");
                                while ($row=mysql_fetch_array($sql)) {
                                  echo '
                                <option value="'.$row['id'].'">'.$row['judul'].'['.$row['kategori'].']</option>
                                  ';
                                }
                                ?>
                              </select>
                        </div>
                 
            

            <div class="form-group text-input">
              <input type="text" class="form-control penerbit" id="penerbit" name="penerbit" placeholder="penerbit">
            </div>
            
            <div class="form-group text-input">
              <label>Tahun Terbit</label>
              <input type="text" class="form-control datepicker" id="datepicker" name="thn">
            </div>
            <div class="form-group text-input">
             
              <input type="text" class="form-control isbn" id="isbn" name="isbn" placeholder="No ISBN">
            </div>
            <div class="form-group text-input">
              <label>Stok Buku</label>
              <input type="number" class="form-control stok" id="stok" name="stok"  value="0"placeholder="Stok Buku">
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


  <div class="modal fade pb-100" id="newBrandModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Add Stok</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/stokbuku_modul.php" method="POST" enctype="multipart/form-data">
         
           

          <div class="modal-body">
            <input type="hidden" class="form-control id2" name="id2">

          
                 
            
            <div class="form-group text-input">
              <input type="text" class="form-control judul2" id="judul2" name="judul2" readonly="true">
            </div>

          
            
            <div class="form-group text-input">
             <label>Stok Saat ini</label>
              <input type="text" class="form-control stok2" id="stok2" name="stok2" readonly="true">
            </div>
            <div class="form-group text-input">
              <label>Kurang/Tambah stok</label>
              <input type="number" class="form-control stoktmbh" id="stoktmbh" name="stoktmbh">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" name="add" value="add">
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

  <!-- Bootstrap core JavaScript-->
 <link rel="stylesheet" href="chosen/docsupport/prism.css">
  <link rel="stylesheet" href="chosen/chosen.css">
  <?php include "part/js.php"; ?>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="chosen/chosen.jquery.js" type="text/javascript"></script>

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
    var judul = $(this).data('judul');
    var pengarang = $(this).data('pengarang');
   var stok = $(this).data('stok');

    
    $(".id2").val(id);
    $(".judul2").val(judul);
      $(".pengarang2").val(pengarang);
    $(".stok2").val(stok);
  
  
  });

  $(document).on( "click", '.add',function(e) {
    var id = $(this).data(' ');
    var judul = $(this).data(' ');
    var kategori = $(this).data(' ');

    
    $(".id").val('');
    $(".judul").val('');
    $(".kategori").val('')
  
  });

  $(document).on( "click", '.hapus_button',function(e) {
    var id_hapus = $(this).data('id_hapus');
    $(".id_hapus").val(id_hapus);
  });
  
  var element = document.getElementById("mstr");
  element.classList.add("active");
</script>

<script type="text/javascript">
  var config = {
   
    '.chosen-select'     : {width:"100%"}
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }

 
</script>
<script type="text/javascript">
 
  $(function() {
  $('.datepicker').datepicker( {
    format: " yyyy",
    viewMode: "years", 
    minViewMode: "years"
});
    });
</script>