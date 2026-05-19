<!-- 6 -->
<!DOCTYPE html>
<html lang="pt-br"><!--Início html-->

<head><!--Início head-->
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title> Sped Contábil - Serviços</title>
    <script src="animacoes.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head><!--Fim head-->

<body> <!--Início body-->
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

                    <form action="cadastro.php" method="post">
                        <h1>Faça cadastro:</h1>

                        <input type="Nome:" name="nome" placeholder="Digite seu primeiro nome:"><br>
                        <input type="Sobrenome:" name="sobrenome" placeholder="Digite seu sobrenome:"><br>
                        <input type="email" name="email" placeholder="Digite seu email:"><br>
                        <input type="password" name="senha" placeholder="Digite sua senha"><br>

                        <input class="submit" type="submit" value="CADASTRAR"><br>

                        <?php
                        include "conecta.php";

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $nome       = mysqli_real_escape_string($conexao, $_POST['nome']);
                            $sobrenome  = mysqli_real_escape_string($conexao, $_POST['sobrenome']);
                            $email      = mysqli_real_escape_string($conexao, $_POST['email']);
                            $senha      = mysqli_real_escape_string($conexao, $_POST['senha']);

                            if (!isset($nome) || !isset($sobrenome) || !isset($email) || !isset($senha) || $nome == false || $sobrenome == false ||  $email == false || $senha == false) {
                                echo "<div class='erro'>";
                                echo " <h3> PREENCHA TODOS OS CAMPOS</h3>";
                                echo "</div>";
                            } else {
                                $query = "INSERT INTO usuario (usu_nome, usu_sobrenome, usu_email, usu_senha) VALUES ('$nome', '$sobrenome', '$email', '$senha')";

                                mysqli_query($conexao, $query);

                                echo "<div>";
                                echo " <h3> Usuário Cadastrado!! </h3>";
                                echo "  <a href='servicos.php'>Faça Login</a>";
                                echo "</div>";
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