<?php
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
    <title>O Autoru</title>
</head>
<body>
    <?php include "header.php" ?>
    <h1>O Autoru</h1>
    <div class="sadrzaj">
        <div style="float: left; text-align: left;">
            <p>Ime i Prezime: Mislav Matoković</p>
            <p>Broj indexa: S-44520/I5ta</p>
            <p>Email: mmatokovi@foi.hr</p>
            <p>Centar: SK PITUP</p>
            <p>Godina upisa: IWA 2018</p>
        </div>
        <img src="korisnici/admin.jpg" style="height: 300px; width:400px; float: right; padding-bottom:20px;">
    </div>
    <?php include "footer.php" ?>
</body>
</html>
