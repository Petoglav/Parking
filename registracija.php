<?php
    include_once ("baza.php");
    $veza = OtvoriBP();
    $id_novi_korisnik = "";

    if(isset($_POST["submit"])){

		$korime = $_POST["korime"];
		$lozinka = $_POST["lozinka"];
		$ime = $_POST["ime"];
		$prezime = $_POST["prezime"];
		$email = $_POST["email"];
		$greska = "";
		if(!isset($korime) || empty($korime)){
			$greska.= "Unesite korisničko ime!<br>";
			
		}
		if(!isset($lozinka) || empty($lozinka)){
			$greska.= "Unesite lozinku!<br>";
			
		}
		if(!isset($ime) || empty($ime)){
			$greska.= "Unesite ime! <br>";
			
		}
		if(!isset($prezime) || empty($prezime)){
			$greska.= "Unesite prezime!<br>";
			
		}
		if(!isset($email) || empty($email)){
			$greska.= "Unesite email!<br>";
			
		}
		if(empty($greska)){
			$poruka="Kreirali ste račun";
			$upit = "INSERT INTO korisnik(`tip_id`,`ime`,`prezime`,`email`,`korisnicko_ime`,`lozinka`) 
			VALUES(2,'".$ime."','".$prezime."','".$email."','".$korime."','".$lozinka."')";
			izvrsiUpit($veza,$upit);
			$id_novi_korisnik = mysqli_insert_id($veza);
		}
	}

	$upit = "SELECT * FROM korisnik";
	$rezultat = izvrsiUpit($veza,$upit);
	
?>
<!DOCTYPE html> 
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Registracija</title>
</head>
<body>
    <?php include "header.php" ?>
    <h1>Registracija:</h1>
    <div class="forma">
        <section>
            <div id="obavijest" >
			<?php
				if(isset($greska)){
					echo $greska;
				}
				
				if(!empty($id_novi_korisnik)){
					echo "Unesen je novi korisnik pod ključem: ".$id_novi_korisnik;
				}
            ?>
            </div>
			<form name="forma" id="forma" method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                <h2>Osobni podaci:</h2>
                <hr>
                <label for="ime">Ime: </label> <input name="ime" id="ime" type="text" />
				<label for="prezime">Prezime: </label><input name="prezime" id="prezime" type="text" />
                <h2>Podaci za prijavu:</h2>
                <hr>
                <label for="email">Email: </label><input name="email" id="email" type="email" />
				<label for="korime">Korisničko ime: </label><input name="korime" id="korime" type="text" />
                <label for="loznika">Lozinka: </label><input name="lozinka" id="lozinka" type="password" />
                </br>
				<input type="submit" name="submit" id="submit" value="Unesi" />
            </form>
		</section>
    </div>
    <?php include "footer.php" ?>
</body>
</html>
