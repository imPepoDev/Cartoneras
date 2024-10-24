<?php
require_once '../db/conn.php';

class PostService
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Função que busca todos os posts com suas respectivas imagens
    public function getAllPosts()
    {
        // Busca todos os posts
        $queryPosts = "SELECT id, header_texto, descricao_texto, criador_post, autorizado 
                    FROM posts_cartoneiras";
        $posts = $this->db->executeQuery($queryPosts);

        foreach ($posts as &$post) {
            $postId = $post['id'];
            // Busca as imagens relacionadas a este post
            $post['imagens'] = $this->getImagesByPostId($postId);
        }

        return $posts;
    }

    // Função para buscar todas as imagens de um post específico
    private function getImagesByPostId($postId)
    {
        $queryImages = "SELECT imagem_blob FROM imagens_post WHERE post_id = :post_id";
        $images = $this->db->executeQuery($queryImages, [':post_id' => $postId]);

        // Converte cada imagem BLOB para base64
        $base64Images = [];
        foreach ($images as $image) {
            $base64Images[] = 'data:image/jpeg;base64,' . base64_encode($image['imagem_blob']);
        }

        return $base64Images;
    }

    // Função que salva os posts e imagens em um arquivo JSON
    public function savePostsToJson($filename = 'posts.json')
    {
        $posts = $this->getAllPosts();
        file_put_contents($filename, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
