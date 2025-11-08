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

if(isset($_FILES["urlimg"]) && !empty($_FILES["urlimg"])){
    $imagem = "./img/".$_FILES["urlimg"]["name"];
    move_uploaded_file($_FILES["urlimg"]["tmp_name"], $imagem);
    echo "update realizado com sucesso";
}
else{
    $imagem = "";
}


include 'conexao.php';

$insert = "INSERT INTO tb_curso (id_curso, nm_curso, ds_curso, nm_plataforma, nivel_curso, area_curso, vl_curso, ch_curso, certificado, url_img)
VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$prepare = $conexao->prepare($insert);

if (!$prepare){
    die("Erro na preparação do SQL: " . $conexao->error);
}

$prepare->bind_param('sssssdiss', $titulo, $descricao, $plataforma,
$nivel, $area, $preco, $cargaHoraria, $certificado, $imagem);


if($prepare->execute()){
    header('Location: cadastro_curso.html');
    exit();
}
else{
    echo "<script>alert('Erro ao cadastrar usuário: {$prepare->error}'); history.back();</script>";
}


?>