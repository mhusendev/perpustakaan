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
}

// muncul pesan apabila obyek XMLHttpRequest gagal dibuat

if (!xmlHttp) alert("Obyek XMLHttpRequest gagal dibuat");
else
return xmlHttp;
}

// melakukan request secara asynchronous dengan XMLHttpRequest ke 
// server

function process()
{
    // akan diproses hanya bila obyek XMLHttpRequest tidak sibuk

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
    {
       // mengambil nama dari text box (form)

       tglkembali = 
         encodeURIComponent(document.getElementById("kembali").value);
        batas=
        encodeURIComponent(document.getElementById("tglpengembalian").value);
       // merequest file cek.php di server secara asynchronous

       xmlHttp.open("GET", "ajax/cekdenda.php?tgkb=" + tglkembali+"&batas="+batas, true);

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

         setTimeout('process()', 1000);
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
 
          if (hasil=="0") {
            document.getElementById("telat").value = "0" ;

          }else{
     
           document.getElementById("telat").value = hasil ;}
          
        

          // request akan dilakukan lagi setelah
          // satu detik (automatic request)

          setTimeout('process()', 1000);
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
