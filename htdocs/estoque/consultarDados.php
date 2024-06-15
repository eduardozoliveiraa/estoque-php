<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "estoque";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$totalEstoque = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["dateInicial"]) && !empty($_POST["dateFinal"])) {
    $dateInicial = $_POST["dateInicial"];
    $dateFinal = $_POST["dateFinal"];

    $sqlEstoque = "SELECT entrada, saida FROM estoque WHERE DATE(datas) BETWEEN '$dateInicial' AND '$dateFinal'";
    $resultEstoque = $conn->query($sqlEstoque);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Estoque</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <h1>Gerenciamento de estoque</h1>
        <div>
            <h3><a href="index.php">Acrescentar dados</a></h3>
            <h3><a href="consultarDados.php">Consultar dados</a></h3>
        </div>
    </header>

    <form method="post" action="">
        <label for="">Informe as datas</label>
        <br>
        <b>Data inicial</b>
        <input type="date" name="dateInicial">
        <br>
        <b>Data final</b>
        <input type="date" name="dateFinal">
        <br>
        <input type="submit" value="Filtrar por datas">
    </form>

    <?php
    if (isset($resultEstoque)) {
        if ($resultEstoque === false) {
            echo "<p class='no-data'>Erro na consulta SQL: " . $conn->error . "</p>";
        } elseif ($resultEstoque->num_rows === 0) {
            echo "<p class='no-data'>Nenhum dado encontrado para o intervalo de datas selecionado.</p>";
        }
    }

    if (isset($resultEstoque) && $resultEstoque->num_rows > 0) {
        $totalEstoque = 0;

        echo "<div class='dados-estoque'>";
        echo "<h2>Dados do Estoque:</h2>";

        while ($row = $resultEstoque->fetch_assoc()) {
            $entrada = floatval($row["entrada"]);
            $saida = floatval($row["saida"]);

            $totalEstoque += ($entrada - $saida);

            echo "<p>Entrada: $entrada, Saída: $saida</p>";
        }

        echo "</div>";
    }
    ?>

    <script src="js.js"></script>
</body>

</html>