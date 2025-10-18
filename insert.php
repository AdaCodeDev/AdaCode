<?php
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

include 'conexao.php';

$insert = "INSERT INTO  tb_user (id_user, username, email, senha) VALUES (NULL, ?, ?, ?)";
$prepare = $conexao->prepare($insert);

if (!$prepare){
    die("Erro na preparação do SQL: " . $conexao->error);
}

$prepare->bind_param('sss', $nome, $email, $senha_hash);

if($prepare->execute()){
    header('Location: login.html');
    exit();
}
else{
    echo "<script>alert('Erro ao cadastrar usuário: {$prepare->error}'); history.back();</script>";
    
}

?>