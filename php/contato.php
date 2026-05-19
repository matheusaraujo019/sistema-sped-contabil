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
<!-- 4 -->

<!DOCTYPE html>
<html lang="pt-br">
<!--Início html-->

<head>
    <!--Início head-->
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sped Contábil - Contato</title>
    <script src="animacoes.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<!--Fim head-->

<body class="contato"> <!--Início body-->

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
        <div id="conteiner">
            <div class="interface">
                <div class="contato-formulario">
                    <!-- Formulário de Contato -->
                    <h2>Entre em contato conosco</h2>
                    <br><br>

                    <form action="" method="post">
                        <input type="email" id="email" name="email" required placeholder="Digite seu e-mail"><br>
                        <textarea id="mensagem" name="mensagem" required placeholder="Digite sua mensagem" rows="6"></textarea>
                        <br><br>
                        <input type="submit" name="enviar" class="submit">
                        <?php
                        // Verifica se o formulário foi enviado
                        if (isset($_POST['enviar'])) {
                            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitiza o email
                            $mensagem = htmlspecialchars(trim($_POST['mensagem'])); // Sanitiza a mensagem

                            // Valida o email
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                echo "<p style='color: red;'>O e-mail fornecido é inválido. Tente novamente.</p>";
                            } else {
                                $to = "felipe.praado.htt@hotmail.com"; // Coloque o e-mail para o qual você quer que a mensagem seja enviada
                                $subject = "Mensagem de Contato - SPED Contábil";
                                $message = "E-mail: $email\nMensagem:\n$mensagem";

                                // Envio do e-mail
                                if (mail($to, $subject, $message)) {
                                    echo "<p style='color: green;'>Sua mensagem foi enviada com sucesso!</p>";
                                } else {
                                    echo "<p style='color: red; text-align='center' '>Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde.</p>";
                                }
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <footer>
        <!--Início footer-->
        <div class="interface">
            <div class="rodape">
                Sped Contábil &copy;
            </div>
        </div>
    </footer>
    <!--Fim footer-->

</body><!--Fim body-->

</html><!-- Fim html-->