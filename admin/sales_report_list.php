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
    table thead tr th {
      text-align:center;
    }
    hr {
      margin: 2px 0;
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
          <h1 class="h3 mb-2 text-gray-800">Sales Report <?php
          $tgl1='';
          $tgl2='';
          if (isset($_POST['tgl1'])) {
            echo "from ".date('d/m/Y',strtotime($_POST['tgl1']))." to ".date('d/m/Y',strtotime($_POST['tgl2']));

            $tgl1=$_POST['tgl1'];
            $tgl2=$_POST['tgl2'];
          }
          ?>
            
          </h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="form-group form-inline" style="margin-bottom:0px">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="date" class="form-control tgl1" name="tgl1" value="<?php echo $tgl1; ?>" required>
                  <span style="margin:0px 10px">TO</span>
                  <input type="date" class="form-control tgl2" name="tgl2" value="<?php echo $tgl2; ?>" required>
                  <input type="submit" class="btn btn-success" name="search" id="search" value="Search">
                </form>
                <?php if (isset($_POST['tgl1'])) { ?>
                <a href="print/sales_report_print.php?tgl1=<?php echo $tgl1; ?>&tgl2=<?php echo $tgl2; ?>" class="btn btn-info" style="margin-left:5px;"><i class="fas fa-download fa-sm text-white-50"></i> Download Laporan</a>
                <?php } ?>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Invoice</th>
                      <th>Member</th>
                      <th>Produk</th>
                      <th>Harga</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $n=1;
                    if (isset($_POST['tgl1'])) {
                      $sql=mysql_query("SELECT o.tgl_order,o.id_order,m.nm_member,o.ongkir,o.amount FROM order_main o JOIN member m ON o.id_cust=m.id_member WHERE o.tgl_order >= '".mysql_real_escape_string($_POST['tgl1'])."' AND o.tgl_order <= '".mysql_real_escape_string($_POST['tgl2'])."' ORDER BY o.tgl_order DESC");
                      while ($row = mysql_fetch_array($sql)) {
                        $sub=$row['amount']-$row['ongkir'];
                        echo'
                      <tr>
                        <td align="center">'.$n.'</td>
                        <td>'.date('d/m/Y',strtotime($row['tgl_order'])).'</td>
                        <td>'.$row['id_order'].'</td>
                        <td>'.$row['nm_member'].'</td>
                        ';
                        $query=mysql_query("SELECT GROUP_CONCAT(d.qty SEPARATOR '<br>') qty, GROUP_CONCAT(p.nm_product SEPARATOR '<br>') product, GROUP_CONCAT(d.harga_final SEPARATOR '<br>') harga FROM order_detail d JOIN product p ON d.id_product=p.id_product WHERE d.id_order='".$row['id_order']."'");
                        while ($row1=mysql_fetch_array($query)) {
                          echo '
                        <td>'.$row1['qty'].' x '.$row1['product'].'</td>
                        <td align="right">'.money_idr($row1['harga']).'</td>
                        <td>
                          SUBTOTAL : '.money_idr($sub).'<br>
                          ONGKIR &nbsp;&nbsp;&nbsp;&nbsp; : '.money_idr($row['ongkir']).'<hr>
                          <b>TOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : '.money_idr($row['amount']).'</b>
                        </td>
                          ';
                        }
                        echo '
                      </tr>
                        ';
                        $n++;
                      }
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

  <!-- Bootstrap core JavaScript-->
  <?php include "part/js.php"; ?>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>