<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Peminjaman Alat Musik Gudang Aula</title>
	<link rel="stylesheet" href="lib/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="lib/js/jquery-2.1.3.min.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="header col-md-12 col-xs-12"><h1>Peminjaman Alat Musik Gudang Aula</h1></div>
    </div>

    <?php 
    	$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sopgudangaula";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

   		$nama=""; $npm=""; $nohp=""; $tgl_awal=""; $tgl_akhir="";            
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = $_POST["nama"];
            $npm = $_POST["npm"];
            $nohp = $_POST["no_hp"];
            $tgl_awal = $_POST["tanggal_dari"];
            $tgl_akhir = $_POST["tanggal_sampai"];

        	foreach($_POST['check_list'] as $check) {
	            $query = "INSERT INTO peminjaman (nama, npm, nohp, alatmusik, tgl_awal, tgl_akhir) VALUES ('".$nama."', '".$npm."', '".$nohp."', '".$check."', '".$tgl_awal."', '".$tgl_akhir."')";
	            if ($conn->query($query) != FALSE) {
	              	$isSuccess = true;
	            } else {
	            	$isSuccess = false;
	            }
	        }

        	if ($tgl_awal == '' || $tgl_akhir == '') {
        		$isSuccess = false;
        	}
	    } else {
	        header("Location: ./");
	    }
    ?>

    <?php
    	if ($isSuccess) {
    		include('success.php');
    	} else {
    		include('failed.php');
    	}
    ?>
    
</div>

<div class="footer"><p>&lt;/&gt; with &lt;3 by PTI BEM Fasilkom 2015</p></div>
    
</body>
</html>