<?php
require_once "conexao.php";

session_start();
if (!isset($_SESSION['idusuario'])) {
    header("location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id_evento = $_GET['id'];

    $id_usuario = $_SESSION['idusuario'];
    $query_verificar_criador = "SELECT idevento FROM eventos WHERE idevento = $id_evento AND idusuario = $id_usuario";
    $resultado_verificar_criador = mysqli_query($conexao, $query_verificar_criador);

    if (mysqli_num_rows($resultado_verificar_criador) > 0) {
        // Excluir os ingressos relacionados ao evento
        $query_excluir_ingressos = "DELETE FROM ingresso WHERE idevento = $id_evento";
        mysqli_query($conexao, $query_excluir_ingressos);

        // Excluir o evento
        $query_excluir_evento = "DELETE FROM eventos WHERE idevento = $id_evento";
        mysqli_query($conexao, $query_excluir_evento);

        header("location: eventos.php");
        exit();
    } else {
        echo "Você não tem permissão para excluir este evento.";
    }
} else {
    echo "Evento não especificado.";
}
?>