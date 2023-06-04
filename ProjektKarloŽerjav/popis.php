<?php
session_start();
$xml = simplexml_load_file('fakulteti.xml');

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
    $korisnikPrijavljen = true;
} else {
    $korisnikPrijavljen = false;
}

// Funkcija za spremanje promjena u XML
function spremiPromjene($xml)
{
    $xml->asXML('fakulteti.xml');
}

// Provjeri je li korisnik prijavljen i ima li prava za uređivanje
if ($korisnikPrijavljen) {
    if (isset($_POST["spremi"])) {
        // Spremi promjene u XML
        foreach ($xml->fakultet as $fakultet) {
            $id = (int)$fakultet['id'];
            $fakultet->Dekan = isset($_POST["dekan_$id"]) ? $_POST["dekan_$id"] : $fakultet->Dekan;
            $fakultet->NadredenaUstanova = isset($_POST["nadredena_ustanova_$id"]) ? $_POST["nadredena_ustanova_$id"] : $fakultet->NadredenaUstanova;
            $fakultet->Vrsta = isset($_POST["vrsta_$id"]) ? $_POST["vrsta_$id"] : $fakultet->Vrsta;
            $fakultet->Adresa = isset($_POST["adresa_$id"]) ? $_POST["adresa_$id"] : $fakultet->Adresa;
            $fakultet->MaticniBroj = isset($_POST["maticni_broj_$id"]) ? $_POST["maticni_broj_$id"] : $fakultet->MaticniBroj;
            $fakultet->OIB = isset($_POST["oib_$id"]) ? $_POST["oib_$id"] : $fakultet->OIB;
            $fakultet->Email = isset($_POST["email_$id"]) ? $_POST["email_$id"] : $fakultet->Email;
        }
        spremiPromjene($xml);
        $poruka = "Uspješno spremljeno!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <title>Lista zagrebačkih fakulteta - Popis</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><img src="logo.png" class="logo"></li>
                <li>
                    <h2>Lista zagrebačkih fakulteta</h2>
                </li>
                <?php echo $odjavaLink; ?>
                <?php if (!$korisnikPrijavljen) { ?>
                    <li><a href="prijava.php">Prijava</a></li>
                <?php } ?>
                <li><a href="popis.php">Popis</a></li>
                <li><a href="index.php">Početna</a></li>
            </ul>
        </nav>
    </header>

    <main class="tijelo">
        <div class="container mt-5">
            <?php if (isset($poruka)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $poruka; ?>
                </div>
            <?php endif; ?>
            <div class="accordion" id="accordionExample">
                <?php foreach ($xml->fakultet as $index => $fakultet) : ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index; ?>" aria-expanded="false" aria-controls="collapse<?php echo $index; ?>">
                                <?php echo $fakultet->Naziv; ?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <h3><?php echo $fakultet->Naziv; ?></h3>
                                <br>
                                <?php if ($korisnikPrijavljen) { ?>
                                    <form class="forma" method="POST" action="">
                                        <strong>Dekan:</strong> <input type="text" name="dekan_<?php echo $fakultet->attributes()->id; ?>" value="<?php echo isset($_POST["dekan_$fakultet->attributes()->id"]) ? $_POST["dekan_$fakultet->attributes()->id"] : $fakultet->Dekan; ?>"><br>
                                        <strong>Nadređena ustanova:</strong> <input type="text" name="nadredena_ustanova_<?php echo $fakultet->attributes()->id; ?>" value="<?php echo isset($_POST["nadredena_ustanova_$fakultet->attributes()->id"]) ? $_POST["nadredena_ustanova_$fakultet->attributes()->id"] : $fakultet->NadredenaUstanova; ?>"><br>
                                        <strong>Vrsta:</strong> <input type="text" name="vrsta_<?php echo $fakultet->attributes()->id; ?>" value="<?php echo isset($_POST["vrsta_$fakultet->attributes()->id"]) ? $_POST["vrsta_$fakultet->attributes()->id"] : $fakultet->Vrsta; ?>"><br>
                                        <strong>Adresa:</strong> <input type="text" name="adresa_<?php echo $fakultet->attributes()->id; ?>" value="<?php echo isset($_POST["adresa_$fakultet->attributes()->id"]) ? $_POST["adresa_$fakultet->attributes()->id"] : $fakultet->Adresa; ?>"><br>
                                        <strong>Matični broj:</strong> <input type="text" name="maticni_broj_<?php echo $fakultet->attributes()->id; ?>" value="<?php echo isset($_POST["maticni_broj_$fakultet->attributes()->id"]) ? $_POST["maticni_broj_$fakultet->attributes()->id"] : $fakultet->MaticniBroj; ?>"><br>
                                        <strong>OIB:</strong> <input type="text" name="oib_<?php echo $fakultet->attributes()->id; ?>" value="<?php echo isset($_POST["oib_$fakultet->attributes()->id"]) ? $_POST["oib_$fakultet->attributes()->id"] : $fakultet->OIB; ?>"><br>
                                        <strong>Email:</strong> <input type="text" name="email_<?php echo $fakultet->attributes()->id; ?>" value="<?php echo isset($_POST["email_$fakultet->attributes()->id"]) ? $_POST["email_$fakultet->attributes()->id"] : $fakultet->Email; ?>"><br>
                                        <br>
                                        <input type="submit" name="spremi" value="Spremi">
                                    </form>
                                <?php } else { ?>
                                    <strong>Dekan:</strong> <?php echo $fakultet->Dekan; ?><br>
                                    <strong>Nadređena ustanova:</strong> <?php echo $fakultet->NadredenaUstanova; ?><br>
                                    <strong>Vrsta:</strong> <?php echo $fakultet->Vrsta; ?><br>
                                    <strong>Adresa:</strong> <?php echo $fakultet->Adresa; ?><br>
                                    <strong>Matični broj:</strong> <?php echo $fakultet->MaticniBroj; ?><br>
                                    <strong>OIB:</strong> <?php echo $fakultet->OIB; ?><br>
                                    <strong>Email:</strong> <?php echo $fakultet->Email; ?><br>
                                <?php } ?>

                                <br>
                            <table class="table mt-3">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Studij</th>
                                        <th scope="col">Trajanje semestara</th>
                                        <th scope="col">Razina</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fakultet->Studiji->Odabir as $odabir) : ?>
                                        <tr>
                                            <td><?php echo $odabir->Studij; ?></td>
                                            <td><?php echo $odabir->TrajanjeSemestara; ?></td>
                                            <td><?php echo $odabir->Razina; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>


    <footer>
        <p>© 2023 Karlo Žerjav</p>
    </footer>
</body>

</html>
