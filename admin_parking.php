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
    $poruka = "";
    $naziv = "";
    $adresa = "";
    $slika = "";
    $video = "";

    if(isset($_POST["unesi"])){
		$naziv = $_POST["naziv"];
		$adresa = $_POST["adresa"];
		$slika = $_POST["slika"];
		$video = $_POST["video"];
		$greska = "";
		if(!isset($naziv) || empty($naziv)){
			$greska.= "Unesite naziv parkiralista!<br>";
		}
		if(!isset($adresa) || empty($adresa)){
			$greska.= "Unesite adresu parkiralista!<br>";
		}
		if(!isset($slika) || empty($slika)){
			$greska.= "Unesite URL slike! <br>";
		}
		if(empty($greska)){
			$upit = "INSERT INTO parkiraliste(`naziv`,`adresa`,`slika`,`video`) 
			VALUES('".$naziv."','".$adresa."','".$slika."','".$video."')";
			izvrsiUpit($veza,$upit);
			$id_novi_park = mysqli_insert_id($veza);
        }
    }
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $poruka = "Obrisano je odabrano parkiralište!";
        $upit = ("DELETE FROM tvrtka WHERE parkiraliste_id=$id");
        izvrsiUpit($veza,$upit);
        $upit = ("DELETE FROM parkiraliste WHERE parkiraliste_id=$id");
        izvrsiUpit($veza,$upit);
    }
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $azuriraj = true;

        $upit = ("SELECT * FROM parkiraliste WHERE parkiraliste_id=$id");
        $rezultat = mysqli_query($veza, $upit);
        $red = mysqli_fetch_array($rezultat);

        $naziv = $red['naziv'];
        $adresa = $red['adresa'];
        $slika = $red['slika'];
        $video = $red['video'];
    }
    if(isset($_POST['azuriraj'])){
        $id = $_POST['id'];
        $azuriraj = true;

        $naziv = $_POST['naziv'];
		$adresa = $_POST['adresa'];
		$slika = $_POST['slika'];
		$video = $_POST['video'];
		$greska = "";

		if(!isset($naziv) || empty($naziv)){
			$greska.= "Unesite naziv parkiralista!<br>";
		}
		if(!isset($adresa) || empty($adresa)){
			$greska.= "Unesite adresu parkiralista!<br>";
		}
		if(!isset($slika) || empty($slika)){
			$greska.= "Unesite URL slike! <br>";
		}
        if(empty($greska)){
            $poruka = "Ažurirano je parkiralište!";
            $upit = ("UPDATE parkiraliste SET naziv='$naziv', adresa='$adresa', slika='$slika', video='$video' WHERE parkiraliste_id=$id");
            izvrsiUpit($veza,$upit);
        }
    }

	$upit = "SELECT * FROM parkiraliste";
	$rezultat = izvrsiUpit($veza,$upit);
?>
<!DOCTYPE html> 
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Admin Parking</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Admin Parking</h1>
<nav>
    <ul>
        <a href="admin.php">Korisnici</a>  |
        <a href="admin_parking.php">Parking</a>  |
        <a href="admin_tvrtke.php">Tvrtke</a> |
        <a href="admin_statistika.php">Statistika</a>
    </ul>
</nav>
    <div id="parkiralista">
        <div id="obavijest">
        <?php
            if(isset($_POST['azuriraj']) || empty($greska)){
                echo "<div class='zelena'>$poruka</div>";
            }
            if(isset($greska)){
                echo $greska;
            }
            if(!empty($id_novi_park)){
                    echo "<p class='zelena'>Uneseno je novo parkiraliste pod ključem: $id_novi_park</p>";
            }
        ?>
        </div>
        <table>
        <caption>Parkirališta:</caption>
        <thead>
            <form name="forma_kori" id="forma_park" method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>"/>
                <input type="hidden" name="id" form="forma_park" value="<?php echo $id; ?>"/>
                <tr>
                    <td><input name="naziv" id="naziv" type="text" form="forma_park" placeholder="naziv" value="<?php echo $naziv; ?>" style="width:100%;" /></td>
                    <td><input name="adresa" id="adresa" type="text" form="forma_park" placeholder="adresa" value="<?php echo $adresa; ?>" style="width:100%;" /></td>
                    <td><input name="slika" id="slika" type="url/image" form="forma_park" placeholder="URL slike" value="<?php echo $slika; ?>" style="width:100%;" /></td>
                    <td><input name="video" id="video" type="url" form="forma_park" placeholder="URL videja" value="<?php echo $video; ?>" /></td>
                    <?php if($azuriraj == true): ?>
                    <td><input type="submit" name="azuriraj" id="unesi" value="Ažuriraj" form="forma_park"/></td>
                    <?php else: ?>
                    <td><input type="submit" name="unesi" id="unesi" value="Unesi" form="forma_park"/></td>
                    <?php endif; ?>
                    <td><a href="admin_parking.php">Poništi</a></td>
                </tr>
            </form>
        </thead>
        <thead>
            <tr>
                <th>naziv</th>
                <th>adresa</th>
                <th>slika</th>
                <th>video</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $upit = "SELECT * FROM parkiraliste";
            $rezultat = mysqli_query($veza, $upit);
            while ($red = mysqli_fetch_array($rezultat)) { ?>
                <tr>
                    <td><?php echo "<a href='parkiraliste.php?id={$red['parkiraliste_id']}'>{$red['naziv']}</a>"; ?></td> 
                    <td><?php echo $red['adresa']; ?></td>
                    <td style="width:220px;"><?php echo "<a href='{$red['slika']}' target='_blank'>{$red['slika']}</a>"; ?></td>
                    <td style="width:120px;"><?php echo "<a href='{$red['video']}' target='_blank'>{$red['video']}</a>"; ?></td>
                    <td><a href="admin_parking.php?edit=<?php echo $red['parkiraliste_id']; ?>">Uredi</a></td>
                    <td><a class="crven" href="admin_parking.php?delete=<?php echo $red['parkiraliste_id']; ?>">Obriši</a></td>
                </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
<?php include "footer.php" ?>
</body>
</html>
<?php ZatvoriBP($veza); ?>
