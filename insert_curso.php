<?php
session_start();

include 'conexao.php';

$titulo         = $_POST['titulo'];
$descricao      = $_POST['descricao'];
$descricao2     = $_POST['descricao2'];
$plataforma     = $_POST['plataforma'];
$fk_id_nivel    = $_POST['nivel'];
$preco          = $_POST['preco'];
$cargaHoraria   = $_POST['cargaHoraria'];
$certificado    = $_POST['certificado'];
$url            = $_POST['url'];

// Dados Múltiplos (Áreas)
$areas = isset($_POST['areas']) ? $_POST['areas'] : []; 

if (empty($areas) || empty($titulo) || empty($fk_id_nivel)) {
    echo "<script>alert('Erro: Campos obrigatórios (Título, Nível, Área) não preenchidos.'); history.back();</script>";
    exit();
}


// ---  TRATAMENTO DE IMAGEM ---
$imagem = "";
if (isset($_FILES["urlimg"]) && $_FILES["urlimg"]["error"] === UPLOAD_ERR_OK) {
    $nome_arquivo = uniqid() . "_" . $_FILES["urlimg"]["name"]; 
    $caminho_destino = "./img/" . $nome_arquivo;
    if (move_uploaded_file($_FILES["urlimg"]["tmp_name"], $caminho_destino)) {
        $imagem = $nome_arquivo;
    } else {
        error_log("Erro ao mover arquivo de upload: " . $caminho_destino);
    }
}

$conexao->begin_transaction();
$sucesso = true;

try {
    $insert_curso_sql = "INSERT INTO tb_curso (nm_curso, ds_curso, ds2_curso, nm_plataforma, fk_id_nivel, vl_curso, ch_curso, certificado, url_curso, url_img)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $prepare_curso = $conexao->prepare($insert_curso_sql);

    if (!$prepare_curso) {
        throw new Exception("Erro na preparação do SQL (Curso): " . $conexao->error);
    }

    $prepare_curso->bind_param(
        'ssssisdsss',
        $titulo,
        $descricao,
        $descricao2,
        $plataforma,
        $fk_id_nivel,
        $preco,
        $cargaHoraria,
        $certificado,
        $url,
        $imagem
    );

    if (!$prepare_curso->execute()) {
        throw new Exception("Erro ao inserir curso: " . $prepare_curso->error);
    }

    $last_id = $conexao->insert_id;

    $prepare_curso->close();

    $insert_area_sql = "INSERT INTO tb_curso_area (fk_id_curso, fk_id_area) VALUES (?, ?)";
    $prepare_area = $conexao->prepare($insert_area_sql);

    if (!$prepare_area) {
        throw new Exception("Erro na preparação do SQL (Áreas): " . $conexao->error);
    }

    foreach ($areas as $id_area) {
        $prepare_area->bind_param('ii', $last_id, $id_area);

        if (!$prepare_area->execute()) {
            throw new Exception("Erro ao inserir área ID {$id_area}: " . $prepare_area->error);
        }
    }

    $prepare_area->close();
    $conexao->commit();
} catch (Exception $e) {
    $conexao->rollback();
    $sucesso = false;
    $erro_msg = $e->getMessage();
}

if ($sucesso) {
    header('Location: cursosgeral.php');
    exit();
} else {
    echo "<script>alert('Erro ao cadastrar curso: {$erro_msg}'); history.back();</script>";
}

$conexao->close();
