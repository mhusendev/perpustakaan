<?php
  session_start();
  include "lib/koneksi.php";
  include "lib/appcode.php";
  include "lib/format.php";
  
    if(!isset($_SESSION['id_user']) && !isset($_SESSION['grup']))
    {
        header('Location:login.php'); 
    }

    if (isset($_POST['save'])) {
      $valid=1;
      $id=generate_idsupp();
      if ($_POST['id_supp']=="") {
        $query=mysql_query("INSERT INTO tb_supp(id_supp, nm_supp, hp, email, alamat, dibuat_tgl) VALUES ('".$id."','".$_POST['nm_supp']."','".$_POST['hp']."','".$_POST['email']."','".$_POST['alamat']."','".date('Y-m-d')."')");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Insert Data Failed";
        }
      } else {
        $query=mysql_query("UPDATE tb_supp SET nm_supp='".$_POST['nm_supp']."',hp='".$_POST['hp']."',email='".$_POST['email']."',alamat='".$_POST['alamat']."',diubah_tgl='".date('Y-m-d')."' WHERE id_supp='".$_POST['id_supp']."'");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Update Data Failed";
        }
      }

      if($valid==0) {  
        rollback();
      } else { 
        commit();
        $msg="Save Data Success";
      }
      
      echo "<script type='text/javascript'>alert('".$msg."')</script>";
    }

    if (isset($_POST['delete'])) {
      $valid=1;
      $query=mysql_query("DELETE FROM tb_supp WHERE id_supp='".$_POST['id_hapus']."'");
      if (!$query) {
        $valid=0;
        $msg="ERROR : Delete Data Failed";
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
          <h1 class="h3 mb-2 text-gray-800">Master Supplier</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a href="#" data-toggle="modal" data-target="#newBrandModal"><i class="fas fa-plus"></i> Add New</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <?php
                      if(isset($_SESSION['grup'])) {
                        if ($_SESSION['grup']=='super') {
                          echo '<th>Action</th>';
                        }
                      }
                      ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $n=1;
                    $sql=mysql_query("select * from tb_supp order by nm_supp asc");
                    while ($row = mysql_fetch_array($sql)) {
                      echo'
                    <tr>
                      <td>'.$n.'</td>
                      <td>'.$row['nm_supp'].'</td>
                      <td>'.$row['hp'].'</td>
                      <td>'.$row['alamat'].'</td>
                      ';
                      
                      if(isset($_SESSION['grup'])) {
                        if ($_SESSION['grup']=='super') {
                          echo '
                      <td>
                        <a href="#" class="btn btn-small text-info edit_button" data-toggle="modal" data-target="#newBrandModal"
                          data-id_supp="'.$row['id_supp'].'" 
                          data-nm_supp="'.$row['nm_supp'].'" 
                          data-hp="'.$row['hp'].'" 
                          data-email="'.$row['email'].'" 
                          data-alamat="'.$row['alamat'].'">
                        <i class="fas fa-edit"></i> Edit</a>
                        <a href="#" class="btn btn-small text-danger hapus_button" data-toggle="modal" data-target="#DeleteBrandModal"
                          data-id_hapus="'.$row['id_supp'].'">
                        <i class="fas fa-trash"></i> Hapus</a>
                      </td>
                          ';
                        }
                      }

                      echo '
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
          <h5 class="modal-title" id="exampleModalLabel">Supplier</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_supp" name="id_supp">
            <div class="form-group">
              <label>Supplier Name</label>
              <input type="text" class="form-control nm_supp" name="nm_supp" placeholder="Supplier Name" required>
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" class="form-control hp" name="hp" placeholder="Phone Number/Whatsapp">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea class="form-control alamat" name="alamat" placeholder="Address"></textarea>
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
          <h5 class="modal-title" id="exampleModalLabel">Delete Supplier</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Delete this Supplier?
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
  $(document).on( "click", '.edit_button',function(e) {
    var id_supp = $(this).data('id_supp');
    var nm_supp = $(this).data('nm_supp');
    var hp = $(this).data('hp');
    var email = $(this).data('email');
    var alamat = $(this).data('alamat');
    
    $(".id_supp").val(id_supp);
    $(".nm_supp").val(nm_supp);
    $(".hp").val(hp);
    $(".email").val(email);
    $(".alamat").val(alamat);
  });

  $(document).on( "click", '.hapus_button',function(e) {
    var id_hapus = $(this).data('id_hapus');
    $(".id_hapus").val(id_hapus);
  });
</script>
