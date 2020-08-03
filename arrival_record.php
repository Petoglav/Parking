
<?php
	include("header.php");
	$bp=connectToDatabase();
?>
<?php
        if(isset($_POST['registration']) && strlen($_POST['registration'])!=0 && isset($_POST['partner'])) {
            $partnerId=$_POST['partner'];
            $carReg=$_POST['registration'];
            
            if(isset($_SESSION['aktivni_korisnik'])) {
                $sql="INSERT INTO automobil
                    (partner_id,registracija,datum_vrijeme_dolaska,datum_vrijeme_odlaska)
                    VALUES
                    ('$partnerId','$carReg', NOW(), '0000-00-00 00:00:00')";
                executeQuery($bp, $sql);
                header("Location:partners_list.php");
            }
        } else if(isset($_POST['registration']) && strlen($_POST['registration'])!=0 && !isset($_POST['partner'])){
            $carReg=$_POST['registration'];
            $sql = "SELECT partner_id 
                    FROM partner 
                    WHERE korisnik_id=".$_SESSION['aktivni_korisnik_id']." AND tvrtka_id =".$_POST['company_id'];
            list($partner) = mysqli_fetch_array(executeQuery($bp, $sql));
            
            $sqli="INSERT INTO automobil
                 (partner_id,registracija,datum_vrijeme_dolaska,datum_vrijeme_odlaska)
                 VALUES
                 ('$partner','$carReg', NOW(), '0000-00-00 00:00:00')";
            executeQuery($bp, $sqli);
            header("Location:partners_list.php");
        }
    
?>

<html>
<body>
<?php 
echo "Upiši registraciju automobila kako bi isti dodali na odabrano parkiralište:<br>";
?>
<form action="arrival_record.php" method="post">
    <input type="hidden" name="company_id" value="<?php echo $_GET['company_id']; ?>">
        <?php
            if ($_SESSION['aktivni_korisnik_tip'] == 0 || $_SESSION['aktivni_korisnik_tip'] == 1 && isset($_GET['company_id'])) {
                $sql = "SELECT k.korisnik_id, k.ime, k.prezime, p.partner_id
                        FROM partner p
                        INNER JOIN korisnik k ON p.korisnik_id=k.korisnik_id
                        WHERE p.tvrtka_id =".$_GET['company_id'];
                $partners = executeQuery($bp, $sql);
                
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

	
<?php
	closeConnection($bp);
	include("footer.php");
?>







