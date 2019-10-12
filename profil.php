<!DOCTYPE html>
<html>
<head>
  <title>Creative Area</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<?php



$do = @$_GET["do"];

if($_SESSION){  
        $id = @$_GET["id"];
        $k=$db->prepare("select * from uyeler where uye_id=?");
        $k->execute(array($id));
        $t=$k->fetch(PDO::FETCH_ASSOC);


    ?>
    <div class="maincontainer"style="width:100%;display:grid;grid-template-columns:3fr 1fr;margin-top:30px;grid-gap: 10px"> <!--  main container -->

      <div class="maincontent" style="margin-left: 20px"> <!--  maincontent -->
        <div class="alert h4 text-center" style="margin-top: 10px; background-color: #343a40;color:#fff"role="alert">
          Profil Düzənlə
        </div>

        <div class="profilContainer">


		    <div class="rowLeft  border">
				<h4 style="margin-bottom: 40px">Profil Şəkli:</h4>
				 <div id="profilPhoto"><img src="Base/defaultAvatar.png"></div>
				 <a href="?islem=newPhoto"><button type="button" class="btn btn-primary" style="margin-top: 15px">Yenilə</button></a>
				<hr style="border:1px solid #ccc6c6;width: 60%;margin-top: 30px">
				<p style="text-align: center;">Şəkillər yalnız JPG, GİF vəya PNG olaraq yükləyə bilərsiniz.</p>
			</div>
         
            <?php

              try{
                  $db = new PDO("mysql:host=localhost;dbname=blog","root","");
                  $db->query("SET CHARACTER SET utf8");
              }catch(PDOException $mesaj){
                  echo $mesaj->getmessage();
              }
            if($_POST){
              $uyeYerMekan=$_POST["uyeYerMekan"];
              $uyeHaqqinda=$_POST["uyeHaqqinda"];

              $c = $db->prepare("insert into uyeler set 
              uye_yer_mekan=?,
              uye_haqqinda=?
              ");
              $x = $c->execute(array($uyeYerMekan,$uyeHaqqinda));
              if($x){
                echo "<div class='rowRight'>Yenilendi</div";
              }else{
                echo "xeta bas verdi";
                            ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
              }
            }else{
            ?>

          <div class="rowRight border">
            <h4 style="margin-bottom: 40px">Şəxsi məlumatlar:</h4>
            <div class="form-group profilInfo">
              <form method="post">
                <label for="exampleInputUsername">İstifadəçi adınız:</label>
                <input type="text" class="form-control" id="exampleInputUsername" aria-describedby="usernameHelp" disabled="" value="<?php echo $_SESSION["uye"]?>">
                <small id="usernameHelp" class="form-text text-danger" style="margin-top: -15px">İstifadəçi adınızı dəyişdirə bilmərsiniz.</small>

                <label for="exampleInputEmail">Email ünvanınız:</label>
                <input type="email" class="form-control" id="exampleInputEmail"placeholder="Email ünvanınızı daxil edin." value="<?php echo $_SESSION["eposta"]?>">

                <label for="exampleInputPlace">Yer & Məkan:</label>
                <input type="text" class="form-control" name="uyeYerMekan" id="exampleInputPlace"placeholder="Yer & məkan daxil edin.">

                <label>Haqqınızda:</label>
                <textarea class="form-control" name="uyeHaqqinda" placeholder="Haqqınızda" rows="5" style="resize: none;"></textarea>
                <button type="submit" class="btn btn-primary" style="width: 100%;margin-top: 15px">Düzənlə</button>
              </form>
            </div>
          </div>
          <?php
                }
          ?>
          </div>

      </div><!--  maincontent  son-->

      <div class="rightcontent"> <!--  right content-->

      <div class="rightcontent_grid" style="display:grid;grid-template-rows:auto;"><!--  rightcontent_grid-->

      <?php

      if($_SESSION && $_SESSION["onay"]==1){

      ?>

      <div class="uyelik">

      <h2>Üyə paneli</h2>

      <ul>

      <li>Xoş gəldiniz: <?php echo $_SESSION["uye"]?></li>

      <?php

      if($_SESSION["durum"]==1){

          echo "<a href='admin.php'><li class='chngbl'>Admin Paneli</li></a>";

      }

      ?>
      <a href="?islem=konu_ekle"><li class="chngbl">Mövzu əlavə et</li></a>
      <a href="cikis.php"><li  class="chngbl">Çıxış</li></a>

      </ul>

      </div>

      <?php

      }else{

      //uyelik sistemi    

      ?>

      <div class="uyelik">

      <h2>Üyə girişi</h2>

      <?php include("uye.php");?>

      <form action="" method="post">

      <div class="form_content"> 

      <div class="form-group">

      <input type="text" class="form-control" name="isim" placeholder="Üyə adı">

      </div>

      <div class="form-group">

        <input type="password" name="sifre" class="form-control" placeholder="Üyə şifrə">

      </div>   

      <button type="submit" class="btn btn-primary">Daxil Ol</button><br/><div style="float:right;margin:5px 0 5px 0"><a href="registration.php" style="margin:auto">Qeydiyyatdan keç</a></div>

      </div>

      </form>

      </div>
      <!-- uyelik sistemi son -->
      <?php
      }
      // kategoriler sag menu
      $v=$db->prepare("select* from kategoriler");

      $v->execute(array());

      $c=$v->fetchAll(PDO::FETCH_ASSOC);

      $x=$v->rowCount();

      ?>

      <div class="kategoritable">

        <h2>Kateqoriyalar</h2>

        <ul>

          <?php

          if($x){

            foreach($c as $m){

              echo '<a href="?islem=kategori&id='.$m["kategori_id"].'"><li>'.$m["kategori_adi"].'</li></a>';

            }

          }else{

            Echo "Kateqoriya yoxdur";

          }

          ?>

        </ul>

        </div>

      <!-- kategoriler sag menu  son-->

      <?php

      //popular konular start

      $pop= $db->prepare("select *from konular where konu_durum=1 order by konu_hit desc limit 5");  // where =====>>>>> konu_tarih >= date_sub(curdate(),interval 7 day)--7gunluk interval daxilinde hit konulari tapmaq ucun

      $pop->execute(array());

      $v=$pop->fetchAll(PDO::FETCH_ASSOC);

      ?>

      <?php

      echo "<div class='pop'>

      <h2 id='hh'>Populyar mövzular</h2>

      <ul>

      ";

      foreach($v as $x){

        ?>

        <a id="idpop"href="index.php?islem=devam&id=<?php echo $x["konu_id"];?>">

        <li>

        <?php echo substr($x["konu_baslik"],0,70)."....."."<br/>";?>

        </li>

        </a>

        <?php

      }

      echo "</ul></div>";

      //popular konular finish

      ?>

      </div><!--  rightcontent_grid son-->

      </div> <!--  rightcontent sonu-->

    </div> <!--  main container son-->





<?php
    }else{
      echo '
        <div class="alert alert-danger text-center text-danger h4" style="margin-top:15px" role="alert">
          Zəhmət olmasa sayta giriş edin.<br/>Ana səhifəyə yönləndirilirsiniz...
        </div>
      ';
      echo'<meta http-equiv="refresh" content="3;URL=index.php">'; 

    }
?>


</body>
</html>