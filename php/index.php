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
<!-- 1 -->
<!DOCTYPE html>
<html lang="pt-br">
<!--Início html-->

<head>
    <!--Início head-->
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title> Sped Contábil - Home</title>
    <script src="animacoes.js" defer></script>
</head>
<!--Fim head-->

<body class="home"> <!--Início body-->

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

                <div class="esquerda">
                    <h2>O QUE É SPED?</h2>
                    <div class="paragrafo1">
                        <p>O Sistema Público de Escrituração Digital (Sped) visa proporcionar melhor ambiente de
                            negócios para o País e a redução do Custo Brasil,
                            promovendo a modernização dos processos de interação entre a administração pública e as
                            empresas, em geral em todo o território nacional.
                            <br><br>
                            Visa a modernização da sistemática atual do cumprimento das obrigações acessórias,
                            transmitidas pelos contribuintes às administrações tributárias e aos órgãos fiscalizadores,
                            utilizando-se da certificação digital para fins de assinatura dos documentos eletrônicos,
                            garantindo assim a validade jurídica dos mesmos apenas na sua forma digital.
                        </p>
                    </div>

                    <h2>O QUE É ECD?</h2>

                    <div class="paragrafo2">
                        <p>
                            A Escrituração Contábil Digital (ECD) tem por objetivo a substituição da escrituração em
                            papel pela escrituração transmitida via arquivo, ou seja, corresponde à obrigação de
                            transmitir, em versão digital, os seguintes livros:
                            <br><br>
                            I - Livro Diário e seus auxiliares, se houver; <br>
                            II - Livro Razão e seus auxiliares, se houver; <br>
                            III - Livro Balancetes Diários, Balanços e fichas de lançamento comprobatórias dos
                            assentamentos neles transcritos <br><br>
                            <hr>
                            <a href="https://www.gov.br/nfse/pt-br/municipios/conheca/o-que-e-sped">Confira no
                                Portal da Nota Fiscal de Serviço eletrônica</a>
                        </p>
                    </div>
                </div>

                <div class="direita">
                    <img src="./imagens/logo.jpg" alt="Imagem da logo sped">
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

</body>
<!--Fim body-->

</html><!-- Fim html-->