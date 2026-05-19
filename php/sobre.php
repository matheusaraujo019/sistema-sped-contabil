<?php
session_start();  // Inicia a sessão

// Inicializa a variável $usuarioLogado como false
$usuarioLogado = false;

// Verifica se o usuário está logado
if (isset($_SESSION['usu_id'])) {
    // Se a sessão estiver definida, o usuário está logado
    $usuarioLogado = true;
}
?>  
<!-- 5 -->

<!DOCTYPE html>
<html lang="pt-br">
<!--Início html-->

<head><!--Início head-->
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title> Sped Contábil - Sobre </title>
    <script src="animacoes.js" defer></script>
</head><!--Fim head-->

<body class="sobre"> <!--Início body-->

    <header>
        <div class="interface">
            <div class="titulo">
                <h1>SPED CONTÁBIL</h1>
            </div>

            <div id="navegacao">
                <nav>
                    <ul class="menu">
                        <li><a id="home" href="index.php">Home</a></li>
                        <li><a id="servicos" href="servicos.php">Serviços</a></li>
                        <li><a id="contato" href="contato.php">Contato</a></li>
                        <li><a id="sobre" href="sobre.php">Sobre Nós</a></li>
                        <li><a id="usuario" href="servicos2.php" class="<?php echo $usuarioLogado ? 'selecionado' : ''; ?>"><i class="fas fa-user"></i></a></li>

                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="interface">


                <!-- Seção de Cards para integrantes -->
                <div class="cards-container">

                    <div class="contextualizacao">
                        <h2>QUEM SOMOS?</h2>
                            
                        <p>Somos alunos do SENAI de Santa Bárbara d’Oeste, cursando o último ano de Desenvolvimento de Sistemas. Desenvolvemos o SPED Contábil como parte de nossa formação e preparação para o mercado de trabalho, aplicando práticas modernas de tecnologia para criar uma ferramenta simples, eficiente e alinhada às necessidades reais dos profissionais da área.</p>
                    </div>
                    <div class="card">
                        <img src="./imagens/matheus.jpeg" alt="Imagem de Matheus Araujo">
                        <h3>Matheus Araujo </h3>
                        <p>Líder do projeto </p>
                    </div>

                    <div class="card">
                        <img src="./imagens/felipe.jpg" alt="Imagem de Felipe Prado">
                        <h3>Felipe do Prado</h3>
                        <p>Programador back-end</p>
                    </div>

                    <div class="card">
                        <img src="./imagens/julio.jpeg" alt="Imagem de Julio Cesar">
                        <h3>Julio Cesar de Oliveira</h3>
                        <p>Programador front-end</p>
                    </div>

                    <div class="card">
                        <img src="./imagens/jebs.jpeg" alt="Imagem de Daniel Furlan">
                        <h3>Daniel Furlan</h3>
                        <p>Cooperador</p>
                    </div>

                    <div class="card">
                        <img src="./imagens/silva.jpg" alt="Imagem de Leonardo da Silva">
                        <h3>Leonarndo da Silva </h3>
                        <p>Cooperador</p>
                    </div>

                    <div class="card">
                        <img src="./imagens/otavio.jpg" alt="Imagem de Otavio Monteiro">
                        <h3>Otavio Monteiro </h3>
                        <p>Cooperador</p>
                    </div>

                    <div class="card">
                        <img src="./imagens/logo.jpg" alt="Imagem de Marcos de Oliveira">
                        <h3>Marcos de Oliveira </h3>
                        <p>Cooperador</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer><!--Início footer-->
        <div class="interface">
            <div class="rodape">
                Sped Contábil &copy;
            </div>
        </div>
    </footer><!--Fim footer-->

</body><!--Fim body-->

</html><!-- Fim html-->