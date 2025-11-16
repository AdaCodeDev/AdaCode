<?php 
session_start();

include 'conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];

$insert = "INSERT INTO tb_feedback (id_feedback, nome, email, feedback) VALUES (NULL, ?, ?, ?)";
$prepare = $conexao->prepare($insert);

if (!$prepare){
    die("Erro na preparação do SQL: " . $conexao->error);
}

$prepare->bind_param('sss', $nome, $email, $feedback);

if($prepare->execute()){
    header('Location: feedback.php');
    exit();
}
else{
    echo "<script>alert('Erro ao cadastrar usuário: {$prepare->error}'); history.back();</script>";
}


?>