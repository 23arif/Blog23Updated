<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/63852fa8cf.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <title>Registration | Creative Area</title>
</head>
<body>
    <?php
    try{
        $db = new PDO("mysql:host=localhost;dbname=blog","root","");
        $db->query("SET CHARACTER SET utf8");
    }catch(PDOException $mesaj){
        echo $mesaj->getmessage();
    }
    if($_POST){
        $isim=$_POST["isim"];
        $sifre=$_POST["sifre"];
        $eposta=$_POST["eposta"];

        if(!$isim || !$sifre || !$eposta){
            echo '
            <div class="alert alert-info text-info" role="alert" style="text-align:center;margin-top:20px">            
            <b>Boşluqları doldurun.</b>
            </div>';
            $url = $_SERVER['HTTP_REFERER'];  // hangi sayfadan gelindigi degerini verir.
            echo'<meta http-equiv="refresh" content="3;URL=".$url."">'; 
        }else{
        $dublicate=$db->prepare("select *from uyeler where uye_adi=? or uye_eposta=?");
        $dublicate->execute(array($isim,$eposta));
        $same=$dublicate->fetchAll(PDO::FETCH_ASSOC);
        $sameaccount=$dublicate->rowCount();
        if($sameaccount>0){
            echo '
            <div class="alert alert-danger text-danger" role="alert" style="margin-top:20px;text-align:center">
            <b>Mail və ya İstifadəçi adı artıq mövcuddur.</b>
            </div>';
            $url = $_SERVER['HTTP_REFERER'];  // hangi sayfadan gelindigi degerini verir.
            echo'<meta http-equiv="refresh" content="3;URL=".$url."">'; 
        }else{
        $c = $db->prepare("insert into uyeler set 
          uye_adi=?,
          uye_sifre=?,
          uye_eposta=?
        ");
        $x = $c->execute(array($isim,$sifre,$eposta));
        if($x){
            echo '
            <div class="alert alert-success text-success" role="alert" style="text-align:center;margin-top:20px">
            <b><span style="font-size:25px">Uğurla qeydiyyatdan keçdiniz.</span></br></br><span class="text-info">Qeydiyyatınız 24saat ərzində təstiqlənəcək.</span></b>
            </div>
            ';
            echo'<meta http-equiv="refresh" content="4;URL=index.php">'; 
        }else{
            echo '
            <div class="alert alert-danger text-danger" role="alert" style="text-align:center">
            <b>Qeydiyyatdan keçərkən xəta baş verdi.</b>
            </div>
            ';
            $url = $_SERVER['HTTP_REFERER'];  // hangi sayfadan gelindigi degerini verir.
            echo'<meta http-equiv="refresh" content="3;URL=".$url."">'; 
        }
           
        }
    }
    }else{
        ?>

        <div class="registration_container" >
            <div class="content" style="width:400px;height:300px">
                <form method="post" action="">
                    <div class="form-group">
                        <label>Ad:</label>
                        <input type="text" name="isim" class="form-control" placeholder="Adınız...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Şifrə:</label>
                        <input type="password" name="sifre"class="form-control" id="exampleInputPassword1" placeholder="Şifrəniz....">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email:</label>
                        <input type="email" name="eposta"class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Emailiniz....">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width:100%">Qeydiyyatdan keç</button>
                </form>
            <div style="float:right" id="link1"><a href="index.php"><b><i class="fas fa-arrow-left"></i>Geri qayıt</b></a></div>    
        </div>
        </div>
        <?php
    }
    ?>
</body>
</html>