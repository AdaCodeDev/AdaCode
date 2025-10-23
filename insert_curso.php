<?php
session_start();

$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$plataforma = $_POST['plataforma'];
$nivel = $_POST['nivel'];
$area = $_POST['area'];
$preco = $_POST['preco'];
$cargaHoraria = $_POST['cargaHoraria'];
$certificado = $_POST['certificado'];
$urlimag = $_POST['urlimg'];

include 'conexao.php';

$insert = "INSERT INTO tb_user (nm_curso, ds_curso, nm_plataforma, nivel_curso, area_curso, vl_curso, ch_curso, certificado, url_img)
VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$prepare = $conexao->prepare($insert);

if (!$prepare){
    die("Erro na preparação do SQL: " . $conexao->error);
}



?>