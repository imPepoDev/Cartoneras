function loadPostsFromJson() {
    const container = document.getElementById('container-posts');
    if (!container) {
        console.error('Elemento container_posts não encontrado no DOM.');
        return;
    }

    fetch('../php/posts.json')
        .then(response => response.json())
        .then(posts => {
            // Armazena o HTML atual dos posts
            const currentPostsHTML = Array.from(container.children).map(postDiv => postDiv.innerHTML);
            const newPostsHTML = [];

            posts.forEach(post => {
                // Verifica se o post está autorizado
                if (post.autorizado !== 0 && post.autorizado !== false && post.autorizado !== null) {
                    const postDiv = document.createElement('div');
                    postDiv.classList.add('d-flex', 'justify-content-center');

                    // Verifica e trata imagens
                    let imagesHtml;
                    if (post.imagens && post.imagens.length > 1) {
                        const carouselItems = post.imagens.map((imgSrc, index) => `
                            <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                <img src="${imgSrc}" class="post-image img-fluid" alt="Imagem do Post" style="cursor: pointer; height: 612px !important">
                            </div>
                        `).join('');

                        imagesHtml = `
                            <div id="carouselPost${post.id}" class="carousel slide mb-3" data-bs-ride="false">
                                <div class="carousel-inner p-5">
                                    ${carouselItems}
                                </div>
                                <button class="carousel-control-prev p-1" type="button" data-bs-target="#carouselPost${post.id}" data-bs-slide="prev">
                                    <span class="carousel" aria-hidden="true"><i class="fa-solid fa-left-long text-dark"></i></span>
                                </button>
                                <button class="carousel-control-next p-1" type="button" data-bs-target="#carouselPost${post.id}" data-bs-slide="next">
                                    <span class="carousel" aria-hidden="true"><i class="fa-solid fa-right-long text-dark"></i></span>
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
                    postDiv.innerHTML = `
                        <div class="row container-posts mb-2 col col-lg-6 posts-test-cont" id="postNumero${post.id}" >
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
                        </div>
                    `;

                    // Adiciona a nova HTML à lista
                    newPostsHTML.push(postDiv.innerHTML);
                }
            });

            // Compara e atualiza os posts existentes
            if (currentPostsHTML.length === newPostsHTML.length) {
                // Se o número de posts não mudou, só atualiza o conteúdo
                for (let i = 0; i < newPostsHTML.length; i++) {
                    if (currentPostsHTML[i] !== newPostsHTML[i]) {
                        container.children[i].innerHTML = newPostsHTML[i];
                    }
                }
            } else {
                // Limpa o contêiner e adiciona todos os novos posts
                container.innerHTML = '';
                newPostsHTML.forEach(postHTML => {
                    const newDiv = document.createElement('div');
                    newDiv.classList.add('d-flex', 'justify-content-center', 'posts-test-cont');
                    newDiv.innerHTML = postHTML;
                    container.appendChild(newDiv);
                });
            }

            // Adiciona evento de clique para cada imagem no post
            const postImages = container.querySelectorAll('.post-image');
            postImages.forEach(image => {
                image.addEventListener('click', () => openImageModal(image.src, posts.header_texto));
            });
        })
        .catch(error => {
            console.error('Erro ao carregar posts:', error);
        });
}

// Função para abrir o modal e exibir a imagem clicada
function openImageModal(imageSrc, headerText) {
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalLabel');

    modalImage.src = imageSrc;
    modalTitle.textContent = headerText;

    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}

document.addEventListener('DOMContentLoaded', loadPostsFromJson);
setInterval(loadPostsFromJson, 5000); // Recarrega posts a cada 5 segundos
