<?php
require_once 'getPost.query.php';

$postService = new PostService();
$postService->savePostsToJson();  // Gera o arquivo posts.json

echo "JSON atualizado com sucesso!";
?>