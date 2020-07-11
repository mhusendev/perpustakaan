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
      $sql=mysql_query("select id_user from tb_user where id_user='".$_POST['id_user']."' ");
      $num=mysql_num_rows($sql);
      if ($num==0) {
        $query=mysql_query("INSERT INTO tb_user(id_user, pass_user, nm_user, grup) VALUES ('".$_POST['id_user']."','".md5($_POST['pass'])."','".$_POST['nm_user']."','".$_POST['grup']."')");
        if (!$query) {
          $valid=0;
          $msg="ERROR : Insert Data Failed";
        }
      } else {
        if ($_POST['status']=='edit') {
          if ($_POST['pass']=="") {
            $query=mysql_query("UPDATE tb_user SET nm_user='".$_POST['nm_user']."',grup='".$_POST['grup']."' WHERE id_user='".$_POST['id_user']."'");
            if (!$query) {
              $valid=0;
              $msg="ERROR : Update Data Failed";
            }
          } else {
            $query=mysql_query("UPDATE tb_user SET pass_user='".md5($_POST['pass'])."',nm_user='".$_POST['nm_user']."',grup='".$_POST['grup']."' WHERE id_user='".$_POST['id_user']."'");
            if (!$query) {
              $valid=0;
              $msg="ERROR : Update Data Failed";
            }
          }
        } else {
          $valid=0;
          $msg="ID User sudah ada, gunakanlah id berbeda";
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
      $query=mysql_query("DELETE FROM tb_user WHERE id_user='".$_POST['id_hapus']."'");
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
          <h1 class="h3 mb-2 text-gray-800">User Management</h1>

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
                      <th>ID</th>
                      <th>Name</th>
                      <th>Group</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $n=1;
                    $sql=mysql_query("select * from tb_user order by nm_user asc");
                    while ($row = mysql_fetch_array($sql)) {
                      echo'
                    <tr>
                      <td>'.$n.'</td>
                      <td>'.$row['id_user'].'</td>
                      <td>'.$row['nm_user'].'</td>
                      <td>'.$row['grup'].'</td>
                      <td>
                        <a href="#" class="btn btn-small text-info edit_button" data-toggle="modal" data-target="#newBrandModal"
                          data-status="edit" 
                          data-id_user="'.$row['id_user'].'" 
                          data-nm_user="'.$row['nm_user'].'" 
                          data-grup="'.$row['grup'].'">
                        <i class="fas fa-edit"></i> Edit</a>
                        <a href="#" class="btn btn-small text-danger hapus_button" data-toggle="modal" data-target="#DeleteBrandModal"
                          data-id_hapus="'.$row['id_user'].'">
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
          <h5 class="modal-title" id="exampleModalLabel">Brand</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="modal-body">
            <input type="text" class="form-control status" name="status" id="status" value="baru">
            <div class="form-group">
              <label>User ID (for login system)</label>
              <input type="text" class="form-control id_user" name="id_user" id="id_user" placeholder="User ID" required>
              <span id="pesan"></span>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control pass" name="pass">
            </div>
            <div class="form-group">
              <label>Level Access</label>
              <select class="form-control grup" name="grup">
                <option value="admin">Administrator</option>
                <option value="super">Management / CEO</option>
              </select>
            </div>
            <hr>
            <div class="form-group">
              <label>User Name</label>
              <input type="text" class="form-control nm_user" name="nm_user" placeholder="User Name" required>
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
          <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="modal-body">
            <input type="hidden" class="form-control id_hapus" name="id_hapus">
            Delete this User?
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
    var status = $(this).data('status');
    var id_user = $(this).data('id_user');
    var nm_user = $(this).data('nm_user');
    var grup = $(this).data('grup');
    
    $(".status").val(status);
    $(".id_user").val(id_user);
    $(".nm_user").val(nm_user);
    $(".grup").val(grup);
  });

  $(document).on( "click", '.hapus_button',function(e) {
    var id_hapus = $(this).data('id_hapus');
    $(".id_hapus").val(id_hapus);
  });
</script>
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