<?php
	include_once('baza.php');
	$veza = OtvoriBP();

	session_start();
	if(isset($_GET["odjava"])){
		unset($_SESSION["id"]);
		unset($_SESSION["tip"]);
		unset($_SESSION["ime"]);
    session_destroy();
	}
?>
<!DOCTYPE html> 
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Parking</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Početna</h1>
<div class="sadrzaj">
    <table>
        <caption>Odabir Parkirališta:</caption>
            <thead>
            <tr>
                <th>Parkiraliste</th>
                <th>Adresa</th>
            </tr>
            </thead>
        <tbody>
        <?php
            $upit = "SELECT * FROM parkiraliste;";
            $rezultat = mysqli_query($veza, $upit);

            while ($red = mysqli_fetch_array($rezultat)){ ?>
            <tr>
                <td><?php echo "<a href='parkiraliste.php?id={$red['parkiraliste_id']}'>{$red['naziv']}</a>";?></td>
                <td><?php echo $red['adresa']; ?></td> 
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] >= 1) { ?>
    <div>
        <table>
        <caption>Popis tvrtki kod kojih sam partner:</caption>
        <thead>
            <tr>
                <th colspan="2">Tvrtka partnera</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($_SESSION["tip"])){
            $id = $_SESSION['id'];
            $upit = "SELECT * FROM partner, tvrtka
                        WHERE tvrtka.tvrtka_id = partner.tvrtka_id AND partner.korisnik_id='$id'";
            $rezultat = mysqli_query($veza, $upit);
            }while ($red = mysqli_fetch_array($rezultat)){ ?>
                <tr>
                    <td><?php echo $red['naziv'] ?></td>
                    <td><?php echo $red['opis'] ?></td>
                </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
    <div>
        <table>
        <caption>Moji automobili:</caption>
        <thead>
            <tr>
                <th>Parkiraliste</th>
                <th>Automobil</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $id = $_SESSION['id'];
            $upit = "SELECT DISTINCT tvrtka.*, partner.*, parkiraliste.*, automobil.registracija FROM tvrtka 
                        INNER JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                        INNER JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id
                        INNER JOIN automobil ON automobil.partner_id = partner.partner_id
                        WHERE partner.korisnik_id='$id'";
            $rezultat = mysqli_query($veza, $upit);
            
            while ($red = mysqli_fetch_array($rezultat)){ ?>
                <tr>
                    <td><?php echo "<a href='parkiraliste.php?id={$red['parkiraliste_id']}'>{$red['naziv']}</a>" ;?></td>
                    <td><?php echo $red['registracija'] ?></td> 
                </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
    <?php } ?>
</div>
<?php include "footer.php" ?>
</body>
</html>
<?php ZatvoriBP($veza); ?>
