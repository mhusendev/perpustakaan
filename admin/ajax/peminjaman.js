var xxmlhttp = createxxmlhttpRequestObject();

function createxxmlhttpRequestObject()
{
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
	
function handleServerResponse()
{
	if (xxmlhttp.readyState==4)
	{
		if (xxmlhttp.status == 200)
		{
			var xmlResponse = xxmlhttp.responseXML;
			xmlRoot =xmlResponse.documentElement;
			
			kdmArray = xmlRoot.getElementsByTagName("kdm");
			kdbArray = xmlRoot.getElementsByTagName("kdb");
		
			html = "<thead><tr><th>Kode user</th><th>Kode Buku</th></tr></thead>";
			
			for (var i=0; i<nimArray.length; i++)
			{
				html += "<tbody><tr><td>" + kdmArray.item(i).firstChild.data + "</td><td>" + kdbArray.item(i).firstChild.data + "</td><a href=\"datamhs.php\" onclick=\"hapus('"+kdmArray.item(i).firstChild.data+"'); return false;\">Hapus</a></td></tr></tbody>";
			}
			html = html ;
			document.getElementById("dataTable").innerHTML = html;
		}
		else
		{
			alert("Ada kesalahan dalam mengakses server : " + xxmlhttp.statusText);
		}
	}
}
	
