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
    $rid ="";
    $poruka = "";
    $naziv = "";
    $opis = "";
    $moderator = 0;
    $parkiraliste = 0;

    if(isset($_POST["unesi"])){
		$naziv = $_POST["naziv"];
		$opis = $_POST["opis"];
		$moderator = $_POST["korisnik_id"];
		$parkiraliste = $_POST["parkiraliste_id"];
		$greska = "";

        $upit = "SELECT * FROM tvrtka WHERE moderator_id=$moderator";
        $rezultat = mysqli_query($veza, $upit);
        $red = mysqli_fetch_array($rezultat);

		if(!isset($naziv) || empty($naziv)){
			$greska.= "Unesite naziv Tvrtke!<br>";
		}
        if (mysqli_num_rows($rezultat) >= 1) {
            $greska.= "Jedan moderator može biti zadužen za jednu firmu!<br>";
        }
		if(empty($greska)){
            $poruka = "Unesena je nova tvrtka!";
			$upit = "INSERT INTO tvrtka(`moderator_id`,`parkiraliste_id`,`naziv`,`opis`)
			VALUES('".$moderator."','".$parkiraliste."','".$naziv."','".$opis."')";
			izvrsiUpit($veza,$upit);
			$id_nova_tvrtka = mysqli_insert_id($veza);
        }
    }
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        
        $poruka = "Obrisana je odabrana tvrtka!";
        $upit = ("DELETE FROM automobil WHERE partner_id IN (SELECT partner_id FROM partner WHERE tvrtka_id=$id)");
        izvrsiUpit($veza,$upit);
        $upit = ("DELETE FROM partner WHERE tvrtka_id=$id");
        izvrsiUpit($veza,$upit);
        $upit = ("DELETE FROM tvrtka WHERE tvrtka_id=$id");
        izvrsiUpit($veza,$upit);
    }
    if(isset($_GET['edit'])){
        $azuriraj = true;
        $id = $_GET['edit'];

        $upit = ("SELECT tvrtka_id, naziv, opis, parkiraliste_id, moderator_id AS korisnik_id FROM tvrtka WHERE tvrtka_id=$id");
        $rezultat = mysqli_query($veza, $upit);
        $red = mysqli_fetch_array($rezultat);

        $naziv = $red['naziv'];
        $opis = $red['opis'];
        $moderator = $red['korisnik_id'];
        $parkiraliste = $red['parkiraliste_id'];
    }
    if(isset($_POST['azuriraj'])){
        $azuriraj = true;
        $id = $_POST['id'];

        $naziv = $_POST['naziv'];
		$opis = $_POST['opis'];
		$moderator = $_POST['korisnik_id'];
		$parkiraliste = $_POST['parkiraliste_id'];
        $greska = "";

        $upit = "SELECT * FROM tvrtka WHERE tvrtka_id=$id";
        $rezultat = mysqli_query($veza, $upit);
        $red = mysqli_fetch_array($rezultat);

		if(!isset($naziv) || empty($naziv)){
			$greska.= "Unesite naziv Tvrtke!<br>";
        }
        if(empty($greska) && $moderator == $red['moderator_id']) {
            $poruka = "Ažurirana je tvrtka!";
            $upit = ("UPDATE tvrtka SET naziv='$naziv', opis='$opis', parkiraliste_id='$parkiraliste' WHERE tvrtka_id = $id ");
            izvrsiUpit($veza,$upit);
        }
        if($moderator != $red['moderator_id']) {
            $upit = "SELECT * FROM tvrtka WHERE moderator_id=$moderator";
            $rezultat = mysqli_query($veza, $upit);
            $red = mysqli_fetch_array($rezultat);
            if (mysqli_num_rows($rezultat) >= 1) {
                $greska.= "Jedan moderator može biti zadužen za jednu firmu!<br>";
            }
        }
		if(empty($greska)){
            $poruka = "Ažurirana je tvrtka!";
            $upit = ("UPDATE tvrtka SET naziv='$naziv', opis='$opis', moderator_id='$moderator', parkiraliste_id='$parkiraliste' WHERE tvrtka_id = $id ");
            izvrsiUpit($veza,$upit);
        }
    }

	$upit = "SELECT * FROM tvrtka";
	$rezultat = izvrsiUpit($veza,$upit);
?>
<!DOCTYPE html>
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Admin Tvrtke</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Admin Tvrtke</h1>
<nav>
    <ul>
        <a href="admin.php">Korisnici</a>  |
        <a href="admin_parking.php">Parking</a>  |
        <a href="admin_tvrtke.php">Tvrtke</a> |
        <a href="admin_statistika.php">Statisika</a>
    </ul>
</nav>
    <div id="tvrtke">
        <div id="obavijest">
        <?php
            if(isset($_POST['azuriraj']) || empty($greska)){
                echo "<div class='zelena'>$poruka</div>";
            }
            if(isset($greska)){
                echo $greska;
            }
        ?>
        </div>
        <table>
        <caption>Tvrtke:</caption>
        <thead>
            <form name="forma_tvrtka" id="forma_tvrtka" method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>"/>
                <input type="hidden" name="id" form="forma_tvrtka" value="<?php echo $id; ?>"/>
                <tr>
                    <td style="width:70px;"><input name="naziv" id="naziv" type="text" form="forma_tvrtka" placeholder="naziv" value="<?php echo $naziv; ?>" style="width:100%;" /></td>
                    <td><input name="opis" id="opis" type="text" form="forma_tvrtka" placeholder="opis" value="<?php echo $opis; ?>" style="width:100%;" /></td>
                    <?php if($azuriraj == true): ?>
                        <td><select name="korisnik_id" id="korisnik_id" form="forma_tvrtka" style="width:100px;"/>
                        <?php
                            $upit = "SELECT * FROM korisnik WHERE tip_id='1'";
                            $rezultat = mysqli_query($veza, $upit);
                            while ($red = mysqli_fetch_array($rezultat)){?>
                                <option value="<?=$red['korisnik_id']?>"
                                <?php if($moderator == $red['korisnik_id']) echo 'selected="selected" '; ?>> <?=$red['korisnicko_ime']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php else: ?>
                        <td><select name="korisnik_id" id="korisnik_id" form="forma_tvrtka" style="width:100px;"/>
                        <?php
                            $upit = "SELECT * FROM korisnik WHERE tip_id='1'";
                            $rezultat = mysqli_query($veza, $upit);
                            while ($red = mysqli_fetch_array($rezultat)){?>
                            <option value="<?=$red['korisnik_id']?>" ><?=$red['korisnicko_ime']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php endif; ?>
                    <?php if($azuriraj == true): ?>
                    <td><select name="parkiraliste_id" id="parkiraliste_id" form="forma_tvrtka"/>
                        <?php
                            $upiti = "SELECT * FROM parkiraliste";
                            $rezultati = mysqli_query($veza, $upiti);
                            while ($red = mysqli_fetch_array($rezultati)){?>
                                <option value="<?=$red['parkiraliste_id']?>"
                                <?php if($parkiraliste == $red['parkiraliste_id']) echo 'selected="selected" '; ?>> <?=$red['naziv']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php else: ?>
                        <td><select name="parkiraliste_id" id="parkiraliste_id" form="forma_tvrtka"/>
                        <?php
                            $upit = "SELECT * FROM parkiraliste";
                            $rezultat = mysqli_query($veza, $upit);
                            while ($red = mysqli_fetch_array($rezultat)){?>
                            <option value="<?=$red['parkiraliste_id']?>" ><?=$red['naziv']?> </option>
                        <?php } ?>
                        </select></td>
                    <?php endif; ?>
                    <?php if($azuriraj == true): ?>
                        <td><input type="submit" name="azuriraj" id="unesi" value="Ažuriraj" form="forma_tvrtka"/></td>
                    <?php else: ?>
                        <td><input type="submit" name="unesi" id="unesi" value="Unesi" form="forma_tvrtka"/></td>
                    <?php endif; ?>
                    <td><a href="admin_tvrtke.php">Poništi</a></td>
                </tr>
            </form>
        </thead>
        <thead>
            <tr>
                <th>naziv</th>
                <th>opis</th>
                <th>moderator</th>
                <th>parkiralište</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $upit = "SELECT DISTINCT  tvrtka.*, korisnik.korisnicko_ime AS moderator_id, parkiraliste.naziv AS pnaziv FROM tvrtka
                    LEFT JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                    LEFT JOIN korisnik ON korisnik.korisnik_id = tvrtka.moderator_id
                    LEFT JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id";
            $rezultat = mysqli_query($veza, $upit);

            while ($red = mysqli_fetch_array($rezultat)) { ?>
                <tr>
                    <td><?php echo $red['naziv']; ?></td>
                    <td><?php echo $red['opis']; ?></td>
                    <td><?php echo $red['moderator_id']; ?></td>
                    <td><?php echo "<a href='parkiraliste.php?id={$red['parkiraliste_id']}'>{$red['pnaziv']}</a>"; ?></td>
                    <td><a href="admin_tvrtke.php?edit=<?php echo $red['tvrtka_id']; ?>">Uredi</a></td>
                    <td><a class="crven" href="admin_tvrtke.php?delete=<?php echo $red['tvrtka_id']; ?>">Obriši</a></td>
                </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
<?php include "footer.php" ?>
</body>
</html>
<?php ZatvoriBP($veza); ?>
