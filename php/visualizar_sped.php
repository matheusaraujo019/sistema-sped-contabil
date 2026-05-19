<?php
session_start();  // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['enviar'])) {
        header("Location: envioarquivo.php");
        exit();
    }
}

date_default_timezone_set('America/Sao_Paulo');

// Acessa os dados do usuário da sessão
$usu_id = $_SESSION['usu_id'];
$usu_nome = $_SESSION['usu_nome'];
$usu_sobrenome = $_SESSION['usu_sobrenome'];

// Verifica se o usuário está logado
if (!isset($_SESSION['usu_id'])) {
    header("Location: servicos.php");
    exit();
} else {
    $usuarioLogado = isset($_SESSION['usu_id']);
}

// Verifica se o link de logout foi clicado
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: servicos.php");
    exit();
}
?>
<!-- 7 -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="animacoes.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Visualizar ECD</title>
</head>

<body class="servicos visualizacao-sped">
    <header>
        <div class="interface">
            <div class="titulo">
                <h1>Visualizar ECD</h1>
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
                <div class="conteiner-visualizar">
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php echo "<h1> Usuário logado como " . $usu_nome . " " . $usu_sobrenome . "</h1>"; ?>
                        <a href="?logout=true">Entrar com outro usuário</a><br><br>

                        <input type="submit" class="submit" name="enviar" value="Enviar Arquivo ECD">
                        <br><br>
                        <a href="validar.php">Validar arquivo enviado</a>
                        
                    </form>

                    <br>

                    <?php
                    // Conexão
                    $host = "localhost";
                    $user = "root";
                    $pass = "";
                    $dbname = "ecd";
                    $conn = new mysqli($host, $user, $pass, $dbname);

                    if ($conn->connect_error) {
                        die("Erro na conexão: " . $conn->connect_error);
                    }

                    // Buscar tabelas
                    $tabelas = [];
                    $resultTabelas = $conn->query("SHOW TABLES");
                    while ($row = $resultTabelas->fetch_array()) {
                        $tabelas[] = $row[0];
                    }
                    ?>

                    <!-- FILTRO -->
                    <div class="filtro-tabelas">
                        <label for="selectTabela"><strong>Pesquisar tabela:</strong></label>

                        <select id="selectTabela">
                            <option value="todas">-- Mostrar todas --</option>
                            <?php
                            foreach ($tabelas as $tb) {
                                echo "<option value='$tb'>$tb</option>";
                            }
                            ?>
                        </select>

                        <button id="limparFiltro">Limpar</button>
                    </div>

                    <br>

                    <?php
                    

                    // Mostrar todas as tabelas inicialmente
                    foreach ($tabelas as $tabela) {

                        echo "<h2 class='titulo-tabela' data-tabela='{$tabela}'>Tabela: {$tabela}</h2>";

                        $dados = $conn->query("SELECT * FROM `$tabela` LIMIT 50");

                        if ($dados && $dados->num_rows > 0) {

                            echo "<div class='tabela-wrapper'>";
                            echo "<table class='tabela-sped' id='tabela_{$tabela}' data-tabela='{$tabela}'>";
                            echo "<tr>";

                            // Cabeçalhos
                            while ($campo = $dados->fetch_field()) {
                                echo "<th>{$campo->name}</th>";
                            }
                            echo "</tr>";

                            // Linhas
                            $dados->data_seek(0);
                            while ($linha = $dados->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($linha as $valor) {
                                    echo "<td>" . nl2br($valor ?? '') . "</td>";
                                }
                                echo "</tr>";
                            }

                            echo "</table>";
                            echo "</div>";
                        } else {
                            echo "<p><em>Tabela vazia ou sem dados.</em></p>";
                        }
                    }
                    $conn->close();



                    
                    ?>

                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="interface">
            <div class="rodape">Sped Contábil &copy;</div>
        </div>
    </footer>

    <!-- SCRIPT DO FILTRO -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const select = document.getElementById("selectTabela");
            const limpar = document.getElementById("limparFiltro");

            function filtrar() {
                const valor = select.value;

                document.querySelectorAll(".tabela-sped").forEach(tabela => {
                    const nome = tabela.dataset.tabela;
                    const titulo = document.querySelector(`h2[data-tabela='${nome}']`);

                    if (valor === "todas" || nome === valor) {
                        tabela.style.display = "block";
                        titulo.style.display = "block";
                    } else {
                        tabela.style.display = "none";
                        titulo.style.display = "none";
                    }
                });
            }

            select.addEventListener("change", filtrar);

            limpar.addEventListener("click", () => {
                select.value = "todas";
                filtrar();
            });

        });
    </script>

</body>

</html>