<?php
// Inclua sua classe Database
require_once '../db/conn.php';

header('Content-Type: application/json');

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do JSON enviado
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $postId = $data['id'];
        $autorizado = isset($data['autorizado']) ? $data['autorizado'] : 0;

        // Instancia a classe Database
        $database = new Database();

        // Prepara a query de atualização
        $query = "UPDATE posts_cartoneiras SET autorizado = :autorizado WHERE id = :id";
        $params = [
            ':autorizado' => $autorizado,
            ':id' => $postId
        ];

        // Executa a query
        if ($database->executeQuery($query, $params)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Falha ao atualizar o post.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID do post não fornecido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}
?>
