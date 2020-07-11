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
          <h1 class="h3 mb-2 text-gray-800">Waiting Payment</h1>

          <!-- DataTales Example -->
          
          <?php
          if (isset($_GET['act'])) {
            if ($_GET['act']=='add'||$_GET['act']=='edit') {
              $id_product='';
              $nm_product='';
              $id_kat='';
              $berat='';
              $short='';
              $deskripsi='';
              $harga1=0;
              $harga2=0;
              $harga3=0;
              $tgl=date('Y-m-d');
              $gambar='';
              $badge='';

              if ($_GET['act']=='edit') {
                $query=mysql_query("SELECT * FROM product WHERE id_product='".mysql_real_escape_string($_GET['id'])."'");
                while ($row=mysql_fetch_array($query)) {
                  $id_product=$row['id_product'];
                  $nm_product=$row['nm_product'];
                  $id_kat=$row['id_kat'];
                  $berat=$row['berat'];
                  $short=$row['short'];
                  $deskripsi=$row['deskripsi'];
                  $harga1=$row['harga1'];
                  $harga2=$row['harga2'];
                  $harga3=$row['harga3'];
                  $tgl=$row['tgl'];
                  $gambar=$row['gambar'];
                  $badge=$row['badge'];
                }
              }
          ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Order</h6>
            </div>
            <div class="card-body">
              <form action="modul/product_module.php" enctype="multipart/form-data" method="POST">
                <div class="form-group">
                  <label>Image</label>
                  <input type="file" name="gambar[]" class="form-control gambar" accept="image/*" multiple>
                </div>
                <div class="row">
                  <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                      <label>Product Name</label>
                      <input type="text" name="nm_product" class="form-control nm_product" value="<?php echo $nm_product; ?>">
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2">
                    <div class="form-group">
                      <label>Category</label>
                      <select name="id_kat" class="form-control id_kat">
                        <option value="1">testing option1</option>
                        <option value="2">testing option2</option>
                        <option value="3">testing option3</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2">
                    <div class="form-group">
                      <label>Weight</label>
                      <input type="number" name="berat" class="form-control berat" min="0" value="<?php echo $berat; ?>" placeholder="gram">
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2">
                    <div class="form-group">
                      <label>Price</label>
                      <input type="number" name="harga1" class="form-control harga1" value="<?php echo $harga1; ?>">
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2">
                    <div class="form-group">
                      <label>Badge</label>
                      <input type="text" name="badge" class="form-control badge_input" value="<?php echo $badge; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group" hidden>
                  <label>Harga 2</label>
                  <input type="text" name="harga2" class="form-control harga2" value="<?php echo $harga2; ?>">
                </div>
                <div class="form-group" hidden>
                  <label>Harga 3</label>
                  <input type="text" name="harga3" class="form-control harga3" value="<?php echo $harga3; ?>">
                </div>
                
                <div class="form-group">
                  <label>Short Description</label>
                  <textarea id="editor" style="height: 500px" name="short"><?php echo $short; ?></textarea>
                </div>
                <div class="form-group">
                  <label>Product Description</label>
                  <textarea id="editor1" class="editor" style="height: 500px" name="deskripsi"><?php echo $deskripsi; ?></textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $id_product; ?>">
                <input type="submit" name="save" class="btn btn-primary" value="Save">
                <a href="product.php" class="btn btn-danger">Cancel</a>
              </form>
            </div>
          </div>
            <?php
              }
            } else { 
            ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><a href="product.php?act=add">Add New</a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Invoice</th>
                      <th>Order Date</th>
                      <th>Shipping Detail</th>
                      <th>Pricing</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $n=1;
                    $sql=mysql_query("SELECT * FROM product ORDER BY tgl DESC");
                    while ($row = mysql_fetch_array($sql)) {
                      echo '
                    <tr>
                      <td>'.$n.'</td>
                      <td><img src="../'.$row['gambar'].'" style="max-width: 350px"></td>
                      <td>'.$row['nm_product'].'</td>
                      <td>'.$row['harga1'].'</td>
                      <td>'.$row['short'].'</td>
                      <td>
                        <a href="product.php?act=edit&id='.$row['id_product'].'" class="btn btn-small text-warning">
                        <i class="fas fa-edit"></i> Edit</a>
                        <a href="#" class="btn btn-small text-danger hapus_button" data-toggle="modal" data-target="#modalHapus" data-id="'.$row['id_product'].'">
                        <i class="fas fa-trash"></i> Hapus</a>
                      </td>
                    </tr>
                      ';
                      $n++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php } ?>
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

  <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 400px">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete product?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/product_module.php" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Delete this product data?
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

</body>

</html>
<script type="text/javascript">
  $(document).on( "click", '.hapus_button',function(e) {
    var id = $(this).data('id');
    $(".id_hapus").val(id);
  });
</script>