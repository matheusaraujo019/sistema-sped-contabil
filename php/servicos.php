<?php
session_start();  // Inicia a sessão

// Verifica se o usuário já está logado (se as variáveis de sessão estiverem preenchidas)
if (
    isset($_SESSION['usu_id']) && isset($_SESSION['usu_nome']) && isset($_SESSION['usu_sobrenome']) &&
    !empty($_SESSION['usu_id']) && !empty($_SESSION['usu_nome']) && !empty($_SESSION['usu_sobrenome'])
) {
    // Se o usuário já está logado, redireciona para a página servicos2.php
    header("Location: servicos2.php");
    exit();  // Garante que o script pare após o redirecionamento
}
?>


<!DOCTYPE html>
<html lang="pt-br"><!--Início html-->
<!-- 2 -->

<head><!--Início head-->
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title> Sped Contábil - Serviços</title>
    <script src="animacoes.js" defer></script>
</head><!--Fim head-->

<body class="servicos"> <!--Início body-->

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
                        <li><a id="usuario" href="servicos2.php"><i class="fas fa-user"></i></a></li>

                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div id="conteiner">
            <div class="interface">
                <div class="cadastro">

                    <form action="" method="post">
                        <h1>Faça login:</h1>

                        <input type="email" name="email" placeholder="Digite seu email:"><br>
                        <input type="password" name="senha" placeholder="Digite sua senha"><br>
                        <a href="cadastro.php">Faça cadastro</a><br>

                        <input class="submit" type="submit" value="LOGIN"><br>

                        <?php
                        include "conecta.php";

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $email = $_POST['email'];
                            $senha = $_POST['senha'];

                            if (!isset($email) || !isset($senha) || $email == false || $senha == false) {
                                echo "<div class='erro'>";
                                echo " <h3> PREENCHA TODOS OS CAMPOS</h3>";
                                echo "</div>";
                            } else {
                                $query = mysqli_query($conexao, "SELECT usu_id, usu_nome, usu_sobrenome FROM usuario WHERE usu_email = '$email' AND usu_senha = '$senha'");

                                $row = mysqli_fetch_assoc($query);  // Usando fetch_assoc() para retornar os dados do usuário

                                if ($row) {
                                    $_SESSION['usu_id'] = $row['usu_id'];
                                    $_SESSION['usu_nome'] = $row['usu_nome'];
                                    $_SESSION['usu_sobrenome'] = $row['usu_sobrenome'];

                                    echo " <h3> LOGIN REALIZADO COM SUCESSO</h3>";


                                    echo "<script>setTimeout(function(){ window.location.href = 'servicos2.php'; }, 1500);</script>";

                                    exit();
                                } else {
                                    echo "<div class='erro'>";
                                    echo " <h3> USUÁRIO NÃO CADASTRADO</h3>";
                                    echo "</div>";
                                }
                            }
                        }
                        ?>
                    </form>
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