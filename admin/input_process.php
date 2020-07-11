<?php
  session_start();
  include "lib/koneksi.php";
  include "lib/appcode.php";
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

  <style type="text/css">
    .print { display: none; }
    @media print
    {
      .non-print { display: none; }
      .print { display: block; font-family: 'PT Mono', monospace; }
    }
  </style>
  <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
</head>

<body id="page-top">
  <div class="non-print">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "modul/input_proses_mod.php"; ?>
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
          <?php if (isset($_GET['proses'])&&$_GET['mode']=='view') { } else { echo '<h1 class="h3 mb-2 text-gray-800">Input Proses</h1>'; }?>

          <!-- DataTales Example -->
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12"></div>
            <div class="col-lg-5 col-md-5 col-sm-12">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h5>Bahan Baku</h5>
                  <div class="form-group form-inline">
                    <input list="bahan" name="bahan" class="form-control bahan" placeholder="Nama Bahan" autofocus>
                      <datalist id="bahan">
                        <?php
                        $sql=mysql_query("select * from product where jenis = 'mentah' order by nm_product asc");
                        while ($row=mysql_fetch_array($sql)) {
                          echo '
                        <option value="'.$row['nm_product'].'">
                          ';
                        }
                        ?>
                      </datalist>
                    <input type="number" class="form-control qty_bhn" name="qty_bhn" id="qty_bhn" placeholder="QTY" min="1">
                    <input type="submit" class="btn btn-success" name="add_bahan" id="add_bahan" value="Add">
                    <div class="info"></div>
                  </div>
                </div>
              </div>

              <div class="card shadow mb-4">
                <div class="card-body">
                  <div style="overflow-x:auto;">
                    <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Produk</th>
                          <th>QTY</th>
                          <?php if (isset($_GET['proses'])&&$_GET['mode']=='view') { } else { echo '<th>Action</th>'; }?>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($_GET['proses'])) {
                          $query=mysql_query("select r.*,p.nm_product from proses_bhn r join product p on r.id_bahan=p.id_product where r.id_proses='".mysql_real_escape_string($_GET['proses'])."'");
                          while ($row=mysql_fetch_array($query)) {
                            echo '
                          <tr>
                            <td width=300px>'.$row['nm_product'].'</td>
                            <td width=50px align="center">'.floatval($row['qty']).'</td>
                            ';
                            if ($_GET['mode']=='ubah') {
                              echo '
                            <td width=150px>
                              <a href="?mode=hapus&id_pro_bhn='.$row['id_pro_bhn'].'" class="btn btn-small text-danger hapus_button"><i class="fas fa-trash"></i> Hapus</a>
                            </td>
                          ';
                            }
                            echo '
                          </tr>
                            ';
                          }
                        }
                        $query=mysql_query("select t.*,p.nm_product from temp_bahan t join product p on t.id_bahan=p.id_product where t.id_user='".$_SESSION['id_user']."'");
                        while ($row=mysql_fetch_array($query)) {
                          echo '
                        <tr>
                          <td width=300px>'.$row['nm_product'].'</td>
                          <td width=50px align="center">'.floatval($row['qty']).'</td>
                          <td width=150px>
                            <a href="?mode=hapus&id_temp_bhn='.$row['id_temp_bhn'].'" class="btn btn-small text-danger hapus_button"><i class="fas fa-trash"></i> Hapus</a>
                          </td>
                        </tr>
                          ';
                        }
                        ?>
                        <tr id="separator">
                          <td colspan="3" bgcolor="#dddfeb" style="padding:5px"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12">
              <img src="right.png" width="100%" height="100%">
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
              
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h5>Produk Jadi</h5>
                  <div class="form-group form-inline">
                    <input list="jadi" name="jadi" class="form-control jadi" placeholder="Product Name" autofocus>
                      <datalist id="jadi">
                        <?php
                        $sql=mysql_query("select * from product where jenis = 'jadi' order by nm_product asc");
                        while ($row=mysql_fetch_array($sql)) {
                          echo '
                        <option value="'.$row['nm_product'].'">
                          ';
                        }
                        ?>
                      </datalist>
                    <input type="number" class="form-control qty_jadi" name="qty_jadi" id="qty_jadi" placeholder="QTY" min="1">
                    <input type="submit" class="btn btn-success" name="add_jadi" id="add_jadi" value="Add">
                    <div class="infoP"></div>
                  </div>
                </div>
              </div>

              <div class="card shadow mb-4">
                <div class="card-body">
                  <div style="overflow-x:auto;">
                    <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Produk</th>
                          <th>QTY</th>
                          <?php if (isset($_GET['proses'])&&$_GET['mode']=='view') { } else { echo '<th>Action</th>'; }?>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($_GET['proses'])) {
                          $query=mysql_query("select r.*,p.nm_product from proses_jadi r join product p on r.id_jadi=p.id_product where r.id_proses='".mysql_real_escape_string($_GET['proses'])."'");
                          while ($row=mysql_fetch_array($query)) {
                            echo '
                          <tr>
                            <td width=300px>'.$row['nm_product'].'</td>
                            <td width=50px align="center">'.floatval($row['qty']).'</td>
                            ';
                            if ($_GET['mode']=='ubah') {
                              echo '
                            <td width=150px>
                              <a href="?mode=hapus&id_pro_jadi='.$row['id_pro_jadi'].'" class="btn btn-small text-danger hapus_button"><i class="fas fa-trash"></i> Hapus</a>
                            </td>
                          ';
                            }
                            echo '
                          </tr>
                            ';
                          }
                        }
                        $query=mysql_query("select t.*,p.nm_product from temp_jadi t join product p on t.id_jadi=p.id_product where t.id_user='".$_SESSION['id_user']."'");
                        while ($row=mysql_fetch_array($query)) {
                          echo '
                        <tr>
                          <td width=300px>'.$row['nm_product'].'</td>
                          <td width=50px align="center">'.floatval($row['qty']).'</td>
                          <td width=150px>
                            <a href="?mode=hapus&id_temp_jadi='.$row['id_temp_jadi'].'" class="btn btn-small text-danger hapus_button"><i class="fas fa-trash"></i> Hapus</a>
                          </td>
                        </tr>
                          ';
                        }
                        ?>
                        <tr id="separator2">
                          <td colspan="3" bgcolor="#dddfeb" style="padding:5px"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button class="btn btn-info" data-toggle="modal" data-target="#newproductModal">Save</button>
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
</div>
  <!-- Scroll to Top Button-->
  <?php include "part/scrolltop.php"; ?>

  <!-- Logout Modal-->
  <?php include "part/modal.php"; ?>
  <!-- NEW product MODAL -->
  <div class="modal fade" id="newproductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Data Produksi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control" name="proses" value="<?php echo $proses; ?>" required />
            <input type="hidden" class="form-control id_cust" name="id_cust">
            <div class="form-group">
              <label>Tanggal Produksi</label>
              <input type="date" class="form-control tgl" name="tgl" value="<?php echo $tgl_po; ?>">
            </div>
            <div class="form-group">
              <label>Note</label>
              <textarea class="form-control ket" name="ket" placeholder="Note"><?php echo $ket; ?></textarea>
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

  <div class="modal fade" id="DeleteproductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Transaction</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Delete this Transaction?
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
  <?php include "part/js.php"; ?>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('table.display').DataTable();
  });
</script>
<script type="text/javascript">
  $("#add_bahan").click(function() {
    $(".info").html("");

    var bahan = $(".bahan").val();
    var qty_bhn = $("#qty_bhn").val();
    
    if(bahan=="" || qty_bhn=="" || qty_bhn<1) {
      $(".info").html("");
      $(".info").append("<center><font color=red>Pastikan Nama Barang & QTY sudah terisi</font></center>");
    } else { 
      var dataString = 'bahan='+ bahan +'&qty_bhn='+qty_bhn;
      
      $.ajax({
        type: "POST",
        url: "ajax/ajax_input_bahan.php",
        data: dataString,
        cache: true,
        success: function(html){
          $("#separator").before(html);
          $(".bahan").focus();
        }  
      });
    }
  });

  $("#add_jadi").click(function() {
    $(".infoP").html("");

    var jadi = $(".jadi").val();
    var qty_jadi = $("#qty_jadi").val();
    
    if(jadi=="" || qty_jadi=="" || qty_jadi<1) {
      $(".infoP").html("");
      $(".infoP").append("<center><font color=red>Pastikan Nama Barang & QTY sudah terisi</font></center>");
    } else { 
      var dataString = 'jadi='+ jadi +'&qty_jadi='+qty_jadi;
      
      $.ajax({
        type: "POST",
        url: "ajax/ajax_input_jadi.php",
        data: dataString,
        cache: true,
        success: function(html){
          $("#separator2").before(html);
          $(".jadi").focus();
        }  
      });
    }
  });

  $(document).on( "click", '.hapus_button',function(e) {
    var id_hapus = $(this).data('id_hapus');
    $(".id_hapus").val(id_hapus);
  });
</script>