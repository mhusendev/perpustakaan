              <div class="row">
                <?php
                $bca=0;
                $bri=0;
                $man=0;
                $tokped=0;
                $cash=0;
                if (isset($_POST['tgl1'])) {
                  if (isset($_POST['via'])) {
                    if ($_POST['via']=='all') {
                      $via="";
                    } else {
                      $via="and c.nm_acc = '".$_POST['via']."'";
                    }
                  }
                  $sql=mysql_query("select sum(a.net_total) total,a.via from so1 a join tb_account c on a.via=c.id_acc where a.tgl_so >= '".$_POST['tgl1']."' and a.tgl_so <= '".$_POST['tgl2']."' ".$via." group by a.via order by a.tgl_so desc");
                  while ($row = mysql_fetch_array($sql)) {
                    if ($row['via']==1) {
                      $bca=$row['total'];
                    } else if ($row['via']==2) {
                      $bri=$row['total'];
                    } else if ($row['via']==3) {
                      $man=$row['total'];
                    } else if ($row['via']==4) {
                      $tokped=$row['total'];
                    } else if ($row['via']==5) {
                      $cash=$row['total'];
                    }
                    $vi=$row['via'];
                  }
                  if (isset($_POST['via'])) {
                    if ($_POST['via']=='BRI'||$_POST['via']=='all') {
                ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">BRI (Total)</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($bri); ?></div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } if ($_POST['via']=='Mandiri'||$_POST['via']=='all') { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mandiri (Total)</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($man); ?></div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } if ($_POST['via']=='BCA'||$_POST['via']=='all') { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">BCA (Total)</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($bca); ?></div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } if ($_POST['via']=='Tokopedia'||$_POST['via']=='all') { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tokopedia (Total)</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($tokped); ?></div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } if ($_POST['via']=='Cash'||$_POST['via']=='all') { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Cash (Total)</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($cash); ?></div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } 
                $v2="";
                if ($_POST['via']=='all') {
                  $v2="";
                } else {
                  $v2="and c.via='".$vi."'";
                }
                $query=mysql_query("SELECT a.nm_product, SUM(b.qty) qty FROM product a JOIN so2 b ON a.id_product=b.id_bahan JOIN so1 c ON b.id_so1=c.id_so1 WHERE c.tgl_so >= '".$_POST['tgl1']."' AND c.tgl_so <= '".$_POST['tgl2']."' ".$v2." GROUP BY b.id_bahan ORDER BY qty DESC LIMIT 1");
                while ($data = mysql_fetch_array($query)) {
                  $nama=$data['nm_product'];
                  $qty=$data['qty'];
                }
                ?>
                <div class="col-xl-6 col-md-12 mb-4">
                  <div class="card border-left-danger shadow h-100 py-2" style="background:#ffddda">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Best Selling Product</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nama; ?></div>
                        </div>
                        <div class="col-auto">
                          <h3><b><?php echo $qty; ?></b></h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
            <?php }} ?>