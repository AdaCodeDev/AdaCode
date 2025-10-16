<?php
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

include 'conexao.php';

$insert = "INSERT INTO  tb_user VALUES (NULL, '$nome', '$email', '$senha')";

$query = mysqli_query($conexao, $insert);

echo "Inserido com sucesso";



?>