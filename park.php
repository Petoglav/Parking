<?php
    session_start();
    if(isset($_GET["odjava"])){
    unset($_SESSION["id"]);
    unset($_SESSION["tip"]);
    unset($_SESSION["ime"]);
    session_destroy();
    }
?>
<?php
    require_once('baza.php');
    $veza = OtvoriBP();
?>
<?php
        if(isset($_POST['registration']) && strlen($_POST['registration'])!=0 && isset($_POST['partner'])) {
            $partnerId=$_POST['partner'];
            $carReg=$_POST['registration'];
            
            if(isset($_SESSION['id'])) {
                $upit="INSERT INTO automobil
                    (partner_id,registracija,datum_vrijeme_dolaska,datum_vrijeme_odlaska)
                    VALUES
                    ('$partnerId','$carReg', NOW(), '0000-00-00 00:00:00')";
                izvrsiUpit($veza,$upit);
        header("Location:park.php");
            }
        } else if(isset($_POST['registration']) && strlen($_POST['registration'])!=0 && !isset($_POST['partner'])){
            $carReg=$_POST['registration'];
            $upit = "SELECT partner_id 
                    FROM partner 
                    WHERE korisnik_id=".$_SESSION['aktivni_korisnik_id']." AND tvrtka_id =".$_POST['company_id'];
            list($partner) = mysqli_fetch_array(izvrsiUpit($veza, $upit));
            
            $upiti="INSERT INTO automobil
                 (partner_id,registracija,datum_vrijeme_dolaska,datum_vrijeme_odlaska)
                 VALUES
                 ('$partner','$carReg', NOW(), '0000-00-00 00:00:00')";
			izvrsiUpit($veza,$upiti);
        header("Location:park.php");
        }
    
?>

<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Parking</title>
</head>
<body>
    <?php include "header.php" ?>
<?php 
echo "Upiši registraciju automobila kako bi isti dodali na odabrano parkiralište:<br>";
?>
<form action="park.php" method="post">
    <input type="hidden" name="company_id" value="<?php echo $_GET['company_id']; ?>">
        <?php
            if ($_SESSION['tip'] == 0 || $_SESSION['tip'] == 1 && isset($_GET['company_id'])) {
                $upiti = "SELECT k.korisnik_id, k.ime, k.prezime, p.partner_id
                        FROM partner p
                        INNER JOIN korisnik k ON p.korisnik_id=k.korisnik_id
                        WHERE p.tvrtka_id =".$_GET['company_id'];
                $partners = izvrsiUpit($veza,$upiti);
                
                echo "Partner: <select name='partner'>";
                    while(list($user_id, $username, $user_lastname, $partnerId) = mysqli_fetch_array($partners)){
                        echo "<option value='$partnerId'>".$username." ".$user_lastname."</option>";
                    }
                echo "</select>";
            }
            
        ?>
    Registracija: <input type="text" name="registration"><br>
    <input type="submit">
</form>
</body>
</html>
<?php ZatvoriBP($veza); ?>
