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
    if($_SESSION["tip"] !== "1" && $_SESSION["tip"] !== "0") {
        header("Location:prijava.php");
    }
?>
<?php
    $id = 0;
            $drazdoblje = "";
            $orazdoblje = "";
    $aktivirano = false;
    $partner = 0;
	$tvrtka = 0;
    $pid = $_SESSION["id"];
    $korime = "";
    $registracija = "";
    $id_novi_partner = "";
    $id_novi_automobil = "";
    $greska = "";
    $poruka = "";

    if(isset($_POST['partner'])){
        $aktivirano = true;
        $partner = $_POST['partner'];

        $upit = "SELECT * FROM tvrtka WHERE moderator_id = ".$partner;
        $rezultat = izvrsiUpit($veza,$upit);
        $red = mysqli_fetch_array($rezultat);
    }
    if(isset($_POST["unesi"])){
		$korime = $_POST["korisnik_id"];
        $tvrtka = $_POST['atvrtka'];
        $poruka = "Dodan je novi partner!";
        $upit = "INSERT INTO partner(`partner_id`,`korisnik_id`,`tvrtka_id`)
        VALUES((SELECT MAX( partner_id ) FROM partner C) +1,'".$korime."','".$tvrtka."')";
        izvrsiUpit($veza,$upit);
        $id_novi_partner = mysqli_insert_id($veza);
    }
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $upit = ("DELETE FROM automobil WHERE partner_id IN (SELECT partner_id FROM partner WHERE korisnik_id=$id)");
        izvrsiUpit($veza,$upit);
        $poruka = "Uklonjen je korisnik!";
        $upit = ("DELETE FROM partner WHERE korisnik_id=$id");
        izvrsiUpit($veza,$upit);
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $pid = $_GET['id'];

        $upit = ("UPDATE automobil SET datum_vrijeme_odlaska=NOW() WHERE automobil_id=$id");
        izvrsiUpit($veza,$upit);

        header("Location:moderator.php");
    }
    if(isset($_GET['adelete'])){
        $id = $_GET['adelete'];
        $poruka = "Uklonjen je automobil!";
        $upit = ("DELETE FROM automobil WHERE automobil_id=$id");
        izvrsiUpit($veza,$upit);
    }
    if(isset($_POST["runesi"])){
        $pid = $_SESSION["id"];
        $drazdoblje = $_POST['drazdoblje'];
        $orazdoblje = $_POST['orazdoblje'];
    }
    $upit = "SELECT * FROM tvrtka WHERE moderator_id = $pid OR moderator_id = ".$partner;
    $rezultat = izvrsiUpit($veza,$upit);
    $red = mysqli_fetch_array($rezultat);
?>
<!DOCTYPE html>
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Moderator</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Moderator</h1>
<div class="sadrzaj">
    <div id="obavijest">
    <?php
        if(isset($_POST['azuriraj']) || empty($greska)){
            echo "<div class='zelena'>$poruka</div>";
        }
        if(isset($greska)){
            echo $greska;
        }
        if(!empty($id_novi_automobil)){
            echo "Unesen je novi automobil pod ključem: ".$id_novi_automobil;
        }
        if(!empty($id_novi_partner)){
            echo "Unesen je novi partner";
        }
    ?>
    </div>
<?php if($_SESSION["tip"] == '0'){ ?>
    <div style="padding-bottom:10px;">
    <table>
        <thead>
        <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
        <tr>
            <td>Odabirite tvrtku moderatora:</td>
            <?php if($aktivirano == true): ?>
            <td><select name="partner" id="partner" style="width:100px;"/>
            <?php
                $upiti = "SELECT * FROM tvrtka";
                $rezultati = mysqli_query($veza, $upiti);
                while ($redi = mysqli_fetch_array($rezultati)){?>
                <option value="<?=$redi['moderator_id']?>"<?php if ($_POST['partner'] == $redi['moderator_id']) echo 'selected="selected" '; ?>> <?=$redi['naziv']?> </option>
            <?php } ?>
            </select></td>
            <?php else: ?>
            <td><select name="partner" id="partner" style="width:100px;"/>
            <?php
                $upiti = "SELECT * FROM tvrtka";
                $rezultati = mysqli_query($veza, $upiti);
                while ($redi = mysqli_fetch_array($rezultati)){?>
                <option value="<?=$redi['moderator_id']?>" ><?=$redi['naziv']?> </option>
            <?php } ?>
            </select></td>
            <?php endif; ?>
            <td><input type="submit" id="unesi" value="Unos"></td>
        </tr>
        </form>
        </thead>
    </table>
    </div>
<?php } ?>
<?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 1 || $partner == true && $greska == false && $id_novi_automobil == false) { ?>
<nav>
    <ul>
        <a href="#partneri">Partneri tvrtke</a>  |
        <a href="#automobili">Automobili partnera</a>
    </ul>
</nav>
    <table id="partneri">
    <caption>Partneri tvrtke: </caption>
        <thead>
            <div class="forma_par">
                <form name="forma_par" id="forma_par" method="POST" action=""/>
                    <tr>
                        <td><?php echo $red['naziv'];?></td>
                        <td><input type="hidden" name="atvrtka" id="unesi" value="<?=$red['tvrtka_id']?>" form="forma_par"/></td>
                        <td><select name="korisnik_id" id="korisnik_id" form="forma_par" style="width:130px;"/>
                            <?php
                            $upit = "SELECT * FROM korisnik";
                            $rezultat = mysqli_query($veza, $upit);
                            while ($red = mysqli_fetch_array($rezultat)){?>
                            <option value="<?=$red['korisnik_id']?>"><?=$red['korisnicko_ime']?></option>
                            <?php } ?>
                            </select></td>
                        <td><input type="submit" name="unesi" id="unesi" value="Unesi" form="forma_par"/></td>
                    </tr>
                </form>
            </div>
        </thead>
        <thead>
            <tr>
                <th>korisnik_id</th>
                <th>korisnicko_ime</th>
                <th>ime</th>
                <th>prezime</th>
                <th>email</th>
                <th>slika</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $pid = $_SESSION["id"];
            $upit = "SELECT * FROM partner
                        INNER JOIN korisnik ON korisnik.korisnik_id = partner.korisnik_id
                        INNER JOIN tvrtka ON tvrtka.tvrtka_id = partner.tvrtka_id
                        WHERE tvrtka.moderator_id = $pid OR tvrtka.moderator_id = ".$partner;
            $rezultat = mysqli_query($veza, $upit);

            while ($red = mysqli_fetch_array($rezultat)) { ?>
                <tr>
                    <td><?php echo $red['korisnik_id']; ?></td>
                    <td><?php echo $red['korisnicko_ime']; ?></td>
                    <td><?php echo $red['ime']; ?></td>
                    <td><?php echo $red['prezime']; ?></td>
                    <td><?php echo $red['email']; ?></td>
                    <td><a href="<?php echo $red['slika']; ?>" target="_blank"><img src="<?php echo $red['slika']; ?>"></a></td>
                    <td><a style="color:red;" href="moderator.php?delete=<?php echo $red['korisnik_id']; ?>">Ukloni</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 0 || $partner == true && $greska == false && $id_novi_automobil == false) { ?>
    <div>
        <table>
        <caption>Automobili na Parkiralištu trenutno i tijekom povijesti:</caption>
        <thead>
            <tr>
                <th>korisnik_id</th>
                <th>Automobil</th>
                <th>Datum i vrijeme dolaska</th>
                <th>Datum i vrijeme odlaska</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $upit = "SELECT tvrtka.*, partner.*, parkiraliste.*, automobil.* FROM tvrtka
                        INNER JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                        INNER JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id
                        INNER JOIN automobil ON automobil.partner_id = partner.partner_id
                        WHERE tvrtka.moderator_id = $partner
                        ORDER BY datum_vrijeme_dolaska DESC, datum_vrijeme_odlaska ASC";
            $rezultat = mysqli_query($veza, $upit);

            while ($red = mysqli_fetch_array($rezultat)){?>
                <tr>
                    <td><?php echo $red['korisnik_id'];?></td>
                    <td><?php echo $red['registracija'];?></td>
                    <td><?php echo date_format( date_create($red['datum_vrijeme_dolaska']), 'd.m.Y H:i:s' );?></td>
                    <?php if($red['datum_vrijeme_odlaska'] == "0000-00-00 00:00:00"): ?>
                    <td><a class="crven" href="parkiraliste.php?edit=<?php echo $red['automobil_id']; ?>">ODJAVA VOZILA -></a></td>
                    <?php else: ?>
                    <td><?php echo date_format( date_create($red['datum_vrijeme_odlaska']), 'd.m.Y H:i:s' );?></td>
                    <?php endif; ?>
                    <td><a style="color:red;" href="moderator.php?adelete=<?php echo $red['automobil_id']; ?>">Ukloni</a></td>
                </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
    <?php } ?>
    <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 1 ) { ?>
    <div>
        <table id="automobili">
        <caption>Automobili Partnera na Parkiralištu:</caption>
        <div>
        <thead>
            <form name="forma_razdoblje" id="forma_razdoblje" method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>"/>
            <tr>
                <td> Odaberite vremensko razdoblje odlaska:</td>
                <td><select name="orazdoblje" form="forma_razdoblje" style="width:165px;"/>
                <?php
                    $upit="SELECT tvrtka.*, partner.*, parkiraliste.*, automobil.* FROM tvrtka
                        INNER JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                        INNER JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id
                        INNER JOIN automobil ON automobil.partner_id = partner.partner_id
                        WHERE tvrtka.moderator_id = $pid OR tvrtka.moderator_id = $partner
                        ORDER BY datum_vrijeme_dolaska DESC, datum_vrijeme_odlaska ASC";
                    $rezultat = mysqli_query($veza, $upit);
                    while ($red = mysqli_fetch_array($rezultat)){?>
                    <option value="<?=$red['datum_vrijeme_odlaska']?>"
                    <?php if($orazdoblje == $red['datum_vrijeme_odlaska']) echo 'selected="selected" '; ?>>
                    <?php echo date_format( date_create($red['datum_vrijeme_odlaska']), 'd.m.Y H:i:s' );?>
                <?php } ?>
                </select></td>
                <td> Od > Do ></td>
                <td><select name="drazdoblje" form="forma_razdoblje" style="width:165px;"/>
                <?php
                    $upit="SELECT tvrtka.*, partner.*, parkiraliste.*, automobil.* FROM tvrtka
                        INNER JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                        INNER JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id
                        INNER JOIN automobil ON automobil.partner_id = partner.partner_id
                        WHERE tvrtka.moderator_id = $pid OR tvrtka.moderator_id = $partner
                        ORDER BY datum_vrijeme_dolaska DESC, datum_vrijeme_odlaska ASC";
                    $rezultat = mysqli_query($veza, $upit);
                    while ($red = mysqli_fetch_array($rezultat)){?>
                    <option value="<?=$red['datum_vrijeme_odlaska']?>"
                    <?php if($drazdoblje == $red['datum_vrijeme_odlaska']) echo 'selected="selected" '; ?>>
                    <?php if($red['datum_vrijeme_odlaska'] == "0000-00-00 00:00:00"): ?>
                    <?php echo "00.00.0000 00:00:00"; ?>
                    <?php else: ?>
                    <?php echo date_format( date_create($red['datum_vrijeme_odlaska']), 'd.m.Y H:i:s' );?>
                    <?php endif; ?></option>
                <?php } ?>
                </select></td>
                <td><input type="submit" name="runesi" id="unesi" value="Unesi" form="forma_razdoblje"/></td>
                <td></td>
            </tr>
            </form>
        </thead>
        <thead>
            <tr>
                <th>automobil_id</th>
                <th>korisnik_id</th>
                <th>Automobil</th>
                <th>Datum i vrijeme dolaska</th>
                <th>Datum i vrijeme odlaska</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $upit = "SELECT automobil_id, partner.korisnik_id, registracija, datum_vrijeme_dolaska, datum_vrijeme_odlaska FROM tvrtka, partner, automobil
                        WHERE tvrtka.tvrtka_id = partner.tvrtka_id AND partner.partner_id = automobil.partner_id
                        AND tvrtka.moderator_id = $pid AND automobil.datum_vrijeme_odlaska BETWEEN '$orazdoblje' AND '$drazdoblje' 
                        ORDER BY datum_vrijeme_dolaska ASC, datum_vrijeme_odlaska DESC";
            $rezultat = mysqli_query($veza, $upit);
            while ($red = mysqli_fetch_array($rezultat)){ ?>
                <tr>
                    <td><?php echo $red['automobil_id']?></td>
                    <td><?php echo $red['korisnik_id']?></td>
                    <td><?php echo $red['registracija']?></td>
                    <td><?php echo date_format( date_create($red['datum_vrijeme_dolaska']), 'd.m.Y H:i:s' );?></td>
                    <?php if($red['datum_vrijeme_odlaska'] == "0000-00-00 00:00:00"): ?>
                    <td><a class="crven" href="parkiraliste.php?edit=<?php echo $red['automobil_id']; ?>">ODJAVA VOZILA -></a></td>
                    <?php else: ?>
                    <td><?php echo date_format( date_create($red['datum_vrijeme_odlaska']), 'd.m.Y H:i:s' );?></td>
                    <?php endif; ?>
                    <td><a style="color:red;" href="moderator.php?adelete=<?php echo $red['automobil_id']; ?>">Ukloni</a></td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
    <?php } ?>
    <?php } ?>
</div>
<?php include "footer.php" ?>
<?php ZatvoriBP($veza); ?>
</body>
</html>
