// Função para carregar o JSON
export async function loadPosts() {
    try {
        // Altere o caminho para o seu arquivo JSON
        const response = await fetch('../php/posts.json'); 
        const posts = await response.json();

        const container = document.getElementById('container-posts');
        
        // Filtra apenas os posts não autorizados
        const unauthorizedPosts = posts.filter(post => post.autorizado === 0 || post.autorizado === false);

        unauthorizedPosts.forEach(post => {
            let imagesHtml;

            // Verifica e trata imagens
            if (post.imagens && post.imagens.length > 1) {
                const carouselItems = post.imagens.map((imgSrc, index) => `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="${imgSrc}" class="post-image img-fluid" alt="Imagem do Post" style="cursor: pointer;">
                    </div>
                `).join('');

                imagesHtml = `
                    <div id="carouselPost${post.id}" class="carousel slide mb-3" data-bs-ride="false">
                        <div class="carousel-inner d-flex justify-content-around">
                            ${carouselItems}
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPost${post.id}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa-solid fa-left-long text-dark"></i></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselPost${post.id}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"><i class="fa-solid fa-right-long text-dark"></i></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                `;
            } else if (post.imagens && post.imagens.length === 1) {
                imagesHtml = `
                    <div class="col imagem-post d-flex justify-content-center image-container mb-3">
                        <img src="${post.imagens[0]}" class="d-block w-100 post-image img-fluid" alt="Imagem do Post" style="cursor: pointer;">
                    </div>
                `;
            } else {
                imagesHtml = '';
            }

            // Monta o HTML do post
            const postDiv = document.createElement('div');
            postDiv.innerHTML = `
                <div class="row container-posts mb-2 col col-lg-6" id="postNumero${post.id}">
                    <div class="col texto-post-header">
                        <h3>${post.header_texto}</h3>
                    </div>
                    <div class="w-100"></div>
                    <div class="col descricao-post w-75 mt-4 mb-4">
                        <p class="texto-descricao">${post.descricao_texto}</p>
                    </div>
                    <div class="w-100 d-flex justify-content-around"></div>
                    ${imagesHtml}
                    <div class="w-100"></div>
                    <div class="col footer-post small">
                        Enviado por: <span class="nomeDoUsuario small">${post.criador_post}</span>
                    </div>
                    <div class="w-100"></div>
                    <div class="col footer-post small">
                        <button type="button" class="btn btn-primary" onclick="validarPost(${post.id})">Validar</button>
                    </div>
                </div>
            `;
            container.appendChild(postDiv);
            console.log("Hello World!")

            
        });
    } catch (error) {
        console.error('Erro ao carregar o JSON:', error);
    }
}

// Função para validar o post
async function validarPost(postId) {
    try {
        // Envie uma requisição para seu endpoint de validação
        const response = await fetch('../php/updatePost.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: postId, autorizado: 1 })
        });

        if (response.ok) {
            const result = await response.json();
            if (result.success) {
                alert('Post validado com sucesso!');
                // Atualiza a página para refletir a mudança ou remove o post
                loadPosts(); // Recarrega os posts após a validação
            } else {
                alert('Erro ao validar o post.');
            }
        } else {
            alert('Erro ao comunicar com o servidor.');
        }
    } catch (error) {
        console.error('Erro ao validar o post:', error);
    }
}

// Chama a função para carregar os posts ao carregar a página
document.addEventListener('DOMContentLoaded', loadPosts);
