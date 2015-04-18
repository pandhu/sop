<div class="row">
        <div class="content container" style="padding: 50px;">
            <div style="border: 1px solid #319C00; border-radius: 5px; padding: 10px; background-color: #E0FFD1; color: #319C00;">Pemesanan berhasil</div>
			<table class="table table-bordered" style="table-layout: fixed; margin-top: 20px; background-color: white;">
				<tr>
					<th style="width: 150px;">Nama</th>
					<td><?php echo $nama; ?></td>
				</tr>
				<tr>
					<th>NPM</th>
					<td><?php echo $npm; ?></td>
				</tr>
				<tr>
					<th>No. HP</th>
					<td><?php echo $nohp; ?></td>
				</tr>
				<tr>
					
				</tr>
			</table>
			<!--
			<legend>Alat Musik yang Dipinjam</legend>
			<ul class="list-group">
			<?php		
				// $alatmusik_query = "SELECT alatmusik.nama as alatmusiknama FROM peminjaman, alatmusik where peminjaman.nama = '".$nama." and npm = ".$npm." and nohp = '".$nohp."' and tgl_awal = '".$tgl_awal."' and tgl_akhir = '".$tgl_akhir."' and alatmusik.id = alatmusik";
    //             $alatmusik_result = $conn->query($alatmusik_query);

    //             if ($alatmusik_result != null) {
	   //              $jumlahalatmusik = $alatmusik_result->num_rows;
	   //              for($i=0; $i<$jumlahalatmusik; $i+=1) {
	   //              	if ($row = $alatmusik_result->fetch_assoc()) {
		  //                   echo '<li class="list-group-item">'.$row["alatmusiknama"].'</li>';
		  //               }
		  //           }
		  //       }
    //     		$conn->close();	
			?>
			</ul>
		-->
        </div>
    </div>