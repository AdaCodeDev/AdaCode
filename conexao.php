<?php
$servidor = "localhost";
$user = "root";
$password = "";
$banco = "bd_adacode";

$conexao = new mysqli($servidor, $user, $password, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Função para buscar dados padronizados 
function buscarDadosPadronizados($conexao, $tabela) {
    
    $stmt = $conexao->prepare("SELECT * FROM $tabela ORDER BY 2");
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

?>