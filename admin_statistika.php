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
<!DOCTYPE html> 
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Admin Statistika</title>
</head>
<body>
    <?php include "header.php" ?>
    <h1>Admin Statistika</h1>
    <div class="sadrzaj">
    <nav>
        <ul>
            <a href="admin.php">Korisnici</a>  |
            <a href="admin_parking.php">Parking</a>  |
            <a href="admin_tvrtke.php">Tvrtke</a> |
            <a href="admin_statistika.php">Statisika</a>
        </ul>
    </nav>
        <div id="statistika">
            <table>
            <caption>Prosječno vrijeme zadržavanja automobila na parkiralištu:</caption>
            <thead>
                <tr>
                    <th>Naziv Parkirališta</th>
                    <th>Vrijeme zadržavanja automobila</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $upit="SELECT tvrtka.parkiraliste_id, parkiraliste.naziv, (TO_SECONDS(datum_vrijeme_odlaska)-TO_SECONDS(datum_vrijeme_dolaska))/60/COUNT(*) AS prosjek 
                        FROM automobil, tvrtka, partner, parkiraliste WHERE tvrtka.tvrtka_id = partner.tvrtka_id 
                        AND partner.partner_id = automobil.partner_id 
                        AND tvrtka.parkiraliste_id = parkiraliste.parkiraliste_id 
                        AND automobil.datum_vrijeme_odlaska <> '0000-00-00 00:00:00' 
                        GROUP BY tvrtka.parkiraliste_id";
                $rezultat = mysqli_query($veza, $upit);

                while ($red = mysqli_fetch_array($rezultat)) { ?>
                    <tr>
                        <td><?php echo $red['naziv']; ?></td>
                        <td><?php echo $red['prosjek']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
        <div> 
            <table>
            <caption>Prosječno vrijeme zadržavanja automobila tvrtke:</caption>
            <thead>
                <tr>
                    <th>tvrtka</th>
                    <th>Opis</th>
                    <th>Vrijeme zadržavanja automobila</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $upit="SELECT tvrtka.tvrtka_id, tvrtka.opis, tvrtka.naziv, (TO_SECONDS(datum_vrijeme_odlaska)-TO_SECONDS(datum_vrijeme_dolaska))/60/COUNT(*) AS prosjek
                        FROM automobil, tvrtka, partner 
                        WHERE tvrtka.tvrtka_id = partner.tvrtka_id 
                        AND partner.partner_id = automobil.partner_id  
                        AND automobil.datum_vrijeme_odlaska <> '0000-00-00 00:00:00' 
                        GROUP BY naziv";
                $rezultat = mysqli_query($veza, $upit);

                while ($red = mysqli_fetch_array($rezultat)) { ?>
                    <tr>
                        <td><?php echo $red['naziv']; ?></td>
                        <td><?php echo $red['opis']; ?></td>
                        <td><?php echo $red['prosjek']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>
</html>
<?php ZatvoriBP($veza); ?>
