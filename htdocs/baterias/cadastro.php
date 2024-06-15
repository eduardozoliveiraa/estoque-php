<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baterias";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
$modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';

if (empty($tag) || empty($modelo)) {
    echo "";
} else {
    $sql = "INSERT INTO baterias (tag, modelo) VALUES ('$tag', '$modelo')";
   
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Dados inseridos com sucesso.'); window.location.href = '{$_SERVER['REQUEST_URI']}';</script>";
        exit();
    } else {
        echo "Erro ao inserir dados: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Baterias</title>
</head>
<body>
    <h2>Formulário de Baterias</h2>
    <form action="" method="post">
        <label for="tag">Tag:</label>
        <input type="text" name="tag" required><br>

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" required><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
