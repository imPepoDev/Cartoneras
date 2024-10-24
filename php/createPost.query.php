<?php
require_once '../db/conn.php';  // Conexão com a base de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $header_texto = $_POST['header_texto'];
    $descricao_texto = $_POST['descricao_texto'];
    $criador_post = $_POST['criador_post'];

    try {
        $db = new Database();
        $pdo = $db->getPDO();  // Acessa a instância PDO

        // Início da transação
        $pdo->beginTransaction();

        // Inserir o post
        $queryPost = "INSERT INTO posts_cartoneiras (header_texto, descricao_texto, criador_post, autorizado) 
                    VALUES (:header_texto, :descricao_texto, :criador_post, :autorizado)";
        $paramsPost = [
            ':header_texto' => $header_texto,
            ':descricao_texto' => $descricao_texto,
            ':criador_post' => $criador_post,
            ':autorizado' => false
        ];
        $db->executeQuery($queryPost, $paramsPost);

        // Obter o ID do post inserido
        $postId = $pdo->lastInsertId();

        // Verificar e inserir cada imagem
        foreach ($_FILES['imagens_blob']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['imagens_blob']['error'][$index] === UPLOAD_ERR_OK) {
                $imagemBlob = file_get_contents($tmpName);

                $queryImagem = "INSERT INTO imagens_post (post_id, imagem_blob) VALUES (:post_id, :imagem_blob)";
                $paramsImagem = [
                    ':post_id' => $postId,
                    ':imagem_blob' => $imagemBlob
                ];
                $db->executeQuery($queryImagem, $paramsImagem);
            }
        }

        // Commit da transação
        $pdo->commit();
        echo "Post e imagens salvos com sucesso!";
    } catch (Exception $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        echo "Erro ao salvar o post: " . $e->getMessage();
    }
} else {
    echo "Método de requisição inválido.";
}
?>
