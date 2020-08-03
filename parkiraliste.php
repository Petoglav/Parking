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

    if(isset($_POST["unesi"])){
		$partner = $_POST["partner_id"];
		$registracija = $_POST["registracija"];
		$greska = "";
		if(!isset($registracija) || empty($registracija)){
			$greska.= "Unesite Registraciju!<br>";
		}
		if(empty($greska)){
			$poruka="Dodali ste Automobil";
			$upit = "INSERT INTO automobil(`partner_id`,`registracija`,`datum_vrijeme_dolaska`,`datum_vrijeme_odlaska`) 
			VALUES('$partner','$registracija',GETDATE(),NULL)";
			izvrsiUpit($veza,$upit);
			$id_novi_automobil = mysqli_insert_id($veza);
        }
        header("Location:parkiraliste.php?id=1");
    }
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $pid = $_GET['id'];
        $sad = "NOW()";

        $upit = ("UPDATE automobil SET datum_vrijeme_odlaska='$sad' WHERE automobil_id=$id");
        izvrsiUpit($veza,$upit);

        header("Location:parkiraliste.php?id=1");
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
    <h1>Parkiralište: <?php echo "{$red['naziv']}" ?></h1>
    <div class="sadrzaj">
        <img src="<?php echo $red['slika']; ?>">
        <?php
            if($red["video"] == true):
            $url = $red["video"];
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
            $uid = $matches[1]; 
        ?>
        <hr>
        <iframe id="ytplayer" type="text/html" width="800px" height="450px" src="https://www.youtube.com/embed/<?php echo $uid ?>?rel=0&showinfo=0&color=white&iv_load_policy=3" frameborder="0" allowfullscreen></iframe> 
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
        <a style="float:left; text-decoration: underline;" href="index.php">&larr; Povrtak na Odabir Parkirališta</a>
        <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] <= 2 ) { ?>
        <div class="automobil">
            <div id="obavijest">
            <?php
                if(isset($greska)){
                    echo $greska;
                }
                if(!empty($id_novi_automobil)){
                    echo "Unesen je automobil pod ključem: ".$id_novi_automobil;
                }
            ?>
            </div>
            <table>
            <caption>Dodaj Automobil na Parkiralište:</caption>
            <div>
                <thead>
                    <form name="forma_auto" id="forma_auto" method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>"/>
                    <tr>
                        <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] <= 1) : ?>
                        <td><select name="partner_id" id="partner_id" form="forma_auto" style="width:130px;"/>
                        <?php
                            $upit="SELECT tvrtka.tvrtka_id, korisnik.korisnik_id, korisnik.korisnicko_ime, partner.partner_id FROM partner
                                    INNER JOIN tvrtka ON tvrtka.tvrtka_id=partner.tvrtka_id
                                    INNER JOIN korisnik ON partner.korisnik_id=korisnik.korisnik_id
                                    WHERE tvrtka.parkiraliste_id='$id'";
                            $rezultat = mysqli_query($veza, $upit);
                            while ($red = mysqli_fetch_array($rezultat)){?>
                            <option value="<?=$red['partner_id']?>"><?=$red['korisnicko_ime'],$red['partner_id']?></option>
                        <?php } ?>
                        </select></td>
                        <?php else:
                            $upit = "SELECT partner_id FROM partner WHERE korisnik_id=".$_SESSION['id']." AND tvrtka_id =.$tvrtka";
                            list($partner) = mysqli_fetch_array(izvrsiUpit($veza, $upit));?>
                            <input type="hidden" name="partner" value="<?php echo $partner; ?>">
                        <?php endif; ?>
                        <td><input type="text" id="registracija" name="registracija" form="forma_auto" placeholder="XX-XXXX-XX"/></td>
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
                $upit = "SELECT tvrtka.*, partner.*, parkiraliste.*, automobil.registracija, automobil.datum_vrijeme_dolaska, automobil.datum_vrijeme_odlaska FROM tvrtka 
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
                        <td><?php echo $red['datum_vrijeme_dolaska'];?></td>
                    <?php if($red['datum_vrijeme_odlaska'] == "0000-00-00 00:00:00"): ?>
                        <td><a class="zelena" href="parkiraliste.php?edit=<?php echo $red['automobil_id']; ?>">ODJAVA VOZILA -></a></td>
                    <?php else: ?>
                        <td><?php echo $red['datum_vrijeme_odlaska'];?></td>
                    <?php endif; ?>
                    </tr>
            <?php } ?>
            </tbody>
            </table>
        </div>
        <?php } ?>
        <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] <= 1) { ?>
        <div>
            <table>
            <caption>Automobili na Parkiralištu trenutno i tijekom povijesti:</caption>
            <thead>
                <tr>
                    <th>partner_id</th>
                    <th>Tvrtka partnera</th>
                    <th>Parkiraliste</th>
                    <th>Automobil</th>
                    <th>Datum i vrijeme dolaska</th>
                    <th>Datum i vrijeme odlaska</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $upit = "SELECT tvrtka.*, partner.*, parkiraliste.*, automobil.* FROM tvrtka 
                            INNER JOIN partner ON partner.tvrtka_id = tvrtka.tvrtka_id
                            INNER JOIN parkiraliste ON parkiraliste.parkiraliste_id = tvrtka.parkiraliste_id
                            INNER JOIN automobil ON automobil.partner_id = partner.partner_id
                            WHERE parkiraliste.parkiraliste_id = $id
                            ORDER BY datum_vrijeme_dolaska DESC, datum_vrijeme_odlaska ASC";
                $rezultat = mysqli_query($veza, $upit);

                while ($red = mysqli_fetch_array($rezultat)){?>
                    <tr>
                        <td><?php echo $red['partner_id'];?></td>
                        <td><?php echo $red['opis'];?></td>
                        <td><?php echo $red['naziv'];?></td>
                        <td><?php echo $red['registracija'];?></td>
                        <td><?php echo $red['datum_vrijeme_dolaska'];?></td>
                    <?php if($red['datum_vrijeme_odlaska'] == "0000-00-00 00:00:00"): ?>
                        <td class="zelena">TRENUTNO</td>
                    <?php else: ?>
                        <td><?php echo $red['datum_vrijeme_odlaska'];?></td>
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
