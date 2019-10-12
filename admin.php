<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/png" href="img/apple-icon-180x180.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/63852fa8cf.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Admin panel</title>
</head>
<script>
$( document ).ready(function() {
    $('#exampleModal').modal('show');
}); 
</script>
<style>
body{
    background:#eee;
}

</style>
<body>
    <?php
    if($_SESSION){

        try{
            $db = new PDO("mysql:host=localhost;dbname=blog","root","");
            $db->query("SET CHARACTER SET utf8");
        }catch(PDOException $mesaj){
            echo $mesaj->getmessage();
        }


        if($_SESSION["durum"]==1){
            ?>
            <div class="header">

            <img src="img/Hybrid_art_2.jpg" alt="">
            <h6>Admin paneline xoş gəlmisiniz: <span><?php echo $_SESSION["uye"]?></span><span style="float:right;margin-top:-4px"><a href="index.php"><button type="button" class="btn btn-primary btn-sm">Saytı göstər</button></a></span></h6>
            </div>
            <div class="genel">
                <div class="menu">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.php">Ana səhifə</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="?do=konu">Mövzular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?do=kategori">Kateqoriyalar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?do=yorum">Yorumlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?do=uye">İstifadəçilər</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cikis.php">Çıxış</a>
                    </li>
                    </ul>
                </div>
                <div class="icerik">
                <?php
                    $do=@$_GET["do"];
                    switch($do){
                        case "konu":

                        $v=$db->prepare("select *from konular inner join kategoriler on  kategoriler.kategori_id=konular.konu_kategori order by konu_id desc limit 2000"); //burdaki limit admin panel konularda olan konular siyahisini azaldir donmamasin ucun
                        $v->execute(array());
                        $c=$v->fetchAll(PDO::FETCH_ASSOC);
                        $x=$v->rowCount();
                        
                        ?>
                        <h2>Mövzular <span style="float:right;font-size:15px;margin:10px 10px 0 0"><a href="?do=konu_ekle"><i class="far fa-edit" style="color:green;"><b>Mövzu əlavə et</b></i></a></span></h2>
                        <div class="admin_konular">
                        <form action="" method="post">
                            <table cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Mövzu Adları</th><th style="width:150px;">Mövzu Onayları</th><th>Mövzu Kateqoriyaları</th><th>Proseslər</th>
                                    </tr>
                                </thead>
                                
                                <?php
                               
                                if($x){
                                    foreach($c as $m){
                                    ?>
                                        <tbody>
                                            <tr>
                                                <td style="width:900px"><?php echo $m["konu_baslik"]?></td>
                                                <td style="text-align:center;">
                                                    <?php 
                                                    if($m["konu_durum"]==1){
                                                    echo "<span class='alert alert-success text-success'>Onayli</span>";
                                                    }else{
                                                        echo "<span class='alert alert-danger text-danger'>Onaysiz</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align:center"><?php echo $m["kategori_adi"]?></td>
                                                <td style="text-align:center">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a onclick="return confirm('Mövzunu silmək istədiyinizə əminsiniz?')"href="?do=konu_sil&id=<?php echo $m["konu_id"];?>"><button type="button" class="btn btn-secondary bg-danger" style="border:1px solid red">Sil</button></a>
                                                    <a href="?do=konu_duzenle&id=<?php echo $m["konu_id"];?>"><button type="button" class="btn btn-secondary bg-success" style="border:1px solid green">Düzənlə</button></a>
                                                    <div style="margin:5px 0 0 7px"><input type="checkbox" name="sil[]" value="<?php echo $m["konu_id"]?>" class="large_checkbox"/></div>
                                                </div>        

                                                </td>
                                            </tr>
                                        </tbody>

                                    <?php
                                    }
                                }else{
                                    echo '<tr><td colspan=4><h3 class="alert alert-success text-success" role="alert" style="text-align:center;margin:auto">Hal-hazirda konu movcud deyil</h3></td></tr>';
                                }

                                ?>
                            </table>
                            <div  style="float:right;margin:10px 27px 0 0"><button type="submit" class="btn btn-primary">Seçilən mövzuları sil</button></div>
                            </form>
                        </div>
                        <?php

                        if($_POST){
                            $sil=implode(",",$_POST["sil"]);
                            $delete=$db->query("delete from konular where konu_id in($sil)");
                            if($delete){
                                echo '
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog" role="document" >
                                <div class="modal-content"  style="margin-top:250px ;width:600px">
                                    <div class="modal-header">
                                    </div>
                                    <div class="modal-body" >
                                    <div style="float:left;height:50px;margin-left:10px"><i class="far fa-check-circle" style="font-size:50px;color:green"></i></div>
               
                                    <div style="float:left;height:50px;margin-left:40px"><p style="font-size:20px;margin-top:10px;color:green;font-weight:bold">Seçilən mövzular uğurla silindi.Yönləndirilirsiz...</p></div>
                                    </div>
                                </div> 
                                </div>
                            </div>
                                ';
                                echo'<meta http-equiv="refresh" content="3;URL=?do=konu">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert">
                                Seçilən mövzular silinərkən xəta baş verdi.
                                </div>';
                            }
                        }                

                        break;
                        
                        case "konu_ekle":
                        ?>
                        <h2>Konu ekle</h2>
                        <?php

                        if($_POST){

                            $baslik=$_POST["baslik"];
                            $kategori=$_POST["kategori"];
                            $aciklama=$_POST["aciklama"];
                            $onay=$_POST["onay"];
                            if(!$baslik || !$aciklama){
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                <h3><b>Boşluqları doldurun</b></h3><a href="'.$url = $_SERVER['HTTP_REFERER'].'" style="text-decoration:none;color:green;font-weight:bold;font-size:20px;" >Geri qayit</a>
                                </div>
                                ';
                            }else{
                                $v=$db->prepare("select *from konular where konu_baslik=?");
                                $v->execute(array($baslik));
                                $k=$v->fetch(PDO::FETCH_ASSOC);
                                $x=$v->rowCount();
                                if($x){
                                    echo '
                                    <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                    <h3>"'.$baslik.'" adinda konu zaten var. Basqa konu ekleyin.</h3></div>';

                                }else{
                                $insert=$db->prepare("insert into konular set
                                        konu_baslik=?,
                                        konu_kategori=?,
                                        konu_aciklama=?,
                                        konu_durum=?,
                                        konu_ekleyen=?
                                ");
                                $kayit=$insert->execute(array($baslik,$kategori,strip_tags($aciklama,'<img>'),$onay,$_SESSION["uye"]));
                                if($kayit){
                                    echo '
                                    <div class="alert alert-success text-success" role="alert" style="text-align:center"><i class="far fa-check-circle" style="font-size:55px;"></i><h3>Mövzu uğurla əlavə olundu.Yönləndirilirsiz...</h3></div>';
                                    echo'<meta http-equiv="refresh" content="2;URL=?do=konu">'; 
                                }else{
                                    echo '
                                    <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                    <h3>Konu eklenirken xeta olusdu.Yonlendirilirsiz...</h3></div>';
                                    echo'<meta http-equiv="refresh" content="2;URL=?do=konu_ekle">'; 
                                }
                            }
                            }
                        }else{
                            $z=$db->prepare("select * from kategoriler");
                            $z->execute(array());
                            $c=$z->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="admin_konu_ekle">
                            <form action="" method="post">
                            <ul>
                                <li>Mövzu adı:</li>
                                <li><input type="text" name="baslik"></li>
                                <li>
                                    <select name="kategori" id="">
                                        <?php
                                            foreach($c as $m){
                                                echo "<option value='".$m["kategori_id"]."'>".$m["kategori_adi"]."</option>";
                                            }
                                        ?>
                                    </select>
                                </li>
                                <li>Mövzu tərkibi:</li>
                                <li><textarea name="aciklama"></textarea></li>
                                <li><select name="onay" id="">
                                    <option value="1">Onayli</option>
                                    <option value="0">Onaysiz</option>
                                </select></li>
                                <li><button type="submit" class="btn btn-primary">Mövzu əlavə et</button></li>
                            </ul>
                            </form>
                            </div>
                            <?php
                        }
                        break;

                        case "uye":
                        ?>
                        <h2>İstifadəçilər</h2>
                        <?php
                        $u=$db->prepare("select *from uyeler order by uye_id desc");
                        $u->execute(array());
                        $k=$u->fetchAll(PDO::FETCH_ASSOC);
                        $z=$u->rowCount();
                        ?>
                        <div class="admin_users">
                        <form action="" method="post">
                        <table>
                        <thead>
                        <tr>
                        <th>İstifadəçi adı</th><th>İstifadəçi email</th><th>Durum</th><th>Onay</th><th>Proseslər</th>
                        </tr>
                        </thead>
                        <?php
                        if($z){
                        foreach($k as $t){
                            ?>
                            <tbody>
                            <tr>
                            <td><?php echo $t["uye_adi"]?></td>
                            <td><?php echo $t["uye_eposta"]?></td>
                            <td style="width:110px">
                            <?php    
                                if($t["uye_durum"]==1){
                                    echo '
                                    <div class="alert alert-success text-success" role="alert">Admin</div>
                                    ';
                                }else{
                                    echo '
                                    <div class="alert alert-secondary text-secondary" role="alert">İstifadəçi</div>
                                    ';
                                }
                            ?>
                            </td>
                            <td style="width:110px">
                            <?php    
                                if($t["uye_onay"]==1){
                                    echo '
                                    <div class="alert alert-success text-success" role="alert">Onaylı</div>
                                    ';
                                }else{
                                    echo '
                                    <div class="alert alert-danger text-danger" role="alert">Onaysız</div>
                                    ';
                                }
                            ?>    
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a onclick="return confirm('İstifadəçini silmək istədiyinizə əminsiniz?')"href="?do=uye_sil&id=<?php echo $t["uye_id"];?>"><button type="button" class="btn btn-secondary bg-danger" style="border:1px solid red">Sil</button></a>
                                    <a href="?do=uye_duzenle&id=<?php echo $t["uye_id"];?>"><button type="button" class="btn btn-secondary bg-success" style="border:1px solid green">Düzənlə</button></a>
                                    <div style="margin:5px 0 0 7px"><input type="checkbox" name="sil[]" value="<?php echo $t["uye_id"]?>" class="large_checkbox"/></div>
                                </div>  
                            </td>
                            </tr>
                            </tbody>
                            <?php
                        }
                        }else{
                            echo '<td class="alert alert-danger text-danger" role="alert" colspan=5 style="text-align:center;"><b>Hec bir istifadeci tapilmadi</b></td>';
                        }
                        ?>
                        </table>
                        <div  style="float:right;margin:10px 27px 0 0"><button type="submit" class="btn btn-primary">Seçilən İstifadəçiləri sil</button></div>
                        </form>
                        </div>
                        <?php
                        if($_POST){
                            $sil=implode(",",$_POST["sil"]);
                            $delete=$db->query("delete from uyeler where uye_id in($sil)");
                            if($delete){
                                echo '
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog" role="document" >
                                <div class="modal-content"  style="margin-top:250px ;width:650px">
                                    <div class="modal-header">
                                    </div>
                                    <div class="modal-body" >
                                    <div style="float:left;height:50px;margin-left:10px"><i class="far fa-check-circle" style="font-size:50px;color:green"></i></div>
               
                                    <div style="float:left;height:50px;margin-left:40px"><p style="font-size:20px;margin-top:10px;color:green;font-weight:bold">Seçilən istifadəçilər uğurla silindi.Yönləndirilirsiz...</p></div>
                                    </div>
                                </div> 
                                </div>
                            </div>
                                ';
                                echo'<meta http-equiv="refresh" content="2;URL=?do=uye">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert">
                                Seçilən istifadəçilər silinərkən xəta baş verdi.
                                </div>';
                            }
                        }         
                        break;
                        
                        case "kategori":
                        ?>
                        <h2>Kateqoriyalar<span style="float:right;font-size:15px;margin:10px 10px 0 0"><a href="?do=kategori_ekle"><i class="far fa-edit" style="color:green;"><b style="font-family:arial;">Kateqoriya əlavə et</b></i></a></span></h2>
                        <?php
                        $k=$db->prepare("select* from kategoriler order by kategori_id desc");
                        $k->execute(array());
                        $z=$k->fetchAll(PDO::FETCH_ASSOC);
                        $y=$k->rowCount();
                        ?>
                        <div class="admin_kategoiler">
                            <form action="" method="post">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Kateqoriya adı</th><th>Kateqoriya Açıklaması</th><th>Proseslər</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if($y){
                                        foreach($z as $g){
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $g["kategori_adi"]?></td>
                                                <td><?php echo $g["kategori_aciklama"]?></td>
                                                <td style="text-align:center;max-width:170px">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a onclick="return confirm('Yorumu silmək istədiyinizə əminsiniz?')"href="?do=kategori_sil&id=<?php echo $g["kategori_id"];?>"><button type="button" class="btn btn-secondary bg-danger" style="border:1px solid red">Sil</button></a>
                                                        <a href="?do=kategori_duzenle&id=<?php echo $g["kategori_id"];?>"><button type="button" class="btn btn-secondary bg-success" style="border:1px solid green">Düzənlə</button></a>
                                                        <div style="margin:5px 0 0 7px"><input type="checkbox" name="sil[]" value="<?php echo $g["kategori_id"]?>" class="large_checkbox"/></div>
                                                    </div>        
                                                </td>
                                            </tr> 
                                        </tbody>
                                        <?php
                                        }
                                    }else{
                                        echo "kateqori tapilmadi";
                                    }
                                    ?>

                                </table>
                                <div  style="float:right;margin:10px 27px 0 0"><button type="submit" class="btn btn-primary">Seçilən kateqoriyaları sil</button></div>
                            </form>
                        </div>
                        <?php
                        if($_POST){
                            $sil=implode(",",$_POST["sil"]);
                            $delete=$db->query("delete from kategoriler where 	kategori_id in($sil)");
                            if($delete){
                                echo '
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                    <div style="width:100%;height:100vh;display:flex;justify-content:center;align-items:center">
                                        <div class="modal-content"  style="width:650px;height:150px;border:1px solid #fff">
                                            <div class="modal-body">
                                                <div style="width:70px;height:60px;float:left;margin:30px 20px 0 20px"><i class="far fa-check-circle" style="font-size:60px;color:green"></i></div>
                                                <p style="font-size:20px;margin-top:40px;color:green;font-weight:bold;text-align:center;float:left">Seçilən kateqoriyalar uğurla silindi.Yönləndirilirsiz...</p>
                                            </div>
                                        </div> 
                                    </div>        
                                </div>
                                ';
                                echo'<meta http-equiv="refresh" content="2;URL=?do=kategori">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                Seçilən kateqoriyalar silinərkən xəta baş verdi.
                                </div>';
                            }
                        }         
                        break;
                        
                        case "yorum":
                        $v=$db->prepare("select *from yorumlar inner join konular on konular.konu_id=yorumlar.yorum_konu_id  order by yorum_id desc");
                        
                        $v->execute(array());
                        $c=$v->fetchAll(PDO::FETCH_ASSOC);
                        $x=$v->rowCount();
                        ?>
                        <h2>Yorumlar</h2>
                        <div class="adminyorumlar">
                        <form action="" method="post">
                            <table cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Yorum müəllifi</th><th>Yorum</th><th>Yorum Onayları</th><th>Mövzu Adı</th><th>Proseslər</th>
                                    </tr>
                                </thead>
                                <?php
                                if($x){
                                    foreach($c as $m){
                                    ?>
                                        <tbody>
                                            <tr>
                                                <td style="max-width:190px"><?php echo $m["yorum_ekleyen"]?></td>
                                                <td><?php echo substr($m["yorum_mesaj"],0,150)?>...</td>
                                                <td style="text-align:center;max-width:123px">
                                                    <?php 
                                                    if($m["yorum_onay"]==1){
                                                    echo "<span class='alert alert-success text-success'>Onayli</span>";
                                                    }else{
                                                        echo "<span class='alert alert-danger text-danger'>Onaysiz</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align:center"><?php echo $m["konu_baslik"]?></td>
                                                <td style="text-align:center;max-width:170px">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a onclick="return confirm('Yorumu silmək istədiyinizə əminsiniz?')"href="?do=yorum_sil&id=<?php echo $m["yorum_id"];?>"><button type="button" class="btn btn-secondary bg-danger" style="border:1px solid red">Sil</button></a>
                                                    <a href="?do=yorum_duzenle&id=<?php echo $m["yorum_id"];?>"><button type="button" class="btn btn-secondary bg-success" style="border:1px solid green">Düzənlə</button></a>
                                                    <div style="margin:5px 0 0 7px"><input type="checkbox" name="sil[]" value="<?php echo $m["yorum_id"]?>" class="large_checkbox"/></div>
                                                </div>        
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php
                                    }
                                }else{
                                    echo '<tr><td colspan=5><h3 class="alert alert-success text-success" role="alert" style="text-align:center;margin:auto">Hal-hazırda yorum mövcud deyil</h3></td></tr>';
                                }
                                ?>
                            </table>
                            <div  style="float:right;margin:10px 27px 0 0"><button type="submit" class="btn btn-primary">Seçilən yorumları sil</button></div>
                        </form>
                        </div>   
                        
                        <?php
                        
                        if($_POST){
                            $sil=implode(",",$_POST["sil"]);
                            $delete=$db->query("delete from yorumlar where yorum_id in($sil)");
                            if($delete){
                                echo '
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
                                <div class="modal-dialog" role="document" >
                                <div class="modal-content"  style="margin-top:250px ;width:600px">
                                    <div class="modal-header">
                                    </div>
                                    <div class="modal-body" >
                                    <div style="float:left;height:50px;margin-left:10px"><i class="far fa-check-circle" style="font-size:50px;color:green"></i></div>
               
                                    <div style="float:left;height:50px;margin-left:40px"><p style="font-size:20px;margin-top:10px;color:green;font-weight:bold">Seçilən yorumlar uğurla silindi.Yönləndirilirsiz...</p></div>
                                    </div>
                                </div> 
                                </div>
                            </div>
                                ';
                                echo'<meta http-equiv="refresh" content="2;URL=?do=yorum">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert">
                                Secilen yorumlar silinerken xeta olusdu.
                                </div>';
                            }
                        }                        

                        break;

                        case "konu_duzenle":
                        $id=$_GET["id"];

                        ?>
                        <h2>Konu düzənlə</h2>
                        <?php

                        if($_POST){

                            $baslik=$_POST["baslik"];
                            $kategori=$_POST["kategori"];
                            $aciklama=$_POST["aciklama"];
                            $onay=$_POST["onay"];
                            if(!$baslik || !$aciklama){
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                <h3><b>Boşluqları doldurun</b></h3><a href="'.$url = $_SERVER['HTTP_REFERER'].'" style="text-decoration:none;color:green;font-weight:bold;font-size:20px;" >Geri qayit</a>
                                </div>
                                ';
                            }else{
                                $update=$db->prepare("update konular set
                                        konu_baslik=?,
                                        konu_kategori=?,
                                        konu_aciklama=?,
                                        konu_durum=?
                                        where konu_id=?
                                ");
                                $guncelle=$update->execute(array($baslik,$kategori,strip_tags($aciklama,'<img>'),$onay,$id));
                                if($guncelle){
                                    echo '
                                    <div class="alert alert-success text-success" role="alert" style="text-align:center"><i class="far fa-check-circle" style="font-size:55px;"></i><h3>Konu basariynan yenilendi.Yonlendirilirsiz...</h3></div>';
                                    echo'<meta http-equiv="refresh" content="2;URL=?do=konu">'; 
                                }else{
                                    echo '
                                    <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                    <h3>Konu yenilenirken xeta olusdu.Yonlendirilirsiz...</h3></div>';
                                    echo'<meta http-equiv="refresh" content="2;URL=?do=konu">'; 
                                }
                            
                            }
                        }else{
                            $z=$db->prepare("select * from kategoriler");
                            $z->execute(array());
                            $c=$z->fetchAll(PDO::FETCH_ASSOC);

                            $v=$db->prepare("select *from konular where konu_id=?");
                            $v->execute(array($id));
                            $z=$v->fetch(PDO::FETCH_ASSOC);
                            $x=$v->rowCount();
                            ?>
                            <div class="admin_konu_ekle">
                            <form action="" method="post">
                            <ul>
                                <li>Mövzu adı:</li>
                                <li><input type="text" value="<?php echo $z["konu_baslik"]?>"name="baslik"></li>
                                <li>
                                    <select name="kategori" id="">
                                        <?php
                                            foreach($c as $m){
                                                echo "<option value='".$m["kategori_id"]."'";
                                                echo $m["kategori_id"]== $z["konu_kategori"] ? "selected":null;
                                                echo ">".$m["kategori_adi"]."</option>";
                                            }
                                        ?>
                                    </select>
                                </li>
                                <li>Mövzu tərkibi:</li>
                                <li><textarea name="aciklama"><?php echo $z["konu_aciklama"]?></textarea></li>
                                <li><select name="onay" id="">
                                    <option value="1" <?php echo $z["konu_durum"]==1 ? 'selected':null; ?> >Onayli</option>
                                    <option value="0" <?php echo $z["konu_durum"]==0 ? 'selected':null; ?> >Onaysiz</option>
                                </select></li>
                                <li><button type="submit" class="btn btn-primary">Mövzu düzənlə</button></li>
                            </ul>
                            </form>
                            </div>
                            <?php
                        }

                        break;

                        case "konu_sil";
                        ?>
                        <h2>Konu sil</h2>
                        <?php
                        $id=$_GET["id"];
                        $delete=$db->prepare("delete from konular where konu_id=?");
                        $sil=$delete->execute(array($id));
                        $x=$delete->rowCount();
                        if($x){
                        
                            if($sil){
                                echo '
                                <div class="alert alert-success text-success" role="alert" style="text-align:center">
                                <b>Mövzu uğurla silindi.Yönləndirilirsiz...</b>
                                </div>';
                                echo'<meta http-equiv="refresh" content="2;URL=?do=konu">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                <b>Mövzu silinərkən xəta baş verdi</b>;
                                </div>';
                                echo'<meta http-equiv="refresh" content="2;URL=?do=konu">'; 
                            }

                        }else{
                            echo '
                            <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                               <b>Mövzu tapılmadı</b>;
                            </div>';
                            echo'<meta http-equiv="refresh" content="2;URL=?do=konu">'; 

                        }
                        break;



                        case "kategori_ekle":
                        ?>
                        
                        <h2>Kateqoriya elave et</h2>
                        <?php
                        if($_POST){
                            $ktgr_adi = $_POST["kategori_adi"];
                            $ktgr_aciklama =$_POST["kategori_aciklama"];

                            if(!$ktgr_adi || !$ktgr_aciklama){
                                echo "bosluqlari doldurun";
                            }else{
                                
                            $v=$db->prepare("select *from kategoriler where kategori_adi=?");
                            $v->execute(array($ktgr_adi));
                            $k=$v->fetch(PDO::FETCH_ASSOC);
                            $x=$v->rowCount();
                            if($x){
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                <h3>"'.$ktgr_adi.'" adinda kateqoriya artıq mövcuddur. Başqa kateqoriya əlavə edin.</h3></div>';
                                
                                $url = $_SERVER['HTTP_REFERER'];  // hangi sayfadan gelindigi degerini verir.
        					    echo'<meta http-equiv="refresh" content="2;URL=".$url."">'; 
                            }else{    


                            $ekle=$db->prepare("insert into kategoriler set 
                            kategori_adi=?,
                            kategori_aciklama=?
                            ");
                            $ekle->execute(array($ktgr_adi,$ktgr_aciklama));
                            if($ekle){
                                echo '
                                <div class="alert alert-success text-success" role="alert" style="text-align:center">
                                    <b>Kateqoriya uğurla əlavə olundu.Yönləndirilirsiz...</b>
                                </div>';
            					echo'<meta http-equiv="refresh" content="2;URL=?do=kategori">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                    <b>Kateqoriya əlavə olunarkən xəta baş verdi.Yönləndirilirsiz...</b>
                                </div>';
					            echo'<meta http-equiv="refresh" content="2;URL=?do=kategori">'; 
                            }
                        }
                        }
                        }else{
                            ?>
                            <div class="admin_kategori_ekle">
                                <form action="" method="post">
                                    <ul>
                                        <li>Kateqoriya adı:</li>
                                        <li><input type="text" name="kategori_adi"></li>
                                        <li>Kateqoriya açıklaması:</li>
                                        <li><textarea name="kategori_aciklama"></textarea></li>
                                        <li><button type="submit" class="btn btn-primary" style="width:400px" >Əlavə et</button></li>
                                    </ul>
                                </form>
                            </div>
                            <?php
                        
                    }
                        

                        break;
                        case "kategori_sil":
                        ?>
                        <h2>Kateqoriyaları sil</h2>
                        <?php
                        $id=$_GET["id"];
                        $delete=$db->prepare("delete from kategoriler where kategori_id=?");
                        $sil=$delete->execute(array($id));
                        $x=$delete->rowCount();
                        if($x){
                        
                            if($sil){
                                echo '
                                <div class="alert alert-success text-success" role="alert" style="text-align:center">
                                <b>Kateqoriya uğurla silindi.Yönləndirilirsiz...</b>
                                </div>';
					            echo'<meta http-equiv="refresh" content="2;URL=?do=kategori">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                <b>Kateqoriya silinərkən xəta baş verdi</b>;
                                </div>';
					            echo'<meta http-equiv="refresh" content="2;URL=?do=kategori">'; 
                            }

                        }else{
                            echo '
                            <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                               <b>Kateqoriya tapılmadı</b>;
                            </div>';
                        }
                        break;


                        case "kategori_duzenle":
                        ?>
                        <h2>Kateqoriyaları düzənlə</h2>
                        <?php
                        $id=$_GET["id"];
                        if($_POST){

                            $k_adi=$_POST["kategori_adi"];
                            $k_aciklama=$_POST["kategori_aciklamasi"];

                            $i=$db->prepare("update kategoriler set
                                kategori_adi=?,
                                kategori_aciklama=? where kategori_id=?
                            ");
                            $i->execute(array($k_adi,$k_aciklama,$id));
                            if($i){
                                echo "ugurla yenilendi";
                            }else{
                                echo "ugursuz";
                            }

                        }else{
                        $d=$db->prepare("select *from kategoriler where kategori_id=?");
                        $d->execute(array($id));
                        $k=$d->fetch(PDO::FETCH_ASSOC);
                        $z=$d->rowCount();
                        ?>
                        <div class="admin_kategori_duzenle">
                            <form action="" method="post">
                                <ul>
                                    <li>Kateqoriya adı:</li>
                                    <li><input type="text" name="kategori_adi" value="<?php echo $k['kategori_adi']?>"></li>
                                    <li>Kateqoriya Açıklaması:</li>
                                    <li><textarea name="kategori_aciklamasi"><?php echo $k["kategori_aciklama"]?></textarea></li>
                                    <li><button type="submit" class="btn btn-primary" style="width:400px">Düzənlə</button></li>
                                </ul>
                            </form>
                        </div>
                        <?php
                        }
                        break;


                        case "yorum_sil":
                        ?>
                        <h2>Yorum sil</h2>
                        <?php
                        $id=$_GET["id"];
                        $x=$db->prepare("delete from yorumlar where yorum_id=?");
                        $t=$x->execute(array($id));
                        $k=$x->rowCount();
                        if($k){
                            if($t){
                                echo '
                                <div class="alert alert-success text-success" role="alert" style="margin-top:20px;text-align:center;font-size:25px">
                                Yorum uğurla silindi.Yönləndirilirsiz...
                                </div>';
					            echo'<meta http-equiv="refresh" content="2;URL=?do=yorum">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="margin-top:20px;text-align:center;font-size:25px">                                                            
                                Yorum silinerken xeta bas verdi.Yönləndirilirsiz...
                                </div>';
					            echo'<meta http-equiv="refresh" content="2;URL=?do=yorum">'; 
                            }
                        }else{
                            echo '
                            <div class="alert alert-danger text-danger" role="alert" style="margin-top:20px;text-align:center;font-size:25px">                            
                            Yorum tapılmadı.Yönləndirilirsiz...
                            </div>';
					        echo'<meta http-equiv="refresh" content="2;URL=?do=yorum">'; 
                        }

                        
                        break;

                        case "yorum_duzenle":
                        $id=$_GET["id"];
                        ?>
                        <h2>Yorum düzənlə</h2>
                        <?php
                        if($_POST){

                            // $muellif=$_POST["baslik"];
                            // $kategori=$_POST["kategori"];
                            // $aciklama=$_POST["aciklama"];
                            $onay=$_POST["yorum_onay"];
                            
                            
                            $update=$db->prepare("update yorumlar set yorum_onay=? where yorum_id=?");
                            $guncelle=$update->execute(array($onay,$id));
                            if($guncelle){
                                echo '
                                <div class="alert alert-success text-success" role="alert" style="text-align:center"><i class="far fa-check-circle" style="font-size:55px;"></i><h3>Yorum uğurla yeniləndi.Yönləndirilirsiz...</h3></div>';
					        	echo'<meta http-equiv="refresh" content="2;URL=?do=yorum">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                <h3>Yorum yenilənərkən xəta baş verdi.Yönləndirilirsiz...</h3></div>';
					        	echo'<meta http-equiv="refresh" content="2;URL=?do=yorum">'; 
                            }
                            
                            
                        }else{
                            $v=$db->prepare("select *from yorumlar inner join konular on konular.konu_id=yorumlar.yorum_konu_id where yorum_id=?");                            
                            $v->execute(array($id));
                            $z=$v->fetch(PDO::FETCH_ASSOC);
                            $x=$v->rowCount();
                            ?>
                            <div class="admin_konu_ekle">
                            <form action="" method="post">
                            <ul>
                                <li>Yorum müəllifi:</li>
                                <li><input type="text" value="<?php echo $z["yorum_ekleyen"]?>"name="muellif" disabled></li>
                                <li>Yorum edilən mövzu</li>
                                <li><textarea name="movzu_basliq" style="height:100px" disabled><?php echo $z["konu_baslik"];?></textarea></li>
                                <li>Yorum tərkibi:</li>
                                <li><textarea name="yorum_aciklama" disabled style="height:100px"><?php echo $z["yorum_mesaj"]?></textarea></li>
                                <li><select name="yorum_onay" id="">
                                    <option value="1" <?php echo $z["yorum_onay"]==1 ? 'selected':null; ?> >Onayli</option>
                                    <option value="0" <?php echo $z["yorum_onay"]==0 ? 'selected':null; ?> >Onaysiz</option>
                                </select></li>
                                <li><button type="submit" class="btn btn-primary">Yorumu düzənlə</button></li>
                            </ul>
                            </form>
                            </div>
                            <?php
                        }
                        break;
                        case "uye_sil":
                        ?>
                        <h2>İstifadəçi sil</h2>
                        <?php
                        $id=$_GET["id"];
                        $x=$db->prepare("delete from uyeler where uye_id=?");
                        $t=$x->execute(array($id));
                        $k=$x->rowCount();
                        if($k){
                            if($t){
                                echo '
                                <div class="alert alert-success text-success" role="alert" style="margin-top:20px;text-align:center;font-size:25px">
                                İstifadəçi uğurla silindi.Yönləndirilirsiz...
                                </div>';
					        	echo'<meta http-equiv="refresh" content="2;URL=?do=uye">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="margin-top:20px;text-align:center;font-size:25px">                                                            
                                İstifadəçi silinərkən xəta baş verdi.Yönləndirilirsiz...
                                </div>';
					        	echo'<meta http-equiv="refresh" content="2;URL=?do=uye">'; 
                            }
                        }else{
                            echo '
                            <div class="alert alert-danger text-danger" role="alert" style="margin-top:20px;text-align:center;font-size:25px">                            
                            İstifadəçi tapılmadı.Yönləndirilirsiz...
                            </div>';
					        echo'<meta http-equiv="refresh" content="2;URL=?do=uye">'; 
                        }
                        break;
                        case  "uye_duzenle":
                        $id=$_GET["id"];
                        ?>
                        <h2>İstifadəçi düzənlə</h2>
                        <?php
                        if($_POST){
                            $durum=$_POST["uye_durum"];
                            $onay=$_POST["uye_onay"];
                            
                            $update=$db->prepare("update uyeler set uye_durum=?, uye_onay=? where uye_id=?");
                            $guncelle=$update->execute(array($durum,$onay,$id));
                            if($guncelle){
                                echo '
                                <div class="alert alert-success text-success" role="alert" style="text-align:center"><i class="far fa-check-circle" style="font-size:55px;"></i><h3>İstifadəçi məlumatları uğurla yeniləndi.Yönləndirilirsiz...</h3></div>';
					     		echo'<meta http-equiv="refresh" content="2;URL=?do=uye">'; 
                            }else{
                                echo '
                                <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
                                <h3>İstifadəçi məlumatları yenilənərkən xəta baş verdi.Yönləndirilirsiz...</h3></div>';
					     		echo'<meta http-equiv="refresh" content="2;URL=?do=uye">'; 
                            }
                            

                        }else{
                            $k=$db->prepare("select *from uyeler where uye_id=?");
                            $k->execute(array($id));
                            $u=$k->fetch(PDO::FETCH_ASSOC);
                            $y=$k->rowCount();
                            ?>
                            <div class="admin_uye_duzenle">
                                <form action="" method="post">
                                <ul>
                                    <li>İstifadəçi adı:</li>
                                    <li><input type="text" value="<?php echo $u["uye_adi"]?>" name="user" disabled></li>
                                    <li>İstifadəçi email:</li>
                                    <li><input type="text" value="<?php echo $u["uye_eposta"]?>" name="user_email" disabled></li>
                                    <li>İstifadəçi Durumu:</li>
                                    <li><select name="uye_durum" id="">
                                        <option value="1" <?php echo $u["uye_durum"]==1 ? 'selected':null; ?> >Admin</option>
                                        <option value="0" <?php echo $u["uye_durum"]==0 ? 'selected':null; ?> >İstifadəçi</option>
                                    </select></li>
                                    <li>İstifadəçi Onayı:</li>
                                    <li><select name="uye_onay" id="">
                                        <option value="1" <?php echo $u["uye_onay"]==1 ? 'selected':null; ?> >Onayli</option>
                                        <option value="0" <?php echo $u["uye_onay"]==0 ? 'selected':null; ?> >Onaysiz</option>
                                    </select></li>
                                    <li><button type="submit" class="btn btn-primary mt-2" style="width:400px">İstifadəçi məlumatlarını düzənlə</button></li>
                                </ul>
                                </form>
                            </div>
                            <?php
                        }
                   

                        break;

                        default:
                         echo "<h2>Admin panel ana səhifə</h2>";
                         ?>
                        <div class="admin_container" style="width:100%;border:1px solid #ddd;display:grid;grid-template-columns:1fr 1fr;grid-template-rows:minmax(370px)">
                            <div class="adminMainContent" style="border:1px solid #ddd;margin:20px">
                            <h2>Popular Movzular</h2>
                            <!-- popular konular  start --->
                            <?php
                            $pop= $db->prepare("select *from konular where konu_durum=1 order by konu_hit desc limit 5");  //konu_tarih >= date_sub(curdate(),interval 7 day)--7gunluk interval daxilinde hit konulari tapmaq ucun
                            $pop->execute(array());
                            $v=$pop->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php
                            echo "<div class='admin_pop'><ul>";
                            foreach($v as $x){
                            ?>
                            <a id="idpop"href="index.php?islem=devam&id=<?php echo $x["konu_id"];?>">
                            <li>
                            <?php echo $x["konu_baslik"]."<br/>";?>
                            </li>
                            </a>
                            <?php
                            }
                            echo "</ul></div>";

                            //popular konular finish
                            ?>
                            </div>

                            <div class="adminMainContent" style="border:1px solid #ddd;margin:20px">
                            <h2>Təstiqlənməmiş yorumlar</h2>

                            <!-- en son yorumlar start  --->
                            <?php
                            $yorum= $db->prepare("select *from yorumlar inner join konular on konular.konu_id=yorumlar.yorum_konu_id where yorum_onay=0 order by yorum_id desc limit 5"); 
                            $yorum->execute(array());
                            $v=$yorum->fetchAll(PDO::FETCH_ASSOC);
                            $l=$yorum->rowCount();
                            if($l){
                                echo "<div class='admin_pop'><ul>";
                                foreach($v as $x){
                                ?>
                                <a id="idyrm"href="?do=yorum_duzenle&id=<?php echo $x["yorum_id"];?>">
                                <li style="background: #fac7cb!important">
                                <?php echo $x["yorum_mesaj"];?>
                                </li>
                                </a>
                                <?php
                                }
                                echo "</ul></div>";
                            }else{
                                echo '
                                    <div class="alert alert-success text-success h4 text-center" role="alert">
                                      Təstiqlənməmiş yorum mövcud deyil.
                                    </div>
                                ';
                            }
                            //  en son yorumlar son

                            ?>
                            </div>
                            <div class="adminMainContent" style="border:1px solid #ddd;margin:20px">
                            <h2>Təstiqlənməmiş istifadəçilər</h2>

                            <!-- Testiqlenmemis uyeler start  --->
                            <?php
                            $newUsers= $db->prepare("select* from uyeler where uye_onay=0 order by uye_id "); 
                            $newUsers->execute(array());
                            $v=$newUsers->fetchAll(PDO::FETCH_ASSOC);
                            $l=$newUsers->rowCount();

                            if($l){
                            echo "<div class='admin_pop'><ul>";
                            foreach($v as $x){
                            ?>
                            <a id="idyrm"href="?do=uye_duzenle&id=<?php echo $x["uye_id"];?>">
                            <li style="background: #fac7cb!important">
                            <?php echo $x["uye_adi"]."<span style='float:right'>".$x["uye_zaman"]."</span>";?>
                            </li>
                            </a>
                            <?php
                            }
                            echo "</ul></div>";
                            }else{
                                echo '
                                    <div class="alert alert-success text-success h4" role="alert" style="text-align:center">
                                      Təstiqlənməmiş istifadəçi mövcud deyil
                                    </div>
                                ';
                            }
                            ?>
                            </div>
                            <!---------- Testiqlenmemis uyeler son -->


                            <!---------- Testiqlenmemis mövzular start -->
                            <div class="adminMainContent" style="border:1px solid #ddd;margin:20px">
                            <h2>Təstiqlənməmiş mövzular</h2>

                            <?php
                            $newContent= $db->prepare("select* from konular where konu_durum=0 order by konu_id"); 
                            $newContent->execute(array());
                            $v=$newContent->fetchAll(PDO::FETCH_ASSOC);
                            $l=$newContent->rowCount();

                            if($l){
                            echo "<div class='admin_pop'><ul>";
                            foreach($v as $x){
                            ?>
                            <a id="idyrm"href="?do=konu_duzenle&id=<?php echo $x["konu_id"];?>">
                            <li>
                            <?php echo $x["konu_baslik"]."<span style='float:right'>".$x["konu_tarih"]."</span>";?>
                            </li>
                            </a>
                            <?php
                            }
                            echo "</ul></div>";
                            }else{
                                echo '
                                    <div class="alert alert-success text-success h4" role="alert" style="text-align:center">
                                      Təstiqlənməmiş mövzu mövcud deyil
                                    </div>
                                ';
                            }
                            ?>



                            </div>
                            <!---------- Testiqlenmemis mövzular son -->

                        </div>
                         <?php
                        break;
                    }
                ?>
                </div>
            </div>
            <?php
        }else{
            echo '
        <div class="alert alert-danger" role="alert" style="border:1px solid #ddd;width:500px;margin:auto;margin-top:200px;text-align:center;color:red">
        Burası yalniz adminlər üçündür!<br/>Ana səhifəyə yönləndirilirsiz...
        </div>';
		echo'<meta http-equiv="refresh" content="3;URL=index.php">'; 
        }
    }else{
        echo '
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div style="width:100%;height:100vh;display:flex;justify-content:center;align-items:center">
                <div class="modal-content"  style="width:600px;height:150px;">
                    <div class="modal-body" >
                        <div style="width:70px;height:60px;float:left;margin:30px 70px 0 20px"><i class="fas fa-exclamation-triangle" style="color:red;font-size:60px"></i></div>
                        <p style="font-size:20px;margin-top:30px;color:red;font-weight:bold;text-align:center;float:left">İstifadəçi girişi etməniz lazımdır!<br/>Ana səhifəyə yönləndirilirsiz..</p>
                    </div>
                </div> 
            </div>        
        </div>
        ';
        echo'<meta http-equiv="refresh" content="2;URL=index.php">'; 
    }
    ?>
</body>
</html>