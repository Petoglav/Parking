<header>
    <nav>
        <ul style="float:left; margin-left: 100px; margin-top: 10px;">
            <a href="index.php">Početna</a> |
            <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] <= 1) { ?>
            <a href="moderator.php" class="veza">Moderator</a> |
            <?php } ?>
            <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 0) { ?>
            <a href="admin.php" class="veza">Admin</a> |
            <?php } ?>
            <a href="o_autoru.php">O autoru</a>
        </ul>
        <ul style="float:right; margin-right: 10px; margin-top: 10px;">
            <?php if(!isset($_SESSION["id"])) { ?>
            <a href="prijava.php">Prijava</a> |
            <?php 	}else{	?>
            <a href="prijava.php?odjava=1">Odjava</a> |
            <?php } ?>
            <?php if(!isset($_SESSION["id"])) { ?>
            <a href="registracija.php">Registracija</a>
            <?php	}else{ echo "Dobro došli, {$_SESSION['ime']}";} ?>
        </ul>
    <nav>
</header>
