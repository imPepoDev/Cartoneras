<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartonera CECB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css"
        integrity="sha512-B46MVOJpI6RBsdcU307elYeStF2JKT87SsHZfRSkjVi4/iZ3912zXi45X5/CBr/GbCyLx6M1GQtTKYRd52Jxgw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../css/style.css">
    <meta name="description"
        content="Este site foi feito com todo o carinho para a Feira de Ciências do Colégio Estadual Central do Brasil (CECB).">
    <meta name="keywords" content="cecb, cartoneiras, cartoneras, portguês, escola, estadual, Colégio Estadual Central do Brasil, Feira de Ciências
        , criatividade, livros, livro, artesanal">
    <meta name="author" content="Pedro Gabriel C. da Silva camuri">
</head>

<?php


require_once "../php/getPost.query.php";

$postService = new PostService();



?>

<script type="module" src="../js/writeJson.js"></script>

<body>



    <button type="button" class="btn btn-primary mt-3 position-fixed ms-2" style="z-index: 999; top: 10%" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fa-solid fa-plus"></i>
    </button>


    <nav class="navbar navbar-dark header-div-mae d-flex justify-content-center pb-5 pt-4 mb-4">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="../index.html">CECB | <span>Cartoneras</span></a>
            <!-- Button trigger modal -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <!-- <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5> -->
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">O que é uma cartonera?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Como fazer uma cartonera?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="pages/posts.php">Posts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="d-flex justify-content-center p-4">
        <p class="small">Em caso de má qualidade da imagem, clique nela para ter uma visualização melhor!</p>
    </div>



    <div id="container-posts" class="container-fluid row d-flex justify-content-center p-0 m-0 p-3">
        <!-- <div class="d-flex justify-content-center">
            <div class="row container-posts mb-2 col col-lg-6" id="postNumero{IdRetornado}">
                <div class="col texto-post-header">
                    <h3>headerRetornadoNoIDdoPostRetornado</h3>
                </div>
                <div class="w-100"></div>
                <div class="col descricao-post w-75 mt-4 mb-4">
                    <p class="texto-descricao">DescriçãoRetornadaDaQueryNoIDdoPostRetornado</p>
                </div>
                <div class="w-100"></div>
                <div class="col imagem-post mb-5">
                    ImagemQueFoiSalvaEmBlobRetornadaVisivelNoIDdoPostRetornado
                </div>
                <div class="w-100"></div>
                <div class="col footer-post small">Enviado por: <span class="nomeDoUsuario small">nomeRetornadoNoIDdoPostRetornado</span></div>
                <div class="w-100"></div>
            </div>
        </div>

        <div class="w-100"></div> -->







    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Envie seu post para nós!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="small">!!Seu post será enviado até a administração para analisar seu post e liberar o compartilhamento do seu post!!</p>

                    <form action="../php/createPost.query.php" class="row" method="POST" enctype="multipart/form-data">

                        <div class="col-12 mb-3">
                            <label for="header_texto">Cabeçalho:</label>
                            <input type="text" id="header_texto" name="header_texto" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="descricao_texto">Descrição:</label>
                            <textarea id="descricao_texto" name="descricao_texto" rows="1" required></textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="criador_post">Criador do Post:</label>
                            <input type="text" id="criador_post" name="criador_post" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="imagem_blob">Imagem:</label>
                            <input type="file" name="imagens_blob[]" accept=".png, .jpg, .jpeg" multiple required>
                        </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- <button type="button" class="btn btn-primary">Enviar</button> -->
                    <button type="submit" class="btn btn-primary">Enviar Post</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Estrutura -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img id="modalImage" src="" alt="Imagem do Post" style="max-width: 85%; max-height: 85%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>











    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <script src="../js/getPosts.js"></script>
</body>

</html>