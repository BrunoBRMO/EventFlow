<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
    <link rel="stylesheet" href="assets/css/style2.css">
</head>
<body>
    <div class="cabecalho_historico">
        <div class="logo_historico">
            <a href="eventos.php"><img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow" title="Início" width="200"></a>
        </div>

        <div class="container_historico">
            <div class="caixa_historico">

                <?php
                require_once 'conexao.php';

                session_start();

                if (!isset($_SESSION['idusuario'])) {
                    header('Location: login.php');
                    exit();
                }

                $idUsuario = $_SESSION['idusuario'];

                // Query para obter as compras do usuário logado na tabela 'venda'
                $query = "SELECT * FROM venda WHERE idusuario = $idUsuario";

                $resultado = mysqli_query($conexao, $query);

                if (mysqli_num_rows($resultado) > 0) {
                    echo'<div class="caixa_historio">';
                    // Variável para verificar se ocorreu duplicação de ingressos
                    $ingressosDuplicados = false;
                    $codigosIngresso = array();

                    // Loop pelos resultados e exibição dos itens comprados
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "Item comprado: " . $row['nome_item'] . "<br>";
                        echo "Quantidade: " . $row['quantidade'] . "<br>";
                        echo "Preço unitário: " . $row['preco_unitario'] . "<br>";

                        // Verifique se há duplicação de ingressos
                        if ($row['cod_ingressos'] !== null) {
                            $codigos = explode(",", $row['cod_ingressos']);
                            foreach ($codigos as $codigo) {
                                if (in_array($codigo, $codigosIngresso)) {
                                    $ingressosDuplicados = true;
                                    break;
                                } else {
                                    $codigosIngresso[] = $codigo;
                                }
                            }
                        }

                        echo "<hr>";
                        echo "<br>";
                    }

                    // Exibir mensagem de aviso caso ocorra duplicação de ingressos
                    if ($ingressosDuplicados) {
                        echo '<span class="aviso">Atenção: Ocorreu uma duplicação de códigos de ingressos. Isso não interfere na sua compra e no valor descontado. Cada ingresso é único e válido separadamente.</span><br>';
                    }
                } else {
                    echo '<center>';
                    echo "Nenhum item comprado encontrado.";
                }
                echo '<center>';
                echo '<a href="eventos.php">Voltar para Eventos</a>';
                echo '</center>';
                echo'</div>';

                mysqli_close($conexao);
                ?>
            </div>
        </div>
    </div> 
</body>
</html>