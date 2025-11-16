<?php 
session_start();

include 'conexao.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$id_usuario = $_SESSION['user_id']; 
$titulo = $_POST['titulo'];
$conteudo = $_POST['conteudo'];

$imagem = NULL; 
if (isset($_FILES["urlimg"]) && $_FILES["urlimg"]["error"] === UPLOAD_ERR_OK) {
    $nome_original = basename($_FILES["urlimg"]["name"]);
    $nome_arquivo = $id_usuario . "_" . uniqid() . "_" . $nome_original; 
    $caminho_destino = "img/" . $nome_arquivo; 
    
    if (move_uploaded_file($_FILES["urlimg"]["tmp_name"], $caminho_destino)) {
        $imagem = $nome_arquivo;
    } else {
        error_log("Erro ao mover arquivo de upload: " . $caminho_destino);
    }
}

$insert = "INSERT INTO tb_publicacao (titulo, conteudo, url_img, fk_id_usuario) VALUES (?, ?, ?, ?)";
$prepare = $conexao->prepare($insert);

if (!$prepare){
    die("Erro na preparação do SQL: " . $conexao->error);
}

$prepare->bind_param('sssi', $titulo, $conteudo, $imagem, $id_usuario);

if($prepare->execute()){
    header('Location: forum.php');
    exit();
}
else{
    echo "<script>alert('Erro ao criar publicação: {$prepare->error}'); history.back();</script>";
}

?>