import { loadPosts } from '../js/loadPosts.js';

// Função para chamar o PHP que gera o JSON
function updateJson() {
    fetch('../php/generate_json.php')
        .then(response => response.text())
        .then(data => console.log(data))
        .catch(
            error =>
                console.log('Erro ao atualizar o JSON:', error)
        );

        loadPosts();
}

// Chama a função a cada 40 segundos
setInterval(updateJson, 40000); // 40.000 ms = 40 segundos
