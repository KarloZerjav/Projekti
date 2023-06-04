<?php
session_start(); // Pokreće ili obnavlja sesiju

// Provjeri je li zahtjev za odjavom
if (isset($_GET["odjava"])) {
    // Obriši sve vrijednosti iz sesije
    session_unset();
    // Preusmjeri na početnu stranicu
    header("Location: index.php");
    exit;
}

// Provjeri je li korisnik prijavljen i prikaži odjavu u navigacijskom izborniku
$odjavaLink = "";
if (isset($_SESSION["username"])) {
    $odjavaLink = "<li><a href='prijava.php?odjava=1'>Odjava</a></li>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
        crossorigin="anonymous"></script>
    <title>Lista zagrebačkih fakulteta</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><img src="logo.png" class="logo"></li>
                <li><h2>Lista zagrebačkih fakulteta</h2></li>
                <?php echo $odjavaLink; ?>
                <?php if (!isset($_SESSION["username"])) { ?>
                    <li><a href="prijava.php">Prijava</a></li>
                <?php } ?>
                <li><a href="popis.php">Popis</a></li>
                <li><a href="index.php">Početna</a></li>
            </ul>
        </nav>
    </header>

    <main class="srednji">
        <!-- Sadržaj početne stranice -->
        <section id="dobrodoslica">
            <div class="tekst">
            <h1 class="naslov">Dobrodošli na listu zagrebačkih fakulteta!</h1>
            <p>
                Na ovoj web stranici možete pronaći sve potrebne informacije o fakultetima koji se nalaze u Zagrebu. 
                Bez obzira jeste li srednjoškolac koji planira upis na fakultet, student koji traži dodatne informacije o 
                određenom fakultetu ili jednostavno znatiželjni o obrazovnim mogućnostima u Zagrebu, ovdje ćete pronaći sve što Vam treba.
            </p>
            <p>
                Svaki fakultet na našoj listi dolazi s obiljem korisnih podataka. Možete pronaći adrese fakulteta i kontakt informacije. 
                Također ćete naći informacije o dekanu, OIB faksa i njegov matični broj. Osim toga, bit će Vam dostupne 
                i informacije o smjerovima koje svaki fakultet nudi, kao i o trajanju tih smjerova.
            </p>
            <p>
                Naš cilj je pružiti Vam sveobuhvatne i točne informacije kako biste mogli donijeti informirane odluke 
                o svojem obrazovanju. Neovisno o tome jeste li zainteresirani za prirodne znanosti, društvene znanosti, 
                tehničke discipline ili umjetnost i humanistiku, na našoj listi pronaći ćete fakultet koji Vam odgovara.
            </p>
            <p>
                Koristite navigacijsku traku na vrhu stranice kako biste istražili ostale dijelove naše web stranice. 
                Na stranici "Popis" možete pronaći cjelovit popis svih fakulteta u Zagrebu, zajedno s dodatnim informacijama. 
            </p>
            <p>
                Hvala Vam što ste posjetili Listu zagrebačkih fakulteta. Nadamo se da će Vam naše informacije biti od 
                pomoći i da ćete pronaći fakultet koji će ispuniti vaše obrazovne i karijerne ciljeve. Slobodno nas kontaktirajte 
                ako imate bilo kakva pitanja ili trebate dodatne informacije.
            </p>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2023 Karlo Žerjav</p>
    </footer>
</body>

</html>
