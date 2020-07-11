<?php 
  include "admin/lib/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">


<?php include"part/head.php";?>

<body>

	<div class="layer"></div>
	<!-- Mobile menu overlay mask -->

	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<!-- End Preload -->
    

	<!-- /header -->
	<?php include"part/header.php";?>
	<main>
		<div class="hero_home version_1">
			<div class="content">
				<h3>Perpustakaan </h3>
				<p>
				  Temukan semua buku yang anda cari disini
				</p>
				 <center><a href="#menubuku">Menu</a> | <a href="index.php">Home</a></center>
			</div>
		</div>
		<!-- /Hero -->

		<div class="container " style="margin-top: 50px!important;">
			<div class="main_title">
				<form method="post" action="list.php">
						<div id="custom-search-input">
							<div class="input-group">
								<input type="text" class=" search-query" placeholder="Judul buku...">
								<input type="submit" class="btn_search" value="Search">
							</div>
						
						</div>
					</form>
			</div>
			<div class="row justify-content-center">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="list_home">
						<div class="list_title">
							<h3>List Buku</h3>
						</div>
						<ul>

							
							<?php 
                             $sql = mysql_query("select * from master_buku");
                             $n=1;
                              while ($row = mysql_fetch_array($sql)) {	?>
                              
                              <li><a href="detail.php?judul=<?php echo$row['judul'];?>"><strong><?php echo $n ?></strong><?php echo$row['judul']; ?></a></li>

                                  
                              <?php 

                               $n++;
                          } ?>
						
						</ul>

					</div>
					<nav aria-label="" class="add_top_20">
						<ul class="pagination pagination-sm">
							<li class="page-item disabled">
								<a class="page-link" href="#" tabindex="-1">Previous</a>
							</li>
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item">
								<a class="page-link" href="#">Next</a>
							</li>
						</ul>
					</nav>
				</div>
				
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

		
		<!-- /white_bg -->

	
		<!-- /container -->

		<!-- /app_section -->
	</main>
	<!-- /main content -->
	
	<?php include"part/footer.php";?>
	<!--/footer-->

	<div id="toTop"></div>
	<!-- Back to top button -->

	<!-- COMMON SCRIPTS -->
	<script src="js/jquery-2.2.4.min.js"></script>
	<script src="js/common_scripts.min.js"></script>
	<script src="js/functions.js"></script>

</body>

</html>