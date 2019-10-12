<?php
if($_POST){
    $isim= $_POST["isim"];
    $sifre= $_POST["sifre"];

    if(!$isim || !$sifre){
        echo "<div style='text-align:center'><span style='color:red;font-weight:bold' >Bosluqlari doldurun</span></div>";
    }else{
        $v=$db->prepare("select *from uyeler where uye_adi=? and uye_sifre=?");
        $v->execute(array($isim,$sifre));
        $c=$v->fetch(PDO::FETCH_ASSOC);
        $x=$v->rowCount();
        if($x){
            if($c["uye_onay"]!=0){
            $_SESSION["uye"]= $c["uye_adi"];
            $_SESSION["id"]=$c["uye_id"];
            $_SESSION["eposta"]= $c["uye_eposta"];
            $_SESSION["durum"]= $c["uye_durum"];
            $_SESSION["onay"]= $c["uye_onay"];
            echo'<meta http-equiv="refresh" content="0;URL=index.php">'; 
            }else{
                echo "<div style='text-align:center'><span class='text-warning' style='font-weight:bold'>Qeydiyyatınız təstiqlənmə prosesindədir.</span></div>";
            }
        }else{
            echo "<div style='text-align:center'><span style='color:red;font-weight:bold'>Uye adi veya sifre yanlisdir</span></div>";
            }
    }
}
?>


