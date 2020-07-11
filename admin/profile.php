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
      if ($_POST['pass']=="") {
        $query=mysql_query("UPDATE tb_user SET id_user='".$_POST['id_user']."', nm_user='".$_POST['nm_user']."' WHERE id_user='".$_SESSION['id_user']."'");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Update Data Failed";
        } else {
          $_SESSION['id_user']=$_POST['id_user'];
          $_SESSION['nm_user']=$_POST['nm_user'];
        }
      } else {
        $query=mysql_query("UPDATE tb_user SET id_user='".$_POST['id_user']."', pass_user='".md5($_POST['pass'])."',nm_user='".$_POST['nm_user']."' WHERE id_user='".$_SESSION['id_user']."'");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Update Data Failed";
        } else {
          $_SESSION['id_user']=$_POST['id_user'];
          $_SESSION['nm_user']=$_POST['nm_user'];
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
          <h1 class="h3 mb-2 text-gray-800">My Profile</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $_SESSION['nm_user']; ?></h6>
            </div>
            <div class="card-body">
              <div class="col-lg-6 col-md-6 col-xs-12">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                  <div class="form-group">
                    <label>User ID (for login system)</label>
                    <input type="text" class="form-control id_user" name="id_user" id="id_user" value="<?php echo $_SESSION['id_user']; ?>" required>
                    <span id="pesan"></span>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control pass" name="pass">
                  </div>
                  <hr>
                  <div class="form-group">
                    <label>User Name</label>
                    <input type="text" class="form-control nm_user" name="nm_user" value="<?php echo $_SESSION['nm_user']; ?>" required>
                  </div>
                  <input type="submit" class="btn btn-primary" name="save" value="Save">
                </form>
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
<script type="text/javascript">
  $(document).ready(function(){
  $('#id_user').blur(function(){
    $('#pesan').html('<img style="margin-left:10px; width:20px" src="loading.gif">');
    var username = $(this).val();

    $.ajax({
      type  : 'POST',
      url   : 'ajax/ajax_users.php',
      data  : 'username='+username,
      success : function(data){
        $('#pesan').html(data);
      }
    })

  });
});
</script>