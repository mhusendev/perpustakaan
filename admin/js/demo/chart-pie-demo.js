// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var bri = $("#bri").val();
var man = $("#man").val();
var bca = $("#bca").val();
var tokped = $("#tokped").val();
var cash = $("#cash").val();

var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["BRI", "Mandiri", "BCA", "Tokopedia", "Cash"],
    datasets: [{
      data: [bri, man, bca, tokped, cash],
      backgroundColor: ['#4e73df', '#858796', '#36b9cc', '#1cc88a', '#f6c23e'],
      hoverBackgroundColor: ['#2e59d9', '#696b78', '#2c9faf', '#17a673', '#be9632'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
