<?php
	session_start();
	if(isset($_GET["odjava"])){
		unset($_SESSION["id"]);
		unset($_SESSION["tip"]);
		unset($_SESSION["ime"]);
    session_destroy();
	}
	
	if(isset($_POST["submit"]))
	{
		$korime = $_POST["korime"];
		if(isset($korime) && 
			isset($_POST["lozinka"]) &&
			!empty($korime) &&
			!empty($_POST["lozinka"]))
		{
			include_once("baza.php");
			$veza = OtvoriBP();
			$upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '".$korime."' AND lozinka = '".$_POST["lozinka"]."'";
			$rezultat = izvrsiUpit($veza,$upit);
			$logiran=false;
			while($row = mysqli_fetch_array($rezultat))
			{
				$_SESSION["id"] = $row[0];
				$_SESSION["ime"] = $row["ime"];
				$_SESSION["prezime"] = $row["prezime"];
				$_SESSION["tip"] = $row["tip_id"];
				$logiran=true;
			}
			ZatvoriBP($veza);
			if($logiran)
			{
				header("Location:index.php");
				exit();
			}
			else{
				$greska = "Lozinka i Korisničko ime se ne podudaraju!";
			}
		}
	}
?>
<!DOCTYPE html> 
<html lang="hr">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Prijava</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Prijava:</h1>
<div class="forma">
    <section>
    <div id="obavijest">
    <?php
        if(isset($greska)){
            echo $greska;
        }
    ?>
    </div>
    <form name="forma" id="forma" method="POST" action="prijava.php">
        <h2>Podaci za prijavu:</h2>
        <hr>
        <label for="korime">Korisničko ime: </label><input name="korime" type="text" />
        <label for="lozinka">Lozinka: </label><input name="lozinka" type="password" />
        <br/>
        <input name="submit" type="submit" id="submit" value="Unesi" />
    </form>
    </section>
</div>
<?php include "footer.php" ?>
</body>
</html>
