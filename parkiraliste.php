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

    $video = 0;
?>
<?php
    if(isset($_GET["id"])){
        $id = $_GET['id'];

        $upit = "SELECT * FROM parkiraliste WHERE parkiraliste.parkiraliste_id='$id'";
        $rezultat = mysqli_query($veza, $upit);

        $red = mysqli_fetch_array($rezultat);

    } else {
        header('Location: index.php');
    }
?>
<?php
    $naziv = "";
    $opis = "";
    $registracija = "";
    $partner = 0;
    $id_novi_automobil = "";
    $poruka = "";

    if(isset($_POST["unesi"])){
        $partner = $_POST["tvrtka"];
        $registracija = $_POST["registracija"];
        $greska = "";

        if(!isset($registracija) || empty($registracija)){
            $greska.= "Unesite Registraciju!<br>";

        }
        if(empty($greska)){
            $poruka="Dodali ste automobil";
            $upit = "INSERT INTO automobil(`partner_id`,`registracija`,`datum_vrijeme_dolaska`,`datum_vrijeme_odlaska`)
            VALUES('".$partner."','".$registracija."',NOW(),'0000-00-00 00:00:00')";
            izvrsiUpit($veza,$upit);
            $id_novi_automobil = mysqli_insert_id($veza);
        }
    }
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $pid = $_GET['id'];

        $upit = ("UPDATE automobil SET datum_vrijeme_odlaska=NOW() WHERE automobil_id=$id");
        izvrsiUpit($veza,$upit);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

	$upit = "SELECT * FROM tvrtka";
	$rezultat = izvrsiUpit($veza,$upit);
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
        <div id="obavijest">
        <?php
            if(isset($greska)){
                echo $greska;
            }
            if(!empty($id_novi_automobil)){
                echo "<p class='zelena'>Unesen je automobil pod ključem:  <a href='#automobil'>$id_novi_automobil</a></p>";
            }
        ?>
        </div>
<h1>Parkiralište: <?php echo "{$red['naziv']}" ?></h1>
<div class="sadrzaj">
    <img src="<?php echo $red['slika']; ?>" style="width: 800px; height: 450px;">
    <?php if($red["video"] == true): ?>
    <hr>
    <a href="<?php echo $red['video']; ?>" target="_blank" style="border:1px solid black; padding: 2px;"><button id="unesi">VIDEO PARKIRALIŠTA</button></a>
    <?php endif; ?>
    <div>
    <table>
    <caption>Tvrtke u korištenju:</caption>
    <thead>
        <tr>
            <th>Naziv</th>
            <th>Opis</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $upit = "SELECT * FROM tvrtka WHERE parkiraliste_id='$id'";
        $rezultat = mysqli_query($veza, $upit);

        while ($red = mysqli_fetch_array($rezultat)){?>
            <tr>
                <td><?php echo $red['naziv'];?></td>
                <td><?php echo $red['opis'];?></td>
            </tr>
    <?php } ?>
    </tbody>
    </table>
    </div>
    <a style="float:left; text-decoration: underline; padding:10px" href="index.php">&larr; Povrtak na Odabir Parkirališta</a>
    <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] <= 1) { ?>
    <a style="float:right; text-decoration: underline; padding:10px" href="moderator.php">Pregledaj Partnere Parkirališta Tvrtke &rarr;</a>
    <?php } ?>
    <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 2) { ?>
    <a style="float:right; text-decoration: underline; padding:10px" href="index.php"> Povrtak na Pregled Partner Tvrtka &rarr;</a>
    <?php } ?>
     <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] >= 1) { ?>
        <table>
        <caption>Dodaj Automobil na Parkiralište:</caption>
        <div>
        <thead>
            <form name="forma_auto" id="forma_auto" method="POST" action=""/>
            <tr>
                <td><select name="tvrtka" form="forma_auto" style="width:130px;"/>
                <?php
                    $upit="SELECT tvrtka.tvrtka_id, partner.partner_id, tvrtka.parkiraliste_id, partner.korisnik_id, tvrtka.naziv FROM partner
                            INNER JOIN tvrtka ON tvrtka.tvrtka_id=partner.tvrtka_id
                            WHERE korisnik_id=".$_SESSION['id']." AND parkiraliste_id='$id'";
                    $rezultat = mysqli_query($veza, $upit);
                    while ($red = mysqli_fetch_array($rezultat)){?>
                    <option value="<?=$red['partner_id']?>"><?=$red['naziv']?></option>
                <?php } ?>
                </select></td>
                <td><input type="text" name="registracija" id="registracija" required="required" form="forma_auto" placeholder="XX-1234-XX" value="<?php echo $registracija; ?>"/></td>
                <td><input type="submit" name="unesi" id="unesi" value="Unesi" form="forma_auto"/></td>
            </tr>
            </form>
        </thead>
        <thead>
            <tr>
                <th>Tvrtka partnera</th>
                <th>Automobil</th>
                <th>Datum i vrijeme dolaska</th>
                <th>Datum i vrijeme odlaksa</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sid = $_SESSION['id'];
            $upit = "SELECT tvrtka.*, partner.*, parkiraliste.*, automobil.registracija, automobil.datum_vrijeme_dolaska,automobil.automobil_id, automobil.datum_vrijeme_odlaska
                        FROM tvrtka
                        INNER JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                        INNER JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id
                        INNER JOIN automobil ON automobil.partner_id = partner.partner_id
                        WHERE partner.korisnik_id='$sid' AND parkiraliste.parkiraliste_id='$id'
                        ORDER BY datum_vrijeme_dolaska DESC, datum_vrijeme_odlaska ASC;";
            $rezultat = mysqli_query($veza, $upit);

            while ($red = mysqli_fetch_array($rezultat)){?>
                <tr>
                    <td><?php echo $red['opis'];?></td>
                    <td><?php echo $red['registracija'];?></td>
                    <td><?php echo date_format( date_create($red['datum_vrijeme_dolaska']), 'd.m.Y H:i:s' );?></td>
                    <?php if($red['datum_vrijeme_odlaska'] == "0000-00-00 00:00:00"): ?>
                    <td><a class="zelena" href="parkiraliste.php?edit=<?php echo $red['automobil_id']; ?>">ODJAVA VOZILA -></a></td>
                    <?php else: ?>
                    <td><?php echo date_format( date_create($red['datum_vrijeme_odlaska']), 'd.m.Y H:i:s' );?></td>
                    <?php endif; ?>
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
