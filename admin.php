<?php
    include('baza.php');
    $veza = OtvoriBP();

	session_start();
	if(isset($_GET["odjava"])){
		unset($_SESSION["id"]);
		unset($_SESSION["tip"]);
		unset($_SESSION["ime"]);
    session_destroy();
    }
    if($_SESSION["tip"] !== '0'){
        header("Location:prijava.php");
    }
?>
<?php
    $id = 0;
    $azuriraj = false;
    $poruka="";
    $tipid = 0;
    $korime = "";
    $lozinka = "";
    $ime = "";
    $prezime = "";
    $email = "";
    $slika = 0;

    if(isset($_POST["unesi"])){
		$tipid = $_POST["tip_id"];
		$korime = $_POST["korime"];
		$lozinka = $_POST["lozinka"];
		$ime = $_POST["ime"];
		$prezime = $_POST["prezime"];
		$email = $_POST["email"];
		$slika = $_POST['slika'];
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
			$upit = "INSERT INTO korisnik(`tip_id`,`ime`,`prezime`,`email`,`korisnicko_ime`,`lozinka`,`slika`)
			VALUES('".$tipid."','".$ime."','".$prezime."','".$email."','".$korime."','".$lozinka."','".$slika."')";
			izvrsiUpit($veza,$upit);
			$id_novi_korisnik = mysqli_insert_id($veza);
        }
    }
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $poruka = "Obrisan je korisnik!";
        $upit = ("DELETE FROM partner WHERE tvrtka_id IN (SELECT tvrtka_id FROM tvrtka WHERE moderator_id=$id)");
        izvrsiUpit($veza,$upit);
        $upit = ("DELETE FROM automobil WHERE partner_id IN (SELECT partner_id FROM partner WHERE korisnik_id=$id)");
        izvrsiUpit($veza,$upit);
        $upit = ("DELETE FROM tvrtka WHERE moderator_id=$id");
        izvrsiUpit($veza,$upit);
        $upit = ("DELETE FROM partner WHERE korisnik_id=$id");
        izvrsiUpit($veza,$upit);
        $upit = ("DELETE FROM korisnik WHERE korisnik_id=$id");
        izvrsiUpit($veza,$upit);
    }
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $azuriraj = true;

        $upit = ("SELECT * FROM korisnik WHERE korisnik_id=$id");
        $rezultat = mysqli_query($veza, $upit);
        $red = mysqli_fetch_array($rezultat);

		$tipid = $red['tip_id'];
        $korime = $red['korisnicko_ime'];
        $lozinka = $red['lozinka'];
        $ime = $red['ime'];
        $prezime = $red['prezime'];
        $email = $red['email'];
        $slika = $red['slika'];
    }
    if(isset($_POST['azuriraj'])){
        $id = $_POST['id'];
        $azuriraj = true;

        $tipid = $_POST['tip_id'];
		$korime = $_POST['korime'];
		$lozinka = $_POST['lozinka'];
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$email = $_POST['email'];
        $slika = $_POST['slika'];
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
            $poruka = "Ažuriran je korisnik!";
            $upit = ("UPDATE korisnik SET tip_id='$tipid', korisnicko_ime='$korime', lozinka='$lozinka', ime='$ime', prezime='$prezime', email='$email', slika='$slika' WHERE korisnik_id=$id");
            izvrsiUpit($veza,$upit);
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
    <title>Admin Korisnici</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Admin Korisnici</h1>
<nav>
    <ul>
        <a href="admin.php">Korisnici</a>  |
        <a href="admin_parking.php">Parking</a>  |
        <a href="admin_tvrtke.php">Tvrtke</a> |
        <a href="admin_statistika.php">Statisika</a>
    </ul>
</nav>
    <div id="korisnici">
        <div id="obavijest">
        <?php
            if(isset($_POST['azuriraj']) || empty($greska)){
                echo "<div class='zelena'>$poruka</div>";
            }
            if(isset($greska)){
                echo $greska;
            }
            if(!empty($id_novi_korisnik)){
                echo "<p class='zelena'>Unesen je novi korisnik pod ključem: <a href='#footer'>$id_novi_korisnik</a></p>";
            }
        ?>
        </div>
        <table>
        <caption>Korisnici:</caption>
        <thead>
            <form name="forma_kori" id="forma_kori" method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>"/>
                <input type="hidden" name="id" form="forma_kori" value="<?php echo $id; ?>"/>
                <tr>
                    <?php if($azuriraj == true): ?>
                        <td><select name="tip_id" id="tip_id" form="forma_kori"/>
                        <?php
                            $upiti = "SELECT DISTINCT tip_id FROM korisnik";
                            $rezultati = mysqli_query($veza, $upiti);
                            while ($red = mysqli_fetch_array($rezultati)){?>
                                <option value="<?=$red['tip_id']?>"
                                <?php if($tipid == $red['tip_id']) echo 'selected="selected" '; ?>> <?=$red['tip_id']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php else: ?>
                        <td><select name="tip_id" id="tip_id" form="forma_kori"/>
                        <?php
                            $upit = "SELECT DISTINCT tip_id FROM korisnik";
                            $rezultat = mysqli_query($veza, $upit);
                            while ($red = mysqli_fetch_array($rezultat)){?>
                            <option value="<?=$red['tip_id']?>" selected="2"><?=$red['tip_id']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php endif; ?>
                    <td><input name="korime" id="korime" type="text" form="forma_kori" placeholder="korisnicko ime" value="<?php echo $korime; ?>" /></td>
                    <td><input name="lozinka" id="lozinka" type="password" form="forma_kori" placeholder="lozinka" value="<?php echo $lozinka; ?>"/></td>
                    <td><input name="ime" id="ime" type="text" form="forma_kori" placeholder="ime" value="<?php echo $ime; ?>"/></td>
                    <td><input name="prezime" id="prezime" type="text" form="forma_kori" placeholder="prezime" value="<?php echo $prezime; ?>"/></td>
                    <td><input name="email" id="email" type="email" form="forma_kori" placeholder="email" value="<?php echo $email; ?>"/></td>
                    <?php if($azuriraj == true): ?>
                    <td><select name="slika" id="slika" form="forma_kori" style="width:130px;"/>
                        <?php
                            $upiti = "SELECT DISTINCT slika FROM korisnik";
                            $rezultati = mysqli_query($veza, $upiti);
                            while ($red = mysqli_fetch_array($rezultati)){?>
                                <option value="<?=$red['slika']?>"
                                <?php if($slika == $red['slika']) echo 'selected="selected" '; ?>> <?=$red['slika']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php else: ?>
                        <td><select name="slika" id="slika" form="forma_kori" style="width:130px;"/>
                        <?php
                            $upit = "SELECT DISTINCT slika FROM korisnik";
                            $rezultat = mysqli_query($veza, $upit);
                            while ($red = mysqli_fetch_array($rezultat)){?>
                            <option value="<?=$red['slika']?>" ><?=$red['slika']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php endif; ?>
                    <?php if($azuriraj == true): ?>
                        <td><input type="submit" name="azuriraj" id="unesi" value="Ažuriraj" form="forma_kori"/></td>
                    <?php else: ?>
                        <td><input type="submit" name="unesi" id="unesi" value="Unesi" form="forma_kori"/></td>
                    <?php endif; ?>
                    <td><a href="admin.php">Poništi</a></td>
                </tr>
            </form>
        </thead>
        <thead>
            <tr>
                <th>tip_id</th>
                <th>korisnicko_ime</th>
                <th>lozinka</th>
                <th>ime</th>
                <th>prezime</th>
                <th>email</th>
                <th>slika</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $upit = "SELECT * FROM korisnik";
            $rezultat = mysqli_query($veza, $upit);

            while ($red = mysqli_fetch_array($rezultat)) { ?>
                <tr>
                    <td><?php echo $red['tip_id']; ?></td>
                    <td><?php echo $red['korisnicko_ime']; ?></td>
                    <td><?php echo $red['lozinka']; ?></td>
                    <td><?php echo $red['ime']; ?></td>
                    <td><?php echo $red['prezime']; ?></td>
                    <td><?php echo $red['email']; ?></td>
                    <td><a href="<?php echo $red['slika']; ?>" target="_blank"><img src="<?php echo $red['slika']; ?>"></a></td>
                    <td><a href="admin.php?edit=<?php echo $red['korisnik_id']; ?>">Uredi</a></td>
                    <td><a class="crven" href="admin.php?delete=<?php echo $red['korisnik_id']; ?>">Obriši</a></td>
                </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
<?php include "footer.php" ?>
</body>
</html>
<?php ZatvoriBP($veza); ?>
