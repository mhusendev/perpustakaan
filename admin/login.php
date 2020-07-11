<?php  
  ob_start();
  session_start();
  include "lib/koneksi.php";
  

  
  if(isset($_POST['login']))
  {
    $flag=0;
    $sql="select * from tb_user where id_user='".mysql_real_escape_string($_POST['username'])."' and pass_user='".md5($_POST['pass'])."'  ";
    $data=mysql_query($sql);
    while($row = mysql_fetch_array($data))
    {
      $flag=1;
      $_SESSION['id_user']=$row['id_user'];
      $_SESSION['nm_user']=$row['nm_user'];
      $_SESSION['grup']=$row['grup'];
      $_SESSION['pass_user']=$_POST['pass'];
      $_SESSION['id_cabang']=$row['id_cabang'];
      
      header('Location:index.php');

    }
    if($flag==0)
    {echo "<script type='text/javascript'>alert('Maaf, Login Gagal')</script>";}
  }

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "part/head.php"; ?>
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="pass" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-user btn-block" name="login" value="Login">
                    </div>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="col-lg-3"></div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <?php include "part/js.php"; ?>

</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#exampleInputEmail').focus();
  });
</script>