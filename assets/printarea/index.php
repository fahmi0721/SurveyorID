<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>JQuery Print Area</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="bootstrap.min.css" rel="stylesheet" media="screen">
	
	<!-- css yang digunakan ketika dalam mode screen -->
	<link href="style.css" rel="stylesheet" media="screen">
	
	<!-- ss yang digunakan tampilkan ketika dalam mode print -->
	<link href="print.css" rel="stylesheet" media="print">
	
	<script src="jquery-1.8.3.min.js"></script>
	<script src="jquery.PrintArea.js"></script>
	<script>
		(function($) {
			// fungsi dijalankan setelah seluruh dokumen ditampilkan
			$(document).ready(function(e) {
				// aksi ketika tombol cetak ditekan
				$("#cetak").bind("click", function(event) {
					// cetak data pada area <div id="#data-mahasiswa"></div>
					$('#data-mahasiswa').printArea();
				});
			});
		}) (jQuery);
	</script>
</head>

<body>

<div class="navbar navbar-static-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="http://umsida.ac.id">Univ. Muhammadiyah Sidoarjo</a>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">

		<h3>
			Daftar Mahasiswa
			<button id="cetak" class="btn pull-right">Cetak</button>
		</h3>
		
		<div id="data-mahasiswa">
		
		<!-- tampilkan ketika dalam mode print -->
		<div class="title">
			<center>
				DAFTAR MAHASISWA<br/>
				FAKULTAS TEKNIK<br/>
				UNIVERSITAS MUHAMMADIYAH SIDOARJO
			</center>
		</div>
		
		<table class="table table-condensed table-bordered table-hover" cellpadding="0" cellspacing="0">
			<thead>
			<tr>
				<th width="2%">#</th>
				<th width="12%">NIM</th>
				<th width="20%">Nama</th>
				<th>Alamat</th>
				<th width="12%">Kelas</th>
				<th width="12%">Status</th>
				<th width="9%" class="action"></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1. </td>
				<td>08.10802.00234</td>
				<td>Ari Effendi</td>
				<td>Gedangan</td>
				<td>E Sore</td>
				<td>Aktif</td>
				<!-- sembunyikan ketika dalam mode print -->
				<td class="action">
					<a href="#" class="btn btn-mini">Ubah</a>
					<a href="#" class="btn btn-mini">Hapus</a>
				</td>
			</tr>
		</tbody>
		</table>		
		
		</div>
	</div>
</div>

</body>
</html>
