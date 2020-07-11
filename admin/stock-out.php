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
      $sql=mysql_query("SELECT id_product,qty FROM order_detail WHERE id_order='".$_POST['id_hapus']."'");
      while ($row=mysql_fetch_array($sql)) {
        $queries=mysql_query("UPDATE product SET qty = qty + ".$row['qty']." WHERE id_product = '".$row['id_product']."' ");
        if(!$queries) {
          $valid=0;
          $process_status="ERROR : Update Stock Failed";
        }
      }
      if ($valid==1) {
        $query=mysql_query("DELETE FROM order_detail WHERE id_order='".$_POST['id_hapus']."'");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Delete SO2 Failed";
        }
      }
      if ($valid==1) {
        $query=mysql_query("DELETE FROM order_main WHERE id_order='".$_POST['id_hapus']."'");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Delete order_main Failed";
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
          <h1 class="h3 mb-2 text-gray-800">List Stock Out</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                  <select class="form-control jenis" id="jenis">
                    <option value="pending" <?php if (isset($_GET['kat'])) { if ($_GET['kat']=='pending') { echo "selected"; } } ?> >Waiting Payment</option>
                    <option value="confirm" <?php if (isset($_GET['kat'])) { if ($_GET['kat']=='confirm') { echo "selected"; } } ?> >Confirm Payment</option>
                    <option value="sended" <?php if (isset($_GET['kat'])) { if ($_GET['kat']=='sended') { echo "selected"; } } ?> >Sended</option>
                  </select>
                </div>
              </div>
              
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>INVOICE</th>
                      <th>Tanggal</th>
                      <th>Member</th>
                      <th>Produk Terjual</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="tbody">
                    <?php
                    if (isset($_GET['kat'])) {
                      if ($_GET['kat']=='pending') {
                        $filter="WHERE status ='n'";
                      } elseif ($_GET['kat']=='confirm') {
                        $filter="WHERE status ='c'";
                      } elseif ($_GET['kat']=='sended') {
                        $filter="WHERE status ='s' AND resi <> ''";
                      } else {
                        $filter="";
                      }
                    } else {
                      $filter="";
                    }
                    $sql=mysql_query("SELECT o.id_order, o.tgl_order, m.nm_member, o.status FROM order_main o JOIN member m ON o.id_cust=m.id_member ".$filter);
                    while ($row = mysql_fetch_array($sql)) {
                      $status="";
                      if ($row['status']=='n') {
                        $status="Menunggu Pembayaran";
                      } elseif ($row['status']=='c') {
                        $status="Pesanan Sedang Diproses";
                      } elseif ($row['status']=='s') {
                        $status="Pesanan Telah Dikirim";
                      }
                      echo'
                    <tr>
                      <td>'.$row['id_order'].'</td>
                      <td>'.date('d-m-Y H:i:s',strtotime($row['tgl_order'])).'</td>
                      <td>'.$row['nm_member'].'</td>
                      <td>
                      ';
                      $query=mysql_query("SELECT d.qty,p.nm_product FROM order_detail d JOIN product p ON d.id_product=p.id_product WHERE d.id_order='".$row['id_order']."'");
                      while ($cell=mysql_fetch_array($query)) {
                        echo $cell['qty'].' x '.$cell['nm_product'].'<br>';
                      }
                      echo'
                      </td>
                      <td>'.$status.'</td>
                      <td>
                        <a href="order.php?order='.$row['id_order'].'" class="btn btn-small text-info">
                        <i class="fas fa-table"></i> View</a>
                      ';
                      if (isset($_GET['kat'])) {
                        if ($_GET['kat']=='pending') {
                          echo '
                        <a href="#" class="btn btn-small text-success approve" data-toggle="modal" data-target="#approve" data-approve="'.$row['id_order'].'"><i class="fas fa-check"></i> Approve</a>
                          ';
                        } elseif ($_GET['kat']=='confirm') {
                          echo '
                        <a href="#" class="btn btn-small text-warning resi" data-toggle="modal" data-target="#resi" data-sendresi="'.$row['id_order'].'"><i class="fas fa-reply"></i> Kirim Resi</a>
                        <a href="#" class="btn btn-small text-success kirim" data-toggle="modal" data-target="#kirim" data-send="'.$row['id_order'].'"><i class="fas fa-shipping-fast"></i> Kirim Pesanan</a>
                          ';
                        } elseif ($_GET['kat']=='sended') {
                          echo '
                        <a href="#" class="btn btn-small text-success resnd" data-toggle="modal" data-target="#resi" data-resend="'.$row['id_order'].'"><i class="fas fa-reply-all"></i> Kirim Ulang Resi</a>
                          ';
                        }
                      }
                      /*
                      echo'
                        <a href="modul/up_stok_so.php?mode=ubah&id_so='.$row['id_order'].'" class="btn btn-small text-success"><i class="fas fa-check"></i> Approve</a>
                      ';
                      */
                      if(isset($_SESSION['grup'])) {
                        if ($_SESSION['grup']=='super') {
                          echo '
                        <a href="#" class="btn btn-small text-danger hapus_button" data-toggle="modal" data-target="#DeleteBrandModal"
                          data-id_hapus="'.$row['id_order'].'">
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

  <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/order.php" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control appr" name="appr">
            Jika email konfirmasi pembayaran sudah masuk maka anda bisa konfirmasi pembayaran 
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-info" name="konfirmasi" value="Konfirmasi">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="resi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Kirim Resi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/order.php" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control sendresi" name="sendresi">
            <div class="form-group">
              <label>Nomor Resi</label>
              <input type="text" class="form-control noresi" name="noresi">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-info" name="resionly" value="Kirim Resi">
            <input type="submit" class="btn btn-success" name="paket" value="Kirim Resi & Pesanan">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="kirim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Kirim Pesanan</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/order.php" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control send" name="send">
            Kirim Pesanan Ini?<br>
            Status Pesanan akan berubah menjadi <b>Terkirim/Sended</b> apabila sudah kirim resi & konfirmasi kirim Pesanan
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-success" name="pesanan" value="Kirim Pesanan">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="DeleteBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Transaksi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo basename($_SERVER['PHP_SELF']).'?kat='.htmlspecialchars($_GET['kat']); ?>" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Hapus Transaksi ini?<br>Transaksi yang dihapus tidak dapat di pulihkan kembali.
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-danger" name="delete" value="Hapus">
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

  $(function() {
      $('#jenis').change(function(){
        var jenis = $('#jenis').val();

        window.location.href = '?kat='+jenis;
      });
  });

</script>