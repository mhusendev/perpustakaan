  $("#tap").click(function() {
    var absen = $(".absen").val();
    
    var dataString = 'absen='+ absen;
    
    $.ajax({
      type: "POST",
      url: "ajax/ajax_absensi.php",
      data: dataString,
      cache: true,
      success: function(result){
        alert(result);
      }  
    });
  });