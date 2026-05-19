<?php
session_start();  // Inicia a sessão

// Acessa os dados do usuário da sessão
$usu_id = $_SESSION['usu_id'];
$usu_nome = $_SESSION['usu_nome'];
$usu_sobrenome = $_SESSION['usu_sobrenome'];

// Verifica se o usuário está logado
if (!isset($_SESSION['usu_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: servicos.php");
    exit();
} else {
    $usuarioLogado = isset($_SESSION['usu_id']);
}



// Verifica se o link de logout foi clicado
if (isset($_GET['logout'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login (ou qualquer outra página de login)
    header("Location: servicos.php");
    exit();
}
?>
<!-- 3 -->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="animacoes.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Carregar e Exibir Arquivo de Texto</title>
</head>

<body class="servicos">
    <header>
        <div class="interface">
            <div class="titulo">
                <h1>Carregar Arquivo de Texto</h1>
            </div>

            <div id="navegacao">
                <nav>
                    <ul class="menu">
                        <li><a id="home" href="index.php">Home</a></li>
                        <li><a id="servicos" href="servicos2.php">Serviços</a></li>
                        <li><a id="contato" href="contato.php">Contato</a></li>
                        <li><a id="sobre" href="sobre.php">Sobre Nós</a></li>
                        <li><a id="usuario" href="servicos2.php" class="<?php echo $usuarioLogado ? 'selecionado' : ''; ?>"><i class="fas fa-user"></i></a></li>

                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div id="conteiner">
            <div class="interface">
                <div class="arquivo">
                    <form action="" method="post" enctype="multipart/form-data">
                        <a href="?logout=true">Entrar com outro usúario</a>

                    </form>

                    <?php echo "<h1>Bem-vindo, " . $usu_nome . " " . $usu_sobrenome . "</h1>"; ?><br>

                    <p >Nosso sistema de SPED Contábil foi desenvolvido para simplificar o processo de análise e visualização de arquivos ECD. Aqui você pode carregar seus dados, conferir as informações estruturadas e garantir mais precisão e agilidade na validação contábil. Nosso objetivo é oferecer uma experiência prática, segura e eficiente para contadores, empresas e profissionais que trabalham diariamente com obrigações acessórias.
                    </p>
                    <br>

                    <form action="" method="post">
                        <input type="submit" class="submit" name="visualizar" value="Visualizar SPED">

                    </form>

                    <?php

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        if (isset($_POST['visualizar'])) {
                            header('Location: visualizar_sped.php');
                        }
                    }
                    ?>
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
</body>

</html>