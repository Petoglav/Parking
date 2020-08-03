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
    $naziv = "";
    $opis = "";

    if(isset($_POST["unesi"])){
		$naziv = $_POST["naziv"];
		$opis = $_POST["opis"];
		$moderator = $_POST["korisnik_id"];
		$parkiraliste = $_POST["parkiraliste_id"];
		$greska = "";
		if(!isset($naziv) || empty($naziv)){
			$greska.= "Unesite naziv Tvrtke!<br>";
			
		}
		if(empty($greska)){
			$poruka="Kreirali ste račun";
			$upit = "INSERT INTO tvrtka(`moderator_id`,`parkiraliste_id`,`naziv`,`opis`) 
			VALUES('".$moderator."','".$parkiraliste."','".$naziv."','".$opis."')";
			izvrsiUpit($veza,$upit);
			$id_nova_tvrtka = mysqli_insert_id($veza);
        }
    }
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $upit = ("DELETE FROM tvrtka WHERE tvrtka_id=$id");
        izvrsiUpit($veza,$upit);

        header("Location:admin_tvrtke.php");
    }
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $azuriraj = true;

        $upit = ("SELECT * FROM tvrtka WHERE tvrtka_id=$id");
        $rezultat = mysqli_query($veza, $upit);
        $red = mysqli_fetch_array($rezultat);

        $naziv = $red['naziv'];
        $opis = $red['opis'];
    }
    if(isset($_POST['azuriraj'])){
        $id = $_POST['id'];

        $naziv = $_POST['naziv'];
		$opis = $_POST['opis'];
		$moderator = $_POST['korisnik_id'];
		$parkiraliste = $_POST['parkiraliste_id'];

        $upit = ("UPDATE tvrtka SET naziv='$naziv', opis='$opis', moderator_id='$moderator', parkiraliste_id='$parkiraliste' WHERE tvrtka_id = $id");
        izvrsiUpit($veza,$upit);

        header("Location:admin_tvrtke.php");
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
                if(isset($greska)){
                    echo $greska;
                }
                if(!empty($id_nova_tvrtka)){
                    echo "Unesena je nova tvrtka pod ključem: ".$id_nova_tvrtka;
                }
            ?>
            </div>
            <table>
            <caption>Tvrtke:</caption>
            <thead>
                <form name="forma_tvrtka" id="forma_tvrtka" method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>"/>
                    <input type="hidden" name="id" form="forma_tvrtka" value="<?php echo $id; ?>"/>
                    <tr>
                        <td>ID: <?php echo $id; ?></td>
                        <td style="width:70px;"><input name="naziv" id="naziv" type="text" form="forma_tvrtka" placeholder="naziv" value="<?php echo $naziv; ?>" style="width:100%;" /></td>
                        <td><input name="opis" id="opis" type="text" form="forma_tvrtka" placeholder="opis" value="<?php echo $opis; ?>" style="width:100%;" /></td>
                        <td><select name="korisnik_id" id="korisnik_id" form="forma_tvrtka" style="width:100px;"/>
                        <?php
                                $upit = "SELECT * FROM korisnik WHERE tip_id='1' OR tip_id='0'";
                                $rezultat = mysqli_query($veza, $upit);
                                while ($red = mysqli_fetch_array($rezultat)){?>
                                <option value="<?=$red['korisnik_id']?>" ><?=$red['korisnicko_ime']?> </option>
                           <?php } ?>
                            </select></td>
                        <td><select name="parkiraliste_id" id="parkiraliste_id" form="forma_tvrtka"/>
                            <?php
                                $upit = "SELECT * FROM parkiraliste";
                                $rezultat = mysqli_query($veza, $upit);
                                while ($red = mysqli_fetch_array($rezultat)){?>
                                <option value="<?=$red['parkiraliste_id']?>" ><?=$red['naziv']?> </option>
                            <?php } ?>
                        </select></td>
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
                    <th>tvrtka_id</th>
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
                        <td><?php echo $red['tvrtka_id']; ?></td>
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
