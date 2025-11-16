<?php
session_start();

$nome = trim($_POST['nome'] ?? '');
$senha = trim($_POST['senha'] ?? '');

include 'conexao.php';

$select = "SELECT * FROM tb_user WHERE username = ?";
$prepare = $conexao->prepare($select);

$prepare->bind_param('s', $nome);
$prepare->execute();

$result = $prepare->get_result();
$user = $result->fetch_assoc();


if (!$user) {
    die("DIAGNÓSTICO: Usuário '" . $nome . "' não foi encontrado no banco de dados.");
}

if (password_verify($senha, $user['senha'])) {
     $_SESSION['user_id'] = $user['id_user'];
    $_SESSION['nome_usuario'] = $user['username'];
    header('location: home.php');
    exit(); 
} else {
    echo "DIAGNÓSTICO: Senha Incorreta.<br>";
    echo "Hash do BD (para conferência): " . $user['senha'];
    die();
}
    
?>

