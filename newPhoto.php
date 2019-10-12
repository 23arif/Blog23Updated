<html>
	<head><title></title></head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
		
		.fileLoaderSection{
			border:1px solid #ddd;
			display: flex;
			align-items: center;
			flex-direction: column;
			margin-top: 20px
		}
		.fileLoaderSection h1{
			margin:20px;
		}
	</style>
	<body>	


		<div class="container border" style="width: 70%;min-height:200px;margin-top: 25px" >
			 
			   <?php
			    include("config.php");
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);
			    
				if($_FILES){
				        $id = $_GET["id"];

				        $maxBoyut = 700000;
				        $dosyaUzantisi = substr($_FILES["dosya"]["name"],-4,4);
				        $dosyaAdi = rand(1,99999).$dosyaUzantisi;
				        $dosyaYolu = "Base/".$dosyaAdi;

				        if($_FILES["dosya"]["size"]>$maxBoyut){
				            echo "Şəkil ölçüsü böyükdür!";
				        }else{
				            $dosya = $_FILES["dosya"]["type"];
				            if($dosya == "image/jpeg" || $dosya=="image/png" || $dosya== "image/gif"){

				                if(is_uploaded_file($_FILES["dosya"]["tmp_name"])){

				                    $tasi = move_uploaded_file($_FILES["dosya"]["tmp_name"],$dosyaYolu);

				                    $bul = $db->prepare("select * from avatars where resim_id=?");
				                    $bul->execute(array($id));
				                    $v = $bul ->fetch(PDO::FETCH_ASSOC);

				                    unlink ($v["resim_adi"]);

				                    $kayit = $db->prepare("update avatars set
				                        resim_adi=?,
				                        resim_turu=?,
				                        resim_size=? where resim_id=?
				                    ");
				                    $resimTuru = $_FILES["dosya"]["type"];
				                    $resimSize = $_FILES["dosya"]["size"];

				                    $kayit->execute(array($dosyaYolu,$resimTuru,$resimSize,$id));
				                    if($tasi){
				                        echo "Şəkil yeniləndi";
           								echo'<meta http-equiv="refresh" content="2;URL=?islem=profil">'; 
				                       

				                    }else{
				                        echo "Xəta baş verdi";
				                        
				                    }
				                }else{
				                    echo "Xəta baş verdi";
				                }


				            }else{
				                echo "bu nov fayl yukleye bimersiniz";
				            }
				        }

				    }else{
				        // $id = $_GET["id"];
				        
				        $b = $db->prepare("select * from avatars");
				        $b->execute(array());
				        $vv = $b ->fetch(PDO::FETCH_ASSOC);
				        ?>
				            <div class="dosya">
				            <h2>Dosya duzenle</h2>
				            <img src="<?php echo $vv["resim_adi"]?>" width="150" height="150" alt="">
				            <form action="" method="post" enctype="multipart/form-data">
				                <input type="file" id="file"name="dosya">
				                <label for="file" />choose a file</label>

				                <button type="submit">duzenle</button>
				            </form>
				            </div>
				        <?php
				    }

							    ?>
		</div>


	</body>
</html>