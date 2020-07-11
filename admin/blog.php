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
          <h1 class="h3 mb-2 text-gray-800">Master Artikel</h1>

          <!-- DataTales Example -->
          
          <?php
          if (isset($_GET['act'])) {
            if ($_GET['act']=='add'||$_GET['act']=='edit') {
              $id_blog='';
              $judul='';
              $isi='';
              $path='';
              $jenis='';

              if ($_GET['act']=='edit') {
                $query=mysql_query("SELECT * FROM blog WHERE id_blog='".mysql_real_escape_string($_GET['id'])."'");
                while ($row=mysql_fetch_array($query)) {
                  $id_blog=$row['id_blog'];
                  $judul=$row['judul'];
                  $path=$row['path'];
                  $isi=$row['isi'];
                  $jenis=$row['jenis'];
                }
              }
          ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Artikel</h6>
            </div>
            <div class="card-body">
              <form action="modul/blog_module.php" enctype="multipart/form-data" method="POST">
                <div class="form-group">
                  <label>Jenis</label>
                  <select class="form-control jenis" name="jenis">
                    <option value="blog" <?php if($jenis=='blog') { echo "selected"; } ?> >Blog</option>
                    <option value="testi" <?php if($jenis=='testi') { echo "selected"; } ?> >Testimonials</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Gambar</label>
                  <input type="file" name="path" class="form-control path" accept="image/*">
                </div>
                <div class="form-group">
                  <label>Judul</label>
                  <input type="input" name="judul" class="form-control judul" value="<?php echo $judul; ?>">
                </div>
                <div class="form-group">
                  <label>Isi</label>
                  <textarea id="editor" style="height: 500px" name="isi"><?php echo $isi; ?></textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $id_blog; ?>">
                <input type="submit" name="save" class="btn btn-primary" value="Simpan">
                <a href="blog.php" class="btn btn-danger">Batal</a>
              </form>
            </div>
          </div>
            <?php
              }
            } else { 
            ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><a href="blog.php?act=add">Tambah Baru</a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>NO</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Desc</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $n=1;
                    $sql=mysql_query("SELECT * FROM blog ORDER BY dibuat_tgl DESC");
                    while ($row = mysql_fetch_array($sql)) {
                      $str=str_replace('<p>', '', $row['isi']);
                      $string=str_replace('</p>', '', $str);
                      $string = strip_tags($string);
                      if (strlen($string) > 500) {
                        $stringCut = substr($string, 0, 500);
                        $endPoint = strrpos($stringCut, ' ');

                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                        $string .= '...';
                      }
                      echo '
                    <tr>
                      <td>'.$n.'</td>
                      <td><img src="../'.$row['path'].'" style="max-width: 350px"></td>
                      <td>'.$row['judul'].'</td>
                      <td>'.$string.'</td>
                      <td>
                        <a href="blog.php?act=edit&id='.$row['id_blog'].'" class="btn btn-small text-warning">
                        <i class="fas fa-edit"></i> Ubah</a>
                        <a href="#" class="btn btn-small text-danger hapus_button" data-toggle="modal" data-target="#modalHapus" data-id="'.$row['id_blog'].'">
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
          <h5 class="modal-title" id="exampleModalLabel">Hapus Artikel?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="modul/blog_module.php" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Hapus Artikel ini?
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
  <script>
    ClassicEditor
      .create( document.querySelector( '#editor' ) )
      .catch( error => {
        console.error( error );
      } );
  </script>
  <!-- Page level plugins -->

</body>

</html>
<script type="text/javascript">
  $(document).on( "click", '.hapus_button',function(e) {
    var id = $(this).data('id');
    $(".id_hapus").val(id);
  });
  
  var element = document.getElementById("mstr");
  element.classList.add("active");
</script>