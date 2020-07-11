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
  <script src="ckeditor5/ckeditor.js"></script>
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
          <h1 class="h3 mb-2 text-gray-800">Master Product</h1>

          <!-- DataTales Example -->
          
          <?php
          if (isset($_GET['act'])) {
            if ($_GET['act']=='add'||$_GET['act']=='edit') {
              $jenis='';
              $id_product='';
              $nm_product='';
              $tag='';
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
                  $jenis=$row['jenis'];
                  $id_product=$row['id_product'];
                  $nm_product=$row['nm_product'];
                  $tag=$row['tag'];
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
              <h6 class="m-0 font-weight-bold text-primary">Product</h6>
            </div>
            <div class="card-body">
              <form action="modul/product_module.php" enctype="multipart/form-data" method="POST">
                <div align="center">
                  <select class="form-control jenis" name="jenis" style="background-color:#e1e3f9;color:black" required>
                    <option value="">Pilih Jenis Barang</option>
                    <option value="mentah" <?php if($jenis=='mentah') {echo "selected";} ?> >Bahan Mentah / Bahan Baku</option>
                    <option value="jadi" <?php if($jenis=='jadi') {echo "selected";} ?> >Produk Jadi</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Image</label>
                  <input type="file" name="gambar[]" class="form-control gambar" accept="image/*" multiple>
                </div>
                <div class="row">
                  <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                      <label>Product Name</label>
                      <input type="text" name="nm_product" class="form-control nm_product" value="<?php echo $nm_product; ?>" required>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2">
                    <div class="form-group">
                      <label>Tag</label>
                      <select class="chosen-select tag" name="tag[]" placeholder="tag" id="tag" multiple style="width: 100%">
                        <?php
                        $sql=mysql_query("SELECT id,kategori FROM category WHERE jenis = 'c' ORDER BY kategori ASC");
                        while ($row=mysql_fetch_array($sql)) {
                          echo '
                        <option value="'.$row['id'].'"';
                          $array = explode('|',$tag);
                          foreach($array as $my_Array) {
                            if($my_Array == $row['id']) {
                              echo " selected";
                            }
                          }
                          echo '
                        >'.$row['kategori'].'</option>
                          ';
                        }
                        ?>
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
                <div class="form-group">
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
                      <th>NO</th>
                      <th>Image</th>
                      <th nowrap>Product Name</th>
                      <th>Harga</th>
                      <th width="40%">Desc</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $n=1;
                    $sql=mysql_query("SELECT * FROM product ORDER BY tgl DESC");
                    while ($row = mysql_fetch_array($sql)) {
                      $gambar="";
                      $x=0;
                      $array = explode('|',$row['gambar']);
                      foreach($array as $my_Array){
                        if($my_Array!="" && $x==0)
                        {
                          $gambar = $my_Array;
                          $gambar = str_replace(" ", '%20', $gambar);
                          $x++;
                        }
                      }
                      echo '
                    <tr>
                      <td>'.$n.'</td>
                      <td align="center"><img src="../'.$gambar.'" style="max-width: 123px"></td>
                      <td>'.$row['nm_product'].'</td>
                      <td>Rp. '.number_format($row['harga1']).'</td>
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
  <link rel="stylesheet" href="chosen/docsupport/prism.css">
  <link rel="stylesheet" href="chosen/chosen.css">
  <?php include "part/js.php"; ?>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
  <script src="chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script>
    ClassicEditor
      .create( document.querySelector( '#editor' ) )
      .catch( error => {
        console.error( error );
      } );

    var allEditors = document.querySelectorAll('.editor');
    for (var i = 0; i < allEditors.length; ++i) {
      ClassicEditor.create(allEditors[i]);
    }
  </script>

</body>

</html>
<script type="text/javascript">
  $(document).on( "click", '.hapus_button',function(e) {
    var id = $(this).data('id');
    $(".id_hapus").val(id);
  });

  var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }
  
  var element = document.getElementById("mstr");
  element.classList.add("active");
</script>