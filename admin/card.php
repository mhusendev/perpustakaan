
<!DOCTYPE html>
<html>
<head>
	<?php include "part/head.php"; ?>
	<style type="text/css">
		@media print {

    @page {size: A4 landscape;max-height:100%; max-width:100%}

    /* use width if in portrait (use the smaller size to try 
       and prevent image from overflowing page... */
    img { height: 90%; margin: 0; padding: 0; }



	</style>
</head>
<body>
  <div class="row" style="margin-top:5%!important;">
  
  	 <div class="col-xl-6 col-md-6 mb-6">
              <div class="card shadow h-100 py-2" style="background: url('img/card.jpg') no-repeat center;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
                <div class="card-body" >
                  <div class="row no-gutters align-items-center" >
                    <div class="col mr-2"> 
                      <div class="text font-weight-bold text-primary text-uppercase mb-1">Kartu Member</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Perpustakaan</div>
                    </div>
                  
                     <p> <img src="barcode/barcode.php?f=svg&s=ean-8&d=<?php echo $_GET['kduser']; ?>&h=50&ts=7"  /> </p>
                  </div>
                  <hr>
                <div class="row" >
                	 <div class="col-xl-4 col-md-4 mb-4">
                	 	<p><strong>Nama</strong></p>
                	 	<p><strong>Tanggal Lahir</strong></p>
                	    <p><strong>No Telp</strong></p>
                	     <p><strong>Jabatan/Profesi</strong></p>
						<p><strong>Alamat</strong></p>
                	 </div>
                	 <div class="col-xl-1 col-md-1 mb-1">
                	 	<p>:</p>
                	 	<p>:</p>
                	    <p>:</p>
                	     <p>:</p>
						<p>:</p>
                	 </div>
                	  <div class="col-xl-7 col-md-7 mb-7" style="padding-left: 0px!important;">
                	 	<p><strong><?php echo $_GET['nama']; ?></strong></p>
                	 	<p><strong><?php echo $_GET['ttl']; ?></strong></p>
                	    <p><strong><?php echo $_GET['nohp']; ?></strong></p>
                	     <p><strong><?php echo $_GET['jabatan']; ?></strong></p>
						<p><strong><?php echo $_GET['alamat']; ?></strong></p>
                	 </div>

                </div>
                    
               <strong> <hr></strong>

                </div>
              </div>
            </div>

             <div class="col-xl-6 col-md-6 mb-6">
              <div class="card  shadow h-100 py-2"  style="background: url('img/card.jpg') no-repeat center;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;" >
                <div class="card-body">
                  <div class="row ">
                   <div class="col-xl-12 col-md-12 mb-12"><center><h4>Peraturan Penggunaan Kartu Member</h4></center></div>

                  </div>
                  <hr>
                
                    
                

                </div>
              </div>
            </div>

      
  </div>  
 

   


  <?php include "part/js.php"; ?>

</body>
</html>