<?php
require_once "conexao.php";

session_start();
if (!isset($_SESSION['idusuario'])) {
    header("location: login.php");
    exit();
}

if (isset($_POST['idcarrinho'])) {
    $idcarrinho = $_POST['idcarrinho'];

    $query_FK = "SET FOREIGN_KEY_CHECKS=0";
    mysqli_query($conexao, $query_FK);
    
    $query_remover_item = "DELETE FROM carrinho WHERE idcarrinho = $idcarrinho";
    $resultado_remover_item = mysqli_query($conexao, $query_remover_item);

    if ($resultado_remover_item) {
        // Item removido com sucesso, redirecionar de volta para a página do carrinho
        header("Location: carrinho.php");
        exit();
    } else {
        // Ocorreu um erro ao remover o item do carrinho
        echo "<p>Erro ao remover o item do carrinho.</p>";
    }
} else {
    // O ID do carrinho não foi enviado via POST
    echo "<p>ID do carrinho não fornecido.</p>";
}
?>