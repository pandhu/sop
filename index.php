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

            $errNama = true;
            $errNpm = true;
            $errNohp = true;
            $errTgl = true;

            $nama=""; $npm=""; $nohp=""; $tgl_awal=""; $tgl_akhir="";            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nama = test_input($_POST["nama"]);
                $npm = test_input($_POST["npm"]);
                $nohp = test_input($_POST["no_hp"]);
                $tgl_awal = test_input($_POST["tanggal_dari"]);
                $tgl_akhir = test_input($_POST["tanggal_sampai"]);
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            function validateName($value) {
                if ($value == "") return false;
                if (!preg_match('/^[a-zA-Z\' ]*$/', $value)) return false;
                return true;
            }

            function validateNpm($value) {
                if (strlen($value) != 10) return false;
                if (!preg_match('/^[0-9]*/', $value)) return false;
                return true;
            }

            function validateNohp($value) {
                if ($value == "") return false;
                if (!preg_match('/^[0-9]*/', $value)) return false;
                return true;
            }

            function validateDate($startDate, $endDate) {
                if($startDate == "" or $endDate == "") return false;
                if($endDate < $startDate) return false;
                $today = date("Y-m-d");
                if($startDate < $today) return false;
                return true;
            }

            $errNama = !validateName($nama);
            $errNpm = !validateNpm($npm);
            $errNohp = !validateNohp($nohp);
            $errTgl = !validateDate($tgl_awal, $tgl_akhir);
            $err = $errNama or $errNpm or $errNohp or $errTgl;

            if (!$err) {
                $date = new DateTime();
                $date = $date->format('Y-m-d');

                $peminjaman_query = "SELECT * FROM peminjaman where tgl_akhir >= ".$date;
                $peminjaman_result = $conn->query($peminjaman_query);

                $alatmusik_query = "SELECT * FROM alatmusik";
                $alatmusik_result = $conn->query($alatmusik_query);

                $alatmusik = array();
                $jumlahalatmusik = $alatmusik_result->num_rows;
                for($i=0; $i<$jumlahalatmusik; $i+=1) {
                    $alatmusik[$i] = true;
                }

                while($row = $peminjaman_result->fetch_assoc()) {
                    if ($tgl_awal <= $row['tgl_awal'] and $tgl_akhir >= $row['tgl_awal'])
                        $alatmusik[($row['alatmusik'])-1] = false;
                    if ($tgl_awal >= $row['tgl_awal'] and $tgl_akhir <= $row['tgl_akhir'])
                        $alatmusik[($row['alatmusik'])-1] = false;
                    if ($tgl_awal <= $row['tgl_akhir'] and $tgl_akhir >= $row['tgl_akhir'])
                        $alatmusik[($row['alatmusik'])-1] = false;
                    if ($tgl_awal <= $row['tgl_awal'] and $tgl_akhir >= $row['tgl_akhir'])
                        $alatmusik[($row['alatmusik'])-1] = false;
                }
            
            }
        ?>

        <div class="container">
            <div class="row">
                <div class="header col-md-12 col-xs-12"><h1>Peminjaman Alat Musik Gudang Aula</h1></div>
            </div>
            <div class="row">
                <div class="content col-md-12 col-xs-12">
                    <div id="myCarousel" class="carousel slide" style="margin: 50px;" data-interval="false">
                        <div class="carousel-inner" role="listbox">
                            <div class="item <?php if(empty($_POST['check_list'])) echo 'active';?>">
                                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-sm-1" for="nama">Nama:</label>
                                        <div class="col-sm-11"><input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama?>" <?php if(!$err)echo 'disabled';?>></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-1" for="npm">NPM:</label>
                                        <div class="col-sm-11"><input type="text" class="form-control" name="npm" id="npm" value="<?php echo $npm?>" <?php if(!$err)echo 'disabled';?>></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-1" for="no_hp">No. HP:</label>
                                        <div class="col-sm-11"><input type="text" class="form-control" name="no_hp" id="no_hp" value="<?php echo $nohp?>" <?php if(!$err)echo 'disabled';?>></div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="tanggal_dari">Tanggal peminjaman:</label>
                                        <div class="col-sm-4"><input type="date" class="form-control" name="tanggal_dari" id="tanggal_dari" value="<?php echo $tgl_awal?>" <?php if(!$err)echo 'disabled';?>></div>
                                        <label class="control-label col-sm-1" for="tanggal_sampai">s.d.</label>
                                        <div class="col-sm-4"><input type="date" class="form-control" name="tanggal_sampai" id="tanggal_sampai" value="<?php echo $tgl_akhir?>" <?php if(!$err)echo 'disabled';?>></div>
                                    </div>

                                    <?php 
                                        if ($err)
                                            echo '<button type="submit" class="lanjut">Submit</button>';
                                        if (!$err)
                                            echo '<a class="lanjut" href="#myCarousel" role="button" data-slide="next"><p>Lanjut</p></a>';
                                    ?>
                                </form>
                            </div>
                            
                            <div class="item <?php if(!empty($_POST['check_list'])) echo 'active';?>">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-centered"><h3>Daftar Alat</h3></div>
                                </div>
                                <form role="form" action="<?php echo htmlspecialchars('validation.php');?>" method="post" class="form-horizontal">
                                    <div class="row">        
                                        <div class="col-md-3 col-xs-3"></div>
                                        <?php
                                            if(!empty($_POST['check_list'])) {
                                                $date = new DateTime();
                                                $date = $date->format('Y-m-d');

                                                $peminjaman_query = "SELECT * FROM peminjaman where tgl_akhir >= ".$date;
                                                $peminjaman_result = $conn->query($peminjaman_query);

                                                $alatmusik_query = "SELECT * FROM alatmusik";
                                                $alatmusik_result = $conn->query($alatmusik_query);

                                                $alatmusik = array();
                                                $jumlahalatmusik = $alatmusik_result->num_rows;
                                                for($i=0; $i<$jumlahalatmusik; $i+=1) {
                                                    $alatmusik[$i] = true;
                                                }

                                                while($row = $peminjaman_result->fetch_assoc()) {
                                                    if ($tgl_awal <= $row['tgl_awal'] and $tgl_akhir >= $row['tgl_awal'])
                                                        $alatmusik[($row['alatmusik'])-1] = false;
                                                    if ($tgl_awal >= $row['tgl_awal'] and $tgl_akhir <= $row['tgl_akhir'])
                                                        $alatmusik[($row['alatmusik'])-1] = false;
                                                    if ($tgl_awal <= $row['tgl_akhir'] and $tgl_akhir >= $row['tgl_akhir'])
                                                        $alatmusik[($row['alatmusik'])-1] = false;
                                                    if ($tgl_awal <= $row['tgl_awal'] and $tgl_akhir >= $row['tgl_akhir'])
                                                        $alatmusik[($row['alatmusik'])-1] = false;
                                                }

                                                $nama=""; $npm=""; $nohp=""; $tgl_awal=""; $tgl_akhir="";            
                                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                    $nama = test_input($_POST["nama"]);
                                                    $npm = test_input($_POST["npm"]);
                                                    $nohp = test_input($_POST["no_hp"]);
                                                    $tgl_awal = test_input($_POST["tanggal_dari"]);
                                                    $tgl_akhir = test_input($_POST["tanggal_sampai"]);
                                                }
                                                $conn->close();
                                            }

                                            $mid = $jumlahalatmusik/2;
                                            for ($j=0; $j<2; $j+=1) {
                                                echo '<div class="col-md-3 col-xs-3">';
                                                for ($i=$mid*$j; $i<($mid*($j+1)); $i+=1) {
                                                    if ($row = $alatmusik_result->fetch_assoc()) {
                                                        if ($alatmusik[$i]) {
                                                            echo '<div class="checkbox">';
                                                            echo '<label><input type="checkbox" name="check_list[]" value="'.($i+1).'">'.$row['nama'].'</label>';
                                                        } else {
                                                            echo '<div class="checkbox" disabled>';
                                                            echo '<label><input type="checkbox" name="check_list[]" value="" disabled>'.$row['nama'].' (tidak tersedia)</label>';
                                                        }
                                                    }
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                            } 
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-xs-3"></div>
                                        <div class="col-md-6 col-xs-6">;
                                            <p>Saya bertanggung jawab atas alat musik yang saya pinjam dari Departemen Seni Budaya BEM Fasilkom UI 2015. Saya bersedia untuk menggantinya jika terjadi kerusakan</p>
                                        </div>
                                        <div class="col-md-3 col-xs-3"></div>
                                    </div>

                                    <input type="hidden" class="form-control" name="nama" id="nama" value="<?php echo $nama?>">
                                    <input type="hidden" class="form-control" name="npm" id="npm" value="<?php echo $npm?>">
                                    <input type="hidden" class="form-control" name="no_hp" id="no_hp" value="<?php echo $nohp?>">
                                    <input type="hidden" class="form-control" name="tanggal_dari" id="tanggal_dari" value="<?php echo $tgl_awal?>">
                                    <input type="hidden" class="form-control" name="tanggal_sampai" id="tanggal_sampai" value="<?php echo $tgl_akhir?>">
                                       

                                    <div class="col-md-12 col-xs-12">
                                        <button type="submit" class="lanjut konfirmasi" style="position: relative; right: 100px;">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer"><p>&lt;/&gt; with &lt;3 by PTI BEM Fasilkom 2015</p></div>
        
    </body>
</html> 