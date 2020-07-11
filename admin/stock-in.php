<?php
  session_start();
  include "lib/koneksi.php";
  include "lib/appcode.php";
  include "lib/format.php";
  
    if(!isset($_SESSION['id_user']) && !isset($_SESSION['grup']))
    {
        header('Location:login.php'); 
    }

    if (isset($_POST['delete'])) {
      $valid=1;
      $sql=mysql_query("SELECT id_bahan,qty from po2 where id_po1='".$_POST['id_hapus']."'");
      while ($row=mysql_fetch_array($sql)) {
        $queries=mysql_query("UPDATE product set qty = qty - ".$row['qty']." where id_product = '".$row['id_bahan']."' ");
        if(!$queries) {
          $valid=0;
          $process_status="ERROR : Update Stock Failed";
        }
      }
      if ($valid==1) {
        $query=mysql_query("DELETE FROM po2 WHERE id_po1='".$_POST['id_hapus']."'");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Delete PO2 Failed";
        }
      }
      if ($valid==1) {
        $query=mysql_query("DELETE FROM po1 WHERE id_po1='".$_POST['id_hapus']."'");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Delete PO1 Failed";
        }
      }

      if($valid==0) {  
        rollback();
      } else { 
        commit();
        $msg="Delete Data Success";
      }
      
      echo "<script type='text/javascript'>alert('".$msg."')</script>";
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
          <h1 class="h3 mb-2 text-gray-800">List Stock In</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a href="input_po.php?mode=add"><i class="fas fa-plus"></i> Add New</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>NO PO</th>
                      <th>Tanggal</th>
                      <th>Supplier</th>
                      <th>Barang Masuk</th>
                      <th>Dibuat Oleh</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql=mysql_query("select p.*,s.nm_supp,u.nm_user from po1 p join tb_supp s on p.id_supplier=s.id_supp join tb_user u on p.dibuat_oleh=u.id_user order by p.tgl_po desc");
                    while ($row = mysql_fetch_array($sql)) {
                      echo '
                    <tr>
                      <td>'.$row['id_po1'].'</td>
                      <td>'.date('d-m-Y',strtotime($row['tgl_po'])).'</td>
                      <td>'.$row['nm_supp'].'</td>
                      <td>
                      ';
                      $query=mysql_query("select o.qty,p.nm_product from po2 o join product p on o.id_bahan=p.id_product where o.id_po1='".$row['id_po1']."'");
                      while ($cell=mysql_fetch_array($query)) {
                        echo $cell['qty'].' x '.$cell['nm_product'].'<br>';
                      }
                      echo '
                      </td>
                      <td>'.$row['nm_user'].'</td>
                      <td>
                        <a href="input_po.php?mode=view&id_po='.$row['id_po1'].'" class="btn btn-small text-info">
                        <i class="fas fa-table"></i> View</a>
                      ';
                        
                      if(isset($_SESSION['grup'])) {
                        if ($_SESSION['grup']=='super') {
                          echo '
                        <a href="modul/up_stok_po.php?mode=ubah&id_po='.$row['id_po1'].'" class="btn btn-small text-warning">
                        <i class="fas fa-edit"></i> Edit</a>
                        <a href="#" class="btn btn-small text-danger hapus_button" data-toggle="modal" data-target="#DeleteBrandModal"
                          data-id_hapus="'.$row['id_po1'].'">
                        <i class="fas fa-trash"></i> Hapus</a>
                        ';
                        }
                      }

                        echo '
                      </td>
                    </tr>
                      ';
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
  <!-- DELETE MODAL -->
  <div class="modal fade" id="DeleteBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Purchase Order</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Delete this Purchase Order?
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
  $(document).on( "click", '.hapus_button',function(e) {
    var id_hapus = $(this).data('id_hapus');
    $(".id_hapus").val(id_hapus);
  });

  var element = document.getElementById("in");
  element.classList.add("active");
</script>
