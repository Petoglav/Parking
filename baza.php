<?php

define("BP_posluzitelj","localhost");
define("BP_baza","iwa_2018_sk_projekt");
define("BP_korisnik","iwa_2018");
define("BP_lozinka","foi2018");

function OtvoriBP(){
	$veza = mysqli_connect(BP_posluzitelj,BP_korisnik,BP_lozinka);

	if(!$veza){
		echo "GREŠKA:
		Problem sa spajanjem u datoteci baza.php funkcija otvoriVezu:
		".mysqli_connect_error();
	}
	mysqli_select_db($veza, BP_baza);

	if(mysqli_error($veza)!==""){
		echo "GREŠKA:
		Problem sa odabirom baze u baza.php funkcija otvoriVezu:
		".mysqli_error($veza);
	}
	mysqli_set_charset($veza,"utf8");

	if(mysqli_error($veza)!==""){
		echo "GREŠKA:
		Problem sa odabirom baze u baza.php funkcija otvoriVezu:
		".mysqli_error($veza);
	}
	return $veza;
}
function izvrsiUpit($veza, $upit){

	$rezultat = mysqli_query($veza, $upit);

	if(mysqli_error($veza)!==""){
		echo "GREŠKA:
		Problem sa upitom: ".$upit." : u datoteci baza.php funkcija izvrsiUput:
		".mysqli_error($veza);
	}
	return $rezultat;
}
function ZatvoriBP($veza){
	mysqli_close($veza);
}
?>
