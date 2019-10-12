<?php 
session_start();
?>
<!DOCTYPE html>

<html lang="en">

<head>

  <title>Creative Area</title>
    <meta charset="UTF-8">
 	<link rel="shortcut icon" type="image/png" href="img/apple-icon-180x180.png">
	<!-- /////////////////____XML SITEMAP___////////////// -->
	<meta name="google-site-verification" content="52volKlTFzdHQjUiainYq0jqxU-vTfD-ZB4B_GSiPCQ" />
	<!-- /////////////////////////////// -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css"/>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/63852fa8cf.js"></script>

</head>

<body>
<!-- Nav bar section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <a class="navbar-brand" href="index.php"><strong>Creative Area</strong></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

    <span class="navbar-toggler-icon"></span>

  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">

      <li class="nav-item active">

        <a class="nav-link" href="index.php">Ana səhifə <span class="sr-only">(current)</span></a>

      </li>

      <li class="nav-item">

        <a class="nav-link" href="?islem=konu_ekle">Mövzu əlavə et</a>

      </li>
      <li class="nav-item">

        <a class="nav-link" href="?islem=profil">Profil</a>

      </li>
    </ul>

    <form class="form-inline my-2 my-lg-0" action="index.php?islem=ara" method="POST">

      <input class="form-control mr-sm-2" type="search" placeholder="Axtar" aria-label="Search" name="ara">

      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Axtar</button>

    </form>

  </div>

</nav>

<!-- Nav bar section  END   -->

<!--           SCRIPT SECTION             -->

<script>

$( document ).ready(function() {

    $('#exampleModal').modal('show');
    $(".close").on("click",function(){
      window.location.replace("index.php");
    });
}); 
 

</script>

<!--           SCRIPT SECTION  END            -->

</body>

</html>

<!-- PHP START-->

<?php
try{

    $db = new PDO("mysql:host=localhost;dbname=blog","root","");

    $db->query("SET CHARACTER SET utf8");

}catch(PDOException $mesaj){

    echo $mesaj->getmessage();

}

$islem= @$_GET["islem"];

switch($islem){

    case "iletisim":

    echo "Burasi iletisim";

    break;

    case "hakkimda":

    echo "Burasi haqqimda";

    break;

    case "ara":

    ?>

    <div class="ara_container" style="display:grid;grid-template-columns:3fr 1fr"><!-- ara_container -->

    <div class="ara_rightcontent" style="grid-template-rows:auto"><!-- ara_rightcontent -->

      <?php

      // kategoriler sag menu

      $v=$db->prepare("select* from kategoriler");

      $v->execute(array());

      $c=$v->fetchAll(PDO::FETCH_ASSOC);

      $x=$v->rowCount();

      ?>  

      <div class="kategoritable kategoritableKategorisayfasi" >

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

    <?php

      //popular konular  start islem=kategoriler ucun

      $pop= $db->prepare("select *from konular where konu_durum=1 order by konu_hit desc limit 5");  //konu_tarih >= date_sub(curdate(),interval 7 day)--7gunluk interval daxilinde hit konulari tapmaq ucun

      $pop->execute(array());

      $v=$pop->fetchAll(PDO::FETCH_ASSOC);

      echo "<div class='pop popkategorisayfasi pop_ara_sayfasi'>

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

    ?>

    </div><!-- ara_rightcontent son-->

    <div class="ara_maincontent" style="order:-1"><!-- ara_maincontent -->

    <?php

      if($_POST){

        $ara=$_POST["ara"];

        if(!$ara){

            echo  '

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"data-backdrop="static" data-keyboard="false">

                <div class="modal-dialog" role="document" >

                  <div class="modal-content"  style="margin-top:250px">

                    <div class="modal-header">

                      <h5 class="modal-title" id="exampleModalLabel" ><span style="color:red;font-weight:bold;font-size:30px">Diqqet!!!</span></h5>

                      <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                      </button>

                    </div>

                    <div class="modal-body" style="text-align:center"><span style="font-size:18px;"><h1 style="color:red;font-size:50px;float:left;margin-left:10px"><i class="fas fa-exclamation-triangle"></i></h1>Boş şəkildə axtariş edə bilmərsiniz.<br/>Yönləndirilirsiz...</span></div>

                  </div>

                </div>

              </div>

            ';
            echo'<meta http-equiv="refresh" content="3;URL=index.php">'; 
        }else{

        $v= $db->prepare("select * from konular inner join kategoriler on kategoriler.kategori_id=konular.konu_kategori where konu_baslik like ?  and konu_durum=1 order by konu_id desc");

        $v->execute(array('%'.$ara.'%'));

        $x = $v->fetchAll(PDO::FETCH_ASSOC);

        $xx= $v->rowCount();

        if($xx){

            echo "<div class='alert alert-info' role='alert' style='font-size:22px;margin-top:10px;text-align:center;color:lightcoral'>Axtarışlarınızla əlaqəli  ".$xx."  nəticə tapıldı</div>";

        foreach($x as $m){

          //yorum sayisi tapmaq ara bolumunde

          $v=$db->prepare("select * from yorumlar where yorum_konu_id=?");

          $v->execute(array($m["konu_id"]));

          $zban=$v->rowCount();

          //yorum sayisi tapmaq ara bolumunde son

            ?>

            <div class="konu">

            <h3><?php echo $m["konu_baslik"]?></h3>

            <h5>Kateqoriya:<?php echo $m["kategori_adi"]?></h5>

            <h5>Edited: <?php echo $m["konu_ekleyen"];?>&nbsp&nbsp&nbspYorum:(<?php echo $zban?>) &nbsp&nbspOxundu:<?php  echo $m["konu_hit"]?><span style="font-size:15px;margin-top:3px">Tarix: <?php echo $m["konu_tarih"]?></span></h5>

            <p><?php echo substr($m["konu_aciklama"],0,200)?></p>

            <a href="index.php?islem=devam&id=<?php echo $m["konu_id"];?>"><button type="button" class="btn btn-primary btn-sm" style="float:right;margin-right:25px">Davamını oxu</button></a>

            </div>

            <?php

            }

        }else{

            echo "<div class='alert alert-danger' role='alert' style='font-size:22px;margin-top:10px;text-align:center;color:red'>Heç bir nəticə tapılmadı.</div>";

        }

      }

    }

    ?>    

    </div> <!-- ara_maincontent son-->   

    </div><!-- ara_container son-->

    <?php

    break;

    case "devam":

    $id = @$_GET["id"];

    $v=$db->prepare("select *from konular where konu_id=?");

    $v->execute(array($id));

    $x=$v->fetchAll(PDO::FETCH_ASSOC);

    $xx=$v->rowCount();

    if($xx){

        foreach($x as $m){

            ?>

            <div class="devam">

            <h3><?php echo $m["konu_baslik"]?></h3>

            <h5>Edited: <?php echo $m["konu_ekleyen"]?><span style="font-size:15px;margin-top:3px">Tarix: <?php echo $m["konu_tarih"]?></span></h5>

            <p><?php echo nl2br($m["konu_aciklama"]);?></p>

            </div>

            <?php

        }

        // goruntulenme(hit)  baslangic

        // if(!@$_COOKIE["hit".$id]){

          $hit = $db->prepare("update konular set konu_hit= konu_hit +1 where konu_id=?");

          $hit->execute(array($id));

          // setcookie("hit".$id,"_",time ()+1000);

          // }

        // konu goruntulenme(hit) sonu

        //yorum listeleme

        $c = $db->prepare("select * from yorumlar where yorum_konu_id=? and yorum_onay=?");

        $c->execute(array($id,1));

        $x= $c->fetchAll(PDO::FETCH_ASSOC);

        $xx=$c->rowCount();

        if($xx){

          echo '

          <div class="yorumsayisi">Bu mövzuya '.$xx.' yorum var</div>

          ';

          foreach($x as $b){

           ?>

           <div class="yorumlar">

           <h5>Edited: <?php echo $b["yorum_ekleyen"];?><span style="font-size:15px;margin-top:3px">Tarix:<?php echo $b["yorum_tarih"]?></span></h5>

           <p><?php echo $b["yorum_mesaj"]?></p>

           </div>

           <?php

          }

        }else{

          echo "<div class='alert alert-warning' role='alert' style='width:600px;margin:auto;margin-top:50px;font-size:22px;text-align:center;'>Bu mövzuya heç bir yorum tapılmadı.</div>";

        }

        //yorum listeleme sonu

        //yorum bolumu

        if($_POST){

          $isim	    = $_POST["isim"];		 

          $eposta	= $_POST["eposta"];		 

          $mesaj	= $_POST["mesaj"];		 

          $konuid   = $_POST["konuid"];		 

    if(!$isim || !$eposta || !$mesaj){

      echo "<div class='alert alert-warning' role='alert' style='width:600px;margin:auto;margin-top:50px;font-size:22px;text-align:center;'>Boşluqları doldurmanız lazımdır.Yönləndirilirsiz...</div>";

      $url = $_SERVER['HTTP_REFERER'];  // hangi sayfadan gelindigi degerini verir.
      echo'<meta http-equiv="refresh" content="2;URL=".$url."">'; 
    }else{

    $c = $db->prepare("insert into yorumlar set 

          yorum_ekleyen=?,

          yorum_eposta=?,

          yorum_mesaj=?,

          yorum_konu_id=? 							 

    ");

   $x = $c->execute(array($isim,$eposta,$mesaj,$konuid));

   if($x){

     echo  '

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">

          <div style="margin:auto;margin-top:250px;width:700px;"> 

            <div class="modal-content"  style="width:700px;">

             <div class="modal-header">

               <h5 class="modal-title" id="exampleModalLabel" ><span class="text-success" style="font-size:30px;font-weight:bold;">Təşəkkürlər</span></h5>
             </div>
             <div class="modal-body" style="text-align:center"><span style="font-size:18px;"><i class="far fa-check-circle" style="color:green;font-size:50px;float:left;margin-top:15px"></i><b style="color:green;font-size:20px">Mesajınız uğurla göndərildi.<br/>Mesajınız təstiqləndikdən sonra paylaşılacaq.<br/>Yönləndirilirsiz....</b></span></div>

           </div>

          </div> 

       </div>

     ';

    $url = $_SERVER['HTTP_REFERER'];  // hangi sayfadan gelindigi degerini verir.
    echo'<meta http-equiv="refresh" content="2;URL=".$url."">'; 
   }else{

     echo  '

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

         <div class="modal-dialog" role="document" >

           <div class="modal-content"  style="margin-top:250px">

             <div class="modal-header">

               <h5 class="modal-title" id="exampleModalLabel" ><span style="color:red;font-weight:bold;font-size:30px">Diqqət!!!</span></h5>
             </div>
             <div class="modal-body" style="text-align:center"><span style="font-size:18px;" class="text-danger"><h1 style="color:red;font-size:50px;float:left;margin-left:10px"><i class="fas fa-exclamation-triangle"></i></h1>Yorum göndərilirkən xəta baş verdi.<br/>Yönləndirilirsiz...</span></div>

           </div>

         </div>

       </div>

     ';

    $url = $_SERVER['HTTP_REFERER'];  // hangi sayfadan gelindigi degerini verir.
    echo'<meta http-equiv="refresh" content="3;URL=".$url."">'; 
   }

    }

  }else{

     if($_SESSION){

      ?>

      <div class="yorum_form">

    <h2>Yorum Göndər</h2>

    <form action="" method="post">

        <table cellpadding="5" cellspacing="5">

        <tr>

          <td class="nn"></td>

          <td><input type="hidden" value="<?php echo $_SESSION["uye"];?>" name="isim" required/></td>

        </tr>

        <tr>

          <td class="nn"></td>

          <td><input type="hidden" value="<?php echo $_SESSION["eposta"];?>" name="eposta" required/></td>

        </tr>

        <tr>

          <td class="nn">Mesaj:</td>

          <td><textarea name="mesaj" id="" cols="50" rows="5" required></textarea></td>

        </tr>

        <tr>

          <td></td>

          <td><input type="hidden" name="konuid" value="<?php echo $m["konu_id"];?>"/></td>

        </tr>

        </table>

        <button type="submit" class="btn btn-dark" style="float:right;margin-bottom:15px">Göndər</button>

   </form>

   <?php

     }else{

   ?>

   <div class="yorum_form">

    <h2>Yorum Göndər</h2>

    <form action="" method="post">

        <table cellpadding="5" cellspacing="5">

        <tr>

          <td class="nn">Ad:</td>

          <td><input type="text" name="isim" required/></td>

        </tr>

        <tr>

          <td class="nn">Email:</td>

          <td><input type="email" name="eposta" required/></td>

        </tr>

        <tr>

          <td class="nn">Mesaj:</td>

          <td><textarea name="mesaj" id="" cols="50" rows="5" required></textarea></td>

        </tr>

        <tr>

          <td></td>

          <td><input type="hidden" name="konuid" value="<?php echo $m["konu_id"];?>"/></td>

        </tr>

        </table>

        <button type="submit" class="btn btn-dark" style="float:right;margin-bottom:15px">Göndər</button>

   </form>

   </div>

    <?php			 

     }

  }

    //yorum bolumu sonu

    }else{

        echo "<div class='alert alert-danger' role='alert' style='font-size:22px;margin-top:10px;text-align:center;color:red'>Bele bir mövzu mövcud deyil və ya silinib</div>";

  }

    break;

    case "kategori":

    $id=$_GET["id"];

    $v=$db->prepare("select * from konular inner join kategoriler on kategoriler.kategori_id=konular.konu_kategori where konu_kategori=? and konu_durum=1 order by konu_id desc ");

    $v->execute(array($id));

    $c=$v->fetchAll(PDO::FETCH_ASSOC);

    $x=$v->rowCount();

    $b=$db->prepare("select * from konular inner join kategoriler on kategoriler.kategori_id=konular.konu_kategori where konu_kategori=? and konu_durum=1 order by konu_id desc ");

    $b->execute(array($id));

    $z=$b->fetch(PDO::FETCH_ASSOC);

    $n=$b->rowCount();

    ?>

    <div class="alert alert-info" role="alert" style="margin-top:20px">

    <p class="text-info" style="font-size:22px;text-align:center;margin:0;padding:0"><b class="text-danger"><?php echo $z["kategori_adi"]?></b> <b>kateqoriyasına aid <b class="text-danger">"<?php echo $n?>"</b> nəticə tapıldı.</b></p>

    </div>

    <div class="kategori_container" style="width:100%;display:grid;grid-template-columns:3fr 1fr"> <!--  kategori_container   -->

    <div class="kategori_rightcontent" style="grid-template-rows:auto"> <!-- kategori_rightcontent -->

    <div class="rightcontent_grid" style="display:grid;grid-template-rows:auto"><!--  kategori_rightcontent  grid-->

    <?php

    if($_SESSION){

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

    <a href="?islem=profil"><li class="chngbl">Profil</li></a>

    <a href="?islem=konu_ekle"><li class="chngbl">Mövzu əlavə et</li></a>

    <a href="cikis.php"><li  class="chngbl">Çıxış</li></a>

    </ul>

    </div>

    <?php

    }else{

    //uyelik sistemi    

    ?>

    <div class="uyelik">

    <h2>Uye girisi</h2>

    <?php include("uye.php");?>

    <form action="" method="post">

    <div class="form_content"> 

    <div class="form-group">

    <input type="text" class="form-control" name="isim" placeholder="Üyə adı">

    </div>

    <div class="form-group">

      <input type="password" name="sifre" class="form-control" placeholder="Üyə şifrə">

    </div>   

    <button type="submit" class="btn btn-primary">Daxil Ol</button>

    </div>

    </form>

    </div>

    <?php

    }

    //uyelik sistemi son

    //popular konular  start islem=kategoriler ucun

    $pop= $db->prepare("select *from konular where konu_durum=1 order by konu_hit desc limit 5");  //konu_tarih >= date_sub(curdate(),interval 7 day)--7gunluk interval daxilinde hit konulari tapmaq ucun

    $pop->execute(array());

    $v=$pop->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='pop popkategorisayfasi'>

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

    // populyar konular son islem=kategoriler ucun

    ?>

    </div><!--  kategori_rightcontent  grid son-->

    </div>  <!-- kategori_rightcontent son-->

    <div class="kategori_maincontent" style="order:-1">  <!--  kategori_maincontent   -->

    <?php

    if($x){

      foreach($c as $m){

    ?>

    <?php

    //konuya aid yorum

    $v=$db->prepare("select * from yorumlar where yorum_konu_id=?");

    $v->execute(array($m["konu_id"]));

    $zban=$v->rowCount();

    //konuya aid yorum son

    ?>

    <div class="konu">

    <h3><?php echo $m["konu_baslik"]?></h3>

    <h5>Edited: <?php echo $m["konu_ekleyen"];?>&nbsp&nbsp&nbspYorum:(<?php echo $zban?>) &nbsp&nbspOxundu:<?php  echo $m["konu_hit"]?><span style="font-size:15px;margin-top:3px">Tarix: <?php echo $m["konu_tarih"]?></span></h5>

    <p><?php echo substr($m["konu_aciklama"],0,210)?>....</p>

    <a href="index.php?islem=devam&id=<?php echo $m["konu_id"];?>"><button type="button" class="btn btn-primary btn-sm" style="float:right;margin-right:25px">Davamını oxu</button></a>

    </div>    

    <?php

      }  

    ?>    

    </div><!--  kategori_maincontent  son -->

    <?php

  }else{

    echo '<p class="text-info" style="font-size:22px;text-align:center;margin:0;padding:0"> Bu kateqoriyaya aid mövzu yoxdur</p>';

  }

  ?>

    </div>  <!--  kategori_container  son -->

    <?php

    break;

    case "konu_ekle":

    if($_SESSION){

      if($_POST){

        $baslik=$_POST["baslik"];

        $kategori=$_POST["kategori"];

        $aciklama=$_POST["aciklama"];

        if(!$baslik || !$aciklama){

          echo '

          <div class="alert alert-danger text-danger" role="alert" style="text-align:center">

          <h3><b>Boşluqları doldurun</b></h3><a href="'.$url = $_SERVER['HTTP_REFERER'].'" style="text-decoration:none;color:green;font-weight:bold;font-size:20px;" >Geri qayıt</a>

          </div>';

        }else{

          $insert=$db->prepare("insert into konular set

          konu_baslik=?,

          konu_kategori=?,

          konu_aciklama=?,

          konu_ekleyen=?

          ");

          $kayit=$insert->execute(array($baslik,$kategori,$aciklama,$_SESSION["uye"]));

          if($kayit){

            echo '

            <div class="alert alert-success text-success" role="alert" style="text-align:center;margin-top:20px"><i class="far fa-check-circle" style="font-size:55px;"></i><h3>Mövzu uğurla əlavə olundu.Mövzu təstiqləndikdən sonra paylaşılacaq.Yönləndirilirsiz...</h3></div>';
            echo'<meta http-equiv="refresh" content="2;URL=index.php">'; 
          }else{
            echo '
            <div class="alert alert-danger text-danger" role="alert" style="text-align:center;margin-top:20px">
            <h3>Mövzu əlavə olunurkan xəta baş verdi.Yönləndirilirsiz...</h3></div>';
            echo'<meta http-equiv="refresh" content="2;URL=?islem=konu_ekle">'; 
          }

        }
      }else{

        $v=$db->prepare("select * from kategoriler");

        $v->execute(array());

        $c=$v->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <div class="konu_ekle">

          <form action="" method="post">

          <h2>Konu ekle.</h2>

          <ul>

            <!-- <li>Konu basligi</li> -->

            <li>Mövzu adı:<input type="text" name="baslik" style="float:right;margin-right:30px"></li>

            <li>Kateqoriyalar:  

              <select name="kategori" style="float:right;margin-right:30px;width:300px">

                <?php

                foreach($c as $m){

                  echo '<option value=" '.$m["kategori_id"].' ">'.$m["kategori_adi"].'</option>';

                }   

                ?>

              </select>

            </li>

            <li>Mövzu tərkibi:</li>

            <li><textarea name="aciklama"></textarea></li>

            <li><button type="submit" class="btn btn-primary">Mövzu əlavə et</button></li>

          </ul>

          </form>

        </div>

        <?php

      }

    }else{

      ?>

      <div class="alert alert-danger" role="alert" style="text-align:center;font-size:25px;color:red;margin-top:20px">

        <b>Burası yalnız qeydiyyatlı istifadəçilər üçündür.<br/>Mövzu əlavə etmək üçün qeydiyyatdan keçin.</b>

      </div>

      <?php

      exit;

    }
    break;

    case "profil":
      
      include("profil.php");
      
    break;

    case "newPhoto";
      include("newPhoto.php");
    break;

    default:

    ?>

    <div class="maincontainer"style="width:100%;display:grid;grid-template-columns:3fr 1fr;margin-top:30px"> <!--  main container -->

    <div class="maincontent"> <!--  maincontent -->

    <?php

     // sayfalama

     $sayfa =intval(@$_GET["sayfa"]);

     if(!$sayfa){

       $sayfa=1;

     }

     $v = $db->prepare("select * from konular inner join kategoriler on kategoriler.kategori_id = konular.konu_kategori where konu_durum=1");

     $v ->execute(array());

     $toplam = $v->rowCount();

     $limit = 2;

     $goster = $sayfa*$limit-$limit;// hansi seyfede olsa evvelki ve sonuncu postlarin intervalini paylasir(1-3;2-4;4-6....)

     $sayfa_sayisi = ceil($toplam/$limit); 

     $forlimit = 2; // sayfa linklerinde 2dene button olacaq

     // sayfalama  son

     $v=$db->query("select * from konular inner join kategoriler on kategoriler.kategori_id = konular.konu_kategori where konu_durum=1 order by konu_id desc limit $goster,$limit");

     $v->execute(array());

     $x= $v->fetchAll(PDO::FETCH_ASSOC);

     ?>

     <?php

     foreach($x as $m){

       //yorum sayisi bulma ana sayfada

       $v=$db->prepare("select * from yorumlar where yorum_konu_id=? and yorum_onay=?");

       $v->execute(array($m["konu_id"],1));

       $zban=$v->rowCount();

       ?>

         <div class="konu">

         <h3><?php echo $m["konu_baslik"]?></h3>

         <h5>Kateqoriya:<?php echo $m["kategori_adi"]?></h5>

         <h5>Edited: <?php echo $m["konu_ekleyen"]?>&nbsp&nbsp&nbspYorum:(<?php echo $zban?>)&nbsp&nbspOxundu:<?php  echo $m["konu_hit"] ?><span style="font-size:15px;margin-top:3px;float:right">Tarix: <?php echo $m["konu_tarih"]?></span></h5>

         <p><span class="contentStyle"><?php echo substr($m["konu_aciklama"],0,200)?>...</span></p>

         <a href="index.php?islem=devam&id=<?php echo $m["konu_id"];?>"><button type="button" class="btn btn-primary btn-sm" style="position:absolute;bottom:20px;right:25px">Davamını oxu</button></a>

         </div>

     <?php

     }

     //sayfalama linkleri....  

    ?>

    <div  style="display:flex;justify-content:center;margin:20px 0 20px 0;width:100%;">

    <?php

    for($i = $sayfa-$forlimit;$i<$sayfa+$forlimit+1;$i++){



    if($i>0 && $i<=$sayfa_sayisi){

      if ($i == $sayfa){

        echo '

        <button type="button" class="btn btn-outline-secondary btn-sm"  style="margin:5px" disabled><strong>'.$i.'</strong></button>

        ';

      }else{

        echo '

        <a href="index.php?sayfa='.$i.' " style="color:inherit;text-decoration:none"><button type="button" class="btn btn-secondary btn-sm" style="margin:5px" >'.$i.'</button></a> 

        ';

      }

    }

  }

  if($sayfa!=$sayfa_sayisi){

    echo '<a href="index.php?sayfa='.$sayfa_sayisi.' style="color:inherit;text-decoration:none""><button type="button" class="btn btn-secondary btn-sm" style="margin:5px" ><strong> >>> </strong></button></a>';

  }

  ?>

  </div>

  <!-- sayfalama divinin sonu -->

  </div><!--  maincontent  son-->

  <div class="rightcontent"> <!--  right content-->

    <div class="rightcontent_grid" style="display:grid;grid-template-rows:auto"><!--  rightcontent_grid-->

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

    <a href="?islem=profil"><li class="chngbl">Profil</li></a>

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

    </div>

    <?php

    break;

}

?>