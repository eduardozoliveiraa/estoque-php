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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entrada = $_POST["entrada"];
    $saida = $_POST["saida"];

    $sqlInsert = "INSERT INTO estoque (entrada, saida) VALUES ('$entrada', '$saida')";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "<script>alert('Dados inseridos com sucesso.'); window.location.href = '{$_SERVER['REQUEST_URI']}';</script>";
        exit();
    } else {
        echo "Erro ao inserir dados: " . $conn->error;
    }
}

$sqlEstoque = "SELECT entrada, saida FROM estoque";


$resultEstoque = $conn->query($sqlEstoque);

if ($resultEstoque->num_rows > 0) {
    $totalEstoque = 0;


    while ($row = $resultEstoque->fetch_assoc()) {
        $entrada = $row["entrada"];
        $saida = $row["saida"];

        $entrada = floatval($entrada);
        $saida = floatval($saida);

        $totalEstoque += ($entrada - $saida);
    }
}

$capacidadeMaxima = 12375;

$porcentagemCheio = ($totalEstoque / $capacidadeMaxima) * 100;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Estoque</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    .conteudo {
        height: <?php echo $porcentagemCheio . '%'; ?>;
        width: 100%;
        background-color: green;
        position: absolute;
        bottom: 0;
    }
</style>

<body>
    <header>
        <h1>Gerenciamento de estoque</h1>
        <div>
            <h3><a href="index.php">Acrescentar dados</a></h3>
            <h3><a href="consultarDados.php">Consultar dados</a></h3>
        </div>
    </header>

    <form id="estoqueForm" method="post" action="">
        <div>
            <label for="qtdsaida">Quantidade de saída:</label>
            <input type="text" name="saida" id="qtdsaida">
        </div>
        <br>
        <div>
            <label for="qtdentrada">Quantidade de entrada:</label>
            <input type="text" name="entrada" id="qtdentrada">
        </div>
        <br>
        <input type="submit" value="Enviar para o Banco de Dados">
    </form>

    <br><br><br><br><br>
    <p>Total do Estoque: <?php echo $totalEstoque; ?></p>


   
    <div class="silo-total">
        <div class="silo-triangulo"></div>
        <div class="silo">
            <div class="conteudo">
                <p><?php echo number_format($porcentagemCheio, 2) . "%"; ?></p>
            </div>
        </div>

</body>

</html>