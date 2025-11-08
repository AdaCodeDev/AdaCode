<?php
session_start();

// Adiciona trim() para remover espaços em branco no início ou fim
$nome = trim($_POST['nome'] ?? '');
$senha = trim($_POST['senha'] ?? '');

include 'conexao.php';

$select = "SELECT * FROM tb_user WHERE username = ?";
$prepare = $conexao->prepare($select);

$prepare->bind_param('s', $nome);
$prepare->execute();

$result = $prepare->get_result();
$user = $result->fetch_assoc();

// --- NOVO CÓDIGO DE DIAGNÓSTICO ---
if (!$user) {
    die("DIAGNÓSTICO: Usuário '" . $nome . "' não foi encontrado no banco de dados.");
}

// O usuário foi encontrado. Agora vamos testar a senha.
if (password_verify($senha, $user['senha'])) {
     $_SESSION['user_id'] = $user['id_user'];
    $_SESSION['nome_usuario'] = $user['username'];
    header('location: home.php');
    exit(); 
} else {
    // --- ONDE ESTÁ A FALHA AGORA ---
    echo "DIAGNÓSTICO: Senha Incorreta.<br>";
    echo "Hash do BD (para conferência): " . $user['senha'];
    die();
}
    
?>

