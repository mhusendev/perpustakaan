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
	<?php include"part/header.php"; ?>
	<main>
		<div class="hero_home version_1">
			<div class="content">
				<h3>Perpustakaan</h3>
				<p>
				  Temukan semua buku yang anda cari disini
				</p>
				 <center><a href="#menubuku">Menu</a> | <a href="index.php">Home</a></center>
			</div>
		</div>
		<!-- /Hero -->

			<div class="container margin_120_95" id="menubuku">
			<div class="main_title">
				<h2>Detail Buku</h2>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<a href="caribuku.php" class="box_cat_home" >
						
						<h3>Sejarah</h3>
					    <hr>
							<p style="text-align: left; margin-left: 5%;">Pengarang        : Muhammad Husen <br><br> Tahun Terbit : 2014 <br><br> Penerbit : Gagas Media <br><br> Kategori Buku : Siroh</p>
						<hr>
						<p>Stok Buku : 10 <br> Dipinjam : 0</p>	
						
					</a>
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