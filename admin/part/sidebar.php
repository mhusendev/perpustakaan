    <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar"  style="background: #970101!important;"> 

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
         
        </div>
        <div class="sidebar-brand-text mx-3">Administrator</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item" id="dash">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item" id="mstr">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book"></i>
          <span>Buku</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
    
             <h6 class="collapse-header">Master Buku</h6>
            <a class="collapse-item" href="buku.php">Judul & Kategori</a>
           <h6 class="collapse-header">Transaksi</h6>
            <a class="collapse-item" href="stokbuku.php">Stok Buku</a>
            <h6 class="collapse-header">Report</h6>
            <a class="collapse-item" href="category.php">Report catalog</a>
            
          </div>
        </div>
      </li>
  <div class="sidebar-heading">
        
      </div>
       
      <li class="nav-item" id="mmbr">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-user-alt"></i>
          <span>Member</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="member.php">Data Member</a>
           
          </div>
        </div>
      </li>
  <div class="sidebar-heading">
        
      </div>
      <!-- Heading -->
       <li class="nav-item" id="trx">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tiga" aria-expanded="true" aria-controls="tiga">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Transaksi</span>
        </a>
        <div id="tiga" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
    
            
            <a class="collapse-item" href="cekpinjam.php">Peminjaman</a>
    
            <a class="collapse-item" href="cekpengembalian.php">Pengembalian</a>
              <h6 class="collapse-header">Report</h6>
              <a class="collapse-item" href="datapinjam.php">Data Peminjaman</a>
               <a class="collapse-item" href="category.php">Data Pengembalian</a>
            
          </div>
        </div>
      </li>

      <!-- Nav Item - Charts -->
     

    <!--   <li class="nav-item" id="prcs">
        <a class="nav-link" href="process.php">
          <i class="fas fa-fw fa-cog"></i>
          <span>Process</span></a>
      </li>
 -->
     

      <!--
      <li class="nav-item" id="trns">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Stock Out</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="waiting.php">Waiting Payment</a>
            <a class="collapse-item" href="confirm.php">Confirm Payment</a>
            <a class="collapse-item" href="sended.php">Sended</a>
          </div>
        </div>
      </li>
      -->

      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Report
      </div>
     

      <li class="nav-item" id="mngm">
        <a class="nav-link" href="users.php">
          <i class="fas fa-fw fa-wrench"></i>
          <span>User Management</span></a>
      </li>

      <!-- 
      <hr class="sidebar-divider">

      
      <div class="sidebar-heading">
        Absensi
      </div>

      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#absenModal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Absen</span></a>
      </li>
      -->
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>