<script type="text/javascript">
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Earnings",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-01-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-02-01' AND '".date('Y')."-02-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-03-01' AND '".date('Y')."-03-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-04-01' AND '".date('Y')."-04-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-05-01' AND '".date('Y')."-05-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-06-01' AND '".date('Y')."-06-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-07-01' AND '".date('Y')."-07-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-08-01' AND '".date('Y')."-08-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-09-01' AND '".date('Y')."-09-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-10-01' AND '".date('Y')."-10-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-11-01' AND '".date('Y')."-11-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>,
      <?php 
      $sql=mysql_query("SELECT sum(amount) total FROM order_main WHERE tgl_order BETWEEN '".date('Y')."-12-01' AND '".date('Y')."-12-".date('t')."'");
      while ($row = mysql_fetch_array($sql)) { echo $row['total']; }
      ?>],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return 'Rp ' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});
</script>