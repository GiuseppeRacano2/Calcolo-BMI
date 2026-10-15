<?php
// Recuperiamo i dati inviati dal form HTML
$nome = $_POST['nome'] ?? '';
$peso = floatval($_POST['peso'] ?? 0);
$altezzaCm = floatval($_POST['altezza'] ?? 0);

// Calcolo del BMI (altezza convertita in metri)
$altezzaM = $altezzaCm / 100;
$bmi = 0;
if ($altezzaM > 0) {
    $bmi = $peso / ($altezzaM * $altezzaM);
}

// Determiniamo la categoria e la classe CSS in base al valore
if ($bmi < 18.5) {
    $categoria = "Situazione di sottopeso";
    $classe = "sottopeso";
} elseif ($bmi <= 24.9) {
    $categoria = "Situazione di normopeso";
    $classe = "normopeso";
} elseif ($bmi <= 29.29) {
    $categoria = "Situazione di sovrappeso";
    $classe = "sovrappeso";
} else {
    $categoria = "Situazione di obesità";
    $classe = "obesita";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultato BMI</title>
    <style>
        body {
            background-color: #F1F3F5;
            color: #1F2328;
            font-family: sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card-risultato {
            background-color: white; /* Sfondo bianco della card principale, uguale alla prima pagina */
            width: 360px;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
            text-align: center;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 24px;
            font-size: 20px;
        }
        
        /* Box interno con i dati e i colori specifici del BMI */
        .box-dati {
            padding: 24px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            gap: 16px; /* Distanza di 16px tra i vari parametri interni come richiesto */
        }

        /* Sfondi e bordi delle 4 categorie */
        .box-dati.sottopeso { background-color: #E3EEF9; border: 2px solid #2F6FB3; }
        .box-dati.normopeso { background-color: #E3F4E6; border: 2px solid #256D34; }
        .box-dati.sovrappeso { background-color: #FCEBD7; border: 2px solid #B32D2D; }
        .box-dati.obesita { background-color: #FBE2E2; border: 2px solid #B32D2D; }

        .nome {
            font-weight: bold;
            font-size: 18px;
        }

        .dati-valori {
            font-size: 15px;
        }

        .valore-bmi {
            font-size: 28px;
            font-weight: bold;
        }

        /* Colori del testo della categoria in maiuscolo */
        .categoria {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13px;
        }
        .box-dati.sottopeso .categoria { color: #2F6FB3; }
        .box-dati.normopeso .categoria { color: #256D34; }
        .box-dati.sovrappeso .categoria, 
        .box-dati.obesita .categoria { color: #B32D2D; }

        .link-indietro {
            display: inline-block;
            margin-top: 24px; /* Distanza di 24px dal box dei dati */
            color: #1F2328;
            text-decoration: underline;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="card-risultato">
    <h2>Il tuo BMI</h2>
    
    <div class="box-dati <?php echo $classe; ?>">
        <div class="nome"><?php echo htmlspecialchars($nome); ?></div>
        <div class="dati-valori">Peso: <?php echo $peso; ?> kg &bull; Altezza: <?php echo $altezzaCm; ?> cm</div>
        <div class="valore-bmi"><?php echo number_format($bmi, 1, ',', ''); ?></div>
        <div class="categoria"><?php echo $categoria; ?></div>
    </div>

    <a href="index.html" class="link-indietro">Calcola di nuovo</a>
</div>

</body>
</html>