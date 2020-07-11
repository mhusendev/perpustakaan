var xmlHttp = createXmlHttpRequestObject();

// membuat obyek XMLHttpRequest

function createXmlHttpRequestObject()
{
    var xmlHttp;

    // cek untuk browser IE

    if(window.ActiveXObject)
    {
       try
       {
          xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
       }
       catch (e)
       {
          xmlHttp = false;
       }
    }
// cek untuk browser Firefox atau yang lain
else
{
    try
    {
       xmlHttp = new XMLHttpRequest();
    }
    catch (e)
    {
         xmlHttp = false;
    }

// tes
var xxmlhttp;
  if (window.ActiveXObject)
  {
    try
    {
      xxmlhttp=new ActiveXObject("Microsoft.xxmlhttp");
    }
    catch (e)
    {
      xxmlhttp= false;
    }
  }
  else
  {
    try
    {
      xxmlhttp=new XMLHttpRequest();
    }
    catch(e)
    {
      xxmlhttp=false;
    }
  }

if (!xxmlhttp) alert ("Object xxmlhttpRequest gagal dibuat !");
else
return xxmlhttp;




}

// muncul pesan apabila obyek XMLHttpRequest gagal dibuat

if (!xmlHttp) alert("Obyek XMLHttpRequest gagal dibuat");
else
return xmlHttp;
}

// melakukan request secara asynchronous dengan XMLHttpRequest ke 
// server
function tampil()
{
  if (xxmlhttp.readyState ==4 || xxmlhttp.readyState ==0 )
  {
    xxmlhttp.open ("GET","ajax/peminjaman.php?op=tampildata",true);
    xxmlhttp.onreadystatechange = handleServerResponse;
    xxmlhttp.send(null);
  }
  else
  setTimeout('tampil()',1000);
}

function simpan()
{
  
  if (xxmlhttp.readyState==4 || xxmlhttp.readyState==0)
  {
    kdm   =encodeURIComponent(document.getElementById("kdm").value);
    buku  =encodeURIComponent(document.getElementById("kdb").value);
  
    /* kesalahan semula: kurang tanda sama dengan setelah op=simpandata&&nim */ 
    xxmlhttp.open("GET","ajax/peminjaman.php?op=simpandata&kdm="+kdm+"&kdb="+buku,true);
    xxmlhttp.onreadystatechange = handleServerResponse;
    xxmlhttp.send(null);
  }
  else
  setTimeout('simpan()',1000);
}

function hapus(kdm,kdb)
{
  if (xxmlhttp.readyState==4 || xxmlhttp.readyState==0)
  {
    xxmlhttp.open("GET","ajax/peminjaman.php?op=hapusdata&kdm="+kdm+"&kdb="+kdb,true);
    xxmlhttp.onreadystatechange = handleServerResponse;
    xxmlhttp.send(null);
  }
  else
  setTimeout('hapus()',1000);
}
function process()
{
    // akan diproses hanya bila obyek XMLHttpRequest tidak sibuk

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
    {
       // mengambil nama dari text box (form)

       nama = 
         encodeURIComponent(document.getElementById("kdb").value);

       // merequest file cek.php di server secara asynchronous

       xmlHttp.open("GET", "ajax/cekbuku.php?kdb=" + nama, true);

       // mendefinisikan metode yang dilakukan apabila memperoleh
       // response server

       xmlHttp.onreadystatechange = handleServerResponse;

       // membuat request ke server

       xmlHttp.send(null);

    }
    else
        {	
         // Jika server sibuk, request akan dilakukan lagi setelah
         // satu detik

         setTimeout('process()', 500);
        }
}

// fungsi untuk metode penanganan response dari server

function handleServerResponse()
{
    // jika proses request telah selesai dan menerima respon

    if (xmlHttp.readyState == 4)
    {
       // jika request ke server sukses
 
       if (xmlHttp.status == 200)
       {
          // mengambil dokumen XML yang diterima dari server

          xmlResponse = xmlHttp.responseXML;

          // memperoleh elemen dokumen (root elemen) dari xml

          xmlDocumentElement = xmlResponse.documentElement;

          // membaca data elemen

          hasil = xmlDocumentElement.firstChild.data;
          // akan mengupdate tampilan halaman web pada elemen bernama 
          // respon
 
           if (hasil == " ") {
          
           document.getElementById("nb").value = "" ;


        }
        else{
           document.getElementById("nb").value = hasil ;
     
      

        }

          // request akan dilakukan lagi setelah
          // satu detik (automatic request)

          setTimeout('process()', 500);


          var xmlResponse = xxmlhttp.responseXML;
      xmlRoot =xmlResponse.documentElement;
      
      kdmArray = xmlRoot.getElementsByTagName("kdm");
      kdbArray = xmlRoot.getElementsByTagName("kdb");
    
      html = ' <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"><thead><tr><th>Kode user</th><th>Kode Buku</th></tr></thead>';
      
      for (var i=0; i<nimArray.length; i++)
      {
        html += "<tbody><tr><td>" + kdmArray.item(i).firstChild.data + "</td><td>" + kdbArray.item(i).firstChild.data + "</td><a href=\"datamhs.php\" onclick=\"hapus('"+kdmArray.item(i).firstChild.data+"'); return false;\">Hapus</a></td></tr></tbody>";
      }
      html = html + "</table>";
      document.getElementById("data").innerHTML = html;
       }
       else
       {
          // akan muncul pesan apabila terjadi masalah dalam mengakses 
          // server (selain respon 200)

          alert("Terjadi masalah dalam mengakses server " +
          xmlHttp.statusText);
       }
    }
}
