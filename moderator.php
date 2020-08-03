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
    if($_SESSION["tip"] !== "2" && $_SESSION["tip"] !== "1" && $_SESSION["tip"] !== "0") {
        header("Location:prijava.php");
   }
?>
<?php
    $id = 0;
    $partner = 0;
    $pid = $_SESSION["id"];
    $korime = "";

    $upit = "SELECT * FROM tvrtka WHERE moderator_id = $pid OR moderator_id = ".$partner; 	
    $rezultat = izvrsiUpit($veza,$upit);
    $red = mysqli_fetch_array($rezultat);

    if(isset($_POST['partner'])){
        $partner = $_POST['partner'];
        $upit = "SELECT * FROM tvrtka WHERE moderator_id = $pid OR moderator_id = ".$partner; 	
        $rezultat = izvrsiUpit($veza,$upit);
        $red = mysqli_fetch_array($rezultat);
    }

    if(isset($_POST["unesi"])){
		$korime = $_POST["korisnik_id"];
        $tvrtka = $red['tvrtka_id'];
		$greska = "";
		if(!isset($korime) || empty($korime)){
			$greska.= "Unesite korisničko ime!<br>";
		}
		if(empty($greska)){
			$poruka="Kreirali ste račun";
			$upit = "INSERT INTO partner(`partner_id`,`korisnik_id`,`tvrtka_id`) 
			VALUES((SELECT MAX( partner_id ) FROM partner C) +1,'".$korime."','".$tvrtka."')";
			izvrsiUpit($veza,$upit);
			$id_novi_partner = mysqli_insert_id($veza);
        }
    }
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $upit = ("DELETE FROM partner WHERE korisnik_id=$id");
        izvrsiUpit($veza,$upit);

        header("Location:moderator.php");
    }
?>
<!DOCTYPE html> 
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Mod</title>
</head>
<body>
    <?php include "header.php" ?>
    <h1>Moderator</h1>
    <div class="sadrzaj">
    <?php if($_SESSION["tip"] == '0'){ ?>
    <div style="padding-bottom:10px;">
    <table>
        <thead>
        <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
        <tr>
            <td>Odabir moderatora:</td>
            <td><select name="partner" id="partner" style="width:100px;"/>
            <?php
                    $upiti = "SELECT * FROM korisnik WHERE tip_id='1'";
                    $rezultati = mysqli_query($veza, $upiti);
                    while ($redi = mysqli_fetch_array($rezultati)){?>
                    <option value="<?=$redi['korisnik_id']?>" ><?=$redi['korisnicko_ime']?> </option>
            <?php } ?>
            </select><td>
            <td><input type="submit" id="unesi" value="Unos"></td>
        </tr>
        </form>
        </thead>
    </table>
    </div>
    <?php } ?>
    <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 1 || $partner == true) { ?>
    <nav>
        <ul>
            <a href="#partneri">Partneri tvrtke</a>  |
            <a href="#automobili">Automobili partnera</a>
        </ul>
    </nav>
        <div id="obavijest">
        <?php
            if(isset($greska)){
                echo $greska;
            }
            if(!empty($id_novi_partner)){
                echo "Unesen je novi partner pod ključem: ".$id_novi_partner;
            }
        ?>
        </div>
        <table id="partneri">
        <caption>Partneri tvrtke: </caption>
            <thead>
                <div class="forma_par">
                    <form name="forma_par" id="forma_par" method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>"/>
                        <tr>
                            <td><?php echo $red['naziv'];?></td>
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
                        <?php echo "<td><a href='{$red['slika']} 'target='_blank'>{$red['slika']}</a></td>"; ?>
                        <td><a style="color:red;" href="moderator.php?delete=<?php echo $red['korisnik_id']; ?>">Ukloni</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div>
            <table id="automobili">
            <caption>Automobili Partnera na Parkiralištu:</caption>
            <thead>
                <tr>
                    <th>automobil_id</th>
                    <th>korisnik_id</th>
                    <th>Parkiraliste</th>
                    <th>Automobil</th>
                    <th>Datum i vrijeme dolaska</th>
                    <th>Datum i vrijeme odlaksa</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $pid = $_SESSION["id"];
                $upit = "SELECT tvrtka.*, partner.*, parkiraliste.*, automobil.* FROM tvrtka 
                            INNER JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                            INNER JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id
                            INNER JOIN automobil ON automobil.partner_id = partner.partner_id
                            WHERE tvrtka.moderator_id = $pid OR tvrtka.moderator_id = ".$partner."
                            ORDER BY datum_vrijeme_dolaska DESC, datum_vrijeme_odlaska ASC";
                $rezultat = mysqli_query($veza, $upit);

                while ($red = mysqli_fetch_array($rezultat)){ ?>
                    <tr>
                        <td><?php echo $red['automobil_id']?></td>
                        <td><?php echo $red['korisnik_id']?></td>
                        <td><?php echo "<a href='parkiraliste.php?id={$red['parkiraliste_id']}'>{$red['naziv']}</a>" ;?></td>
                        <td><?php echo $red['registracija']?></td>
                        <td><?php echo $red['datum_vrijeme_dolaska']?></td>
                        <td><?php echo $red['datum_vrijeme_odlaska']?></td>
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
