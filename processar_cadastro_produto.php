<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_evento = $_POST["id_evento"];
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $quantidade = $_POST["quantidade"];
    $valor = $_POST["valor"];

    // Preparar a consulta SQL para inserir o produto na loja
    $query = "INSERT INTO iten_loja (nome, descricao, quantidade, valor, idevento) VALUES ('$nome', '$descricao', $quantidade, $valor, $id_evento)";
    $resultado = mysqli_query($conexao, $query);

    // Verificar se a consulta foi bem-sucedida
    if ($resultado) {
        header("location: loja.php?id=".$id_evento);
    } else {
        echo "Erro ao cadastrar o produto na loja.";
    }
}
?>