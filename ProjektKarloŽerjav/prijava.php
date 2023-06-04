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
    <title>Lista zagrebačkih fakulteta - Prijava</title>
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

    <main>
        <section class="prijava">
            <form action="" method="post">
                <h3 style="color:white;">Prijavi se</h3>
                <label for="username">Korisničko ime</label>
                <input type="text" placeholder="Korisničko ime" name="username">
                <label for="password">Lozinka</label>
                <input type="password" placeholder="Lozinka" name="password">
                <input class="gumb" name="submit" type="submit" value="Prijavi se">
            </form>
            <?php
            // Provjeri je li zahtjev metodom POST
            if (isset($_POST["submit"])) {
                // Uneseni podaci iz forme
                $korisnickoIme = $_POST["username"];
                $lozinka = $_POST["password"];

                // Učitaj XML datoteku
                $xml = simplexml_load_file("admin.xml");

                // Pronađi korisnika u XML-u
                $korisnik = $xml->korisnik;

                // Provjeri korisničko ime i lozinku
                if ($korisnik->korisnickoime == $korisnickoIme && $korisnik->lozinka == $lozinka) {
                    $_SESSION["username"] = $korisnickoIme;
                    echo "<p class='poruka'>Prijavljeni ste kao admin</p>";
                    // Ažuriraj odjavu u navigacijskom izborniku
                    $odjavaLink = "<li><a href='prijava.php?odjava=1'>Odjava</a></li>";
                    header("Location: prijava.php");
                } else {
                    // Ako nismo pronašli podudaranje, ispiši grešku
                    echo "<p class='poruka'>Greška: Pogrešno korisničko ime ili lozinka</p>";
                }
            }
            ?>
        </section>
    </main>

    <footer>
        <p>© 2023 Karlo Žerjav</p>
    </footer>
</body>

</html>

