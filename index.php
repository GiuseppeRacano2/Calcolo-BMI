<?php
// Inizializzazione delle variabili
$nome = '';
$peso = 0;
$altezzaCm = 0;
$altezzaM = 0;
$bmi = 0;
$categoria = '';
$classe = '';
$errore = '';

// Controllo se l'utente ha inviato i dati con il form (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $peso = floatval($_POST['peso'] ?? 0);
    $altezzaCm = floatval($_POST['altezza'] ?? 0);

    // Controlli di validazione dei dati
    if (empty($nome)) {
        $errore = "Attenzione: Il campo Nome è obbligatorio.";
    } elseif ($peso <= 0) {
        $errore = "Attenzione: Il peso deve essere un valore maggiore di zero.";
    } elseif ($altezzaCm <= 0) {
        $errore = "Attenzione: L'altezza deve essere un valore maggiore di zero.";
    } else {
        // Calcolo del BMI (altezza convertita in metri)
        $altezzaM = $altezzaCm / 100;
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
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolo BMI</title>
    <!-- CSS nella stessa cartella -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php 
        // Se la richiesta è GET (prima apertura del sito), mostriamo il form pulito
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>
        <main>
            <h1>Calcolatore BMI</h1>
            <div class="card">
                <form method="post" action="index.php">
                    <div class="input-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" value="Luca">
                    </div>

                    <div class="input-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" value="70">
                    </div>

                    <div class="input-group">
                        <label for="altezza">Altezza (cm)</label>
                        <input type="number" id="altezza" name="altezza" value="178">
                    </div>

                    <button type="submit">Calcola</button>
                </form>    
            </div>        
        </main>
    <?php 
        } else {
            // Se è POST, verifichiamo se c'è un errore
            if (!empty($errore)) {
    ?>
        <!-- Se c'è un errore, rimostriamo il form con il box rosso e i dati scritti prima -->
        <main>
            <h1>Calcolatore BMI</h1>
            <div class="card">
                
                <div style="background-color: #FBE2E2; color: #B32D2D; padding: 12px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; font-weight: 500;">
                    <?php echo $errore; ?>
                </div>

                <form method="post" action="index.php">
                    <div class="input-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" value="Luca">
                    </div>

                    <div class="input-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" value="70">
                    </div>

                    <div class="input-group">
                        <label for="altezza">Altezza (cm)</label>
                        <input type="number" id="altezza" name="altezza" value="178">
                    </div>

                    <button type="submit">Calcola</button>
                </form>    
            </div>        
        </main>
    <?php 
            } else {
    ?>
        <!-- Altrimenti (se è POST ed è tutto corretto), mostriamo la card del risultato -->
        <div class="card-risultato">
            <h2>Il tuo BMI</h2>
            
            <div class="box-dati <?php echo $classe; ?>">
                <div class="nome"><?php echo htmlspecialchars($nome); ?></div>
                <div class="dati-valori">Peso: <?php echo $peso; ?> kg &bull; Altezza: <?php echo $altezzaCm; ?> cm</div>
                <div class="valore-bmi"><?php echo number_format($bmi, 1, ',', ''); ?></div>
                <div class="categoria"><?php echo $categoria; ?></div>
            </div>

            <a href="index.php" class="link-indietro">Calcola di nuovo</a>
        </div>
    <?php 
            } 
        } 
    ?>

</body>
</html>