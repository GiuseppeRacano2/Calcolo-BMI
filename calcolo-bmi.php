<?php
//server è un array superglobale, request method è una chiave
$nome='';
$peso=0;
$altezzaCm=0;
$altezzaM=0;
$bmi=0;
$categoria='';
$classe='';

//in POST si vedono i risultati
if($_SERVER["REQUEST_METHOD"]=="POST"){
        //qui l'utente ha inviato dei dati in post con il form
        //qui posso controllare le variabili inviate con isset
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
    }else{
        //qui vuol dire che faccio richiesta in get (visualizzo il form)
    }
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolo BMI</title>
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

        main {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-bottom: 24px;
            font-size: 24px;
        }

        .card {
            background-color: white;
            width: 360px;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
        }

        /* Distanza di 16px tra i vari gruppi di input */
        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        label {
            font-size: 14px;
            font-weight: 500; 
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            font-family: sans-serif;
        }

        /* Bottone finale con larghezza piena, sfondo #1F2328, testo bianco e angoli di 8px */
        button[type="submit"] {
            background-color: #1F2328;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            font-family: sans-serif;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <?php 
        if($_SERVER["REQUEST_METHOD"]=="GET"){
    ?>
            <main>
            <h1>Calcolatore BMI</h1>
                <div class="card">
                    <form method="post" action="calcolo-bmi.php">
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
        } else{
    ?>
            <div class="card-risultato">
            <h2>Il tuo BMI</h2>
    
                <div class="box-dati <?php echo $classe; ?>">
                <div class="nome"><?php echo htmlspecialchars($nome); ?></div>
                <div class="dati-valori">Peso: <?php echo $peso; ?> kg &bull; Altezza: <?php echo $altezzaCm; ?> cm</div>
                <div class="valore-bmi"><?php echo number_format($bmi, 1, ',', ''); ?></div>
                <div class="categoria"><?php echo $categoria; ?></div>
            </div>

                <!--<a href="index.html" class="link-indietro">Calcola di nuovo</a>!-->
            </div>

    <?php
        }
    ?>    
</body>
</html>


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

    <!--<a href="index.html" class="link-indietro">Calcola di nuovo</a>!-->
</div>

</body>
</html>