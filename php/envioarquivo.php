<?php
session_start();  // Inicia a sessão

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

    // Conexão para buscar os arquivos enviados pelo usuário
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "cadastro"; // <- banco onde está a tabela campo
    $connArquivo = new mysqli($host, $user, $pass, $dbname);

    if ($connArquivo->connect_error) {
        die("Erro na conexão (arquivos): " . $connArquivo->connect_error);
    }

    // Busca os arquivos enviados pelo usuário logado
    $sqlArquivos = "
    SELECT DISTINCT cam_arquivo_id 
    FROM campo 
    WHERE cam_usu_id = {$usu_id}
    ORDER BY cam_arquivo_id DESC";

    $resArquivos = $connArquivo->query($sqlArquivos);
}

// Verifica se o link de logout foi clicado
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: servicos.php");
    exit();
}
?>
<!-- 8 -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="./imagens/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="animacoes.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Carregar Arquivo de Texto</title>
</head>

<body class="servicos visualizacao-sped">
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
                <div class="conteiner-visualizar">
                    <div class="filtro-tabelas">
                        <form action="" method="post" enctype="multipart/form-data">
                            <?php echo "<h1> Usuário logado como " . $usu_nome . " " . $usu_sobrenome . "</h1>"; ?>
                            <a href="?logout=true">Entrar com outro usuário</a>

                            <br><br>

                            <input type="file" name="arquivo" accept=".txt,.ecd" required>
                            <input type="submit" name="importar" class="submit" value="ENVIAR"><br>

                            <!-- SELECT COM ARQUIVOS DO USUÁRIO -->
                            <label for="arquivos">Arquivos enviados:</label><br>
                            <select name="arquivo_id" id="arquivos" onchange="this.form.submit()">
                                <option value="">Selecione um arquivo para visualizar</option>

                                <?php
                                if ($resArquivos && $resArquivos->num_rows > 0) {
                                    while ($row = $resArquivos->fetch_assoc()) {
                                        $sel = (isset($_POST['arquivo_id']) && $_POST['arquivo_id'] == $row['cam_arquivo_id']) ? "selected" : "";
                                        echo "<option value='{$row['cam_arquivo_id']}' $sel>Arquivo Nº {$row['cam_arquivo_id']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Nenhum arquivo enviado ainda</option>";
                                }
                                ?>
                            </select>

                            <br><br>

                            <a href="visualizar_sped.php"> Visualizar ECD</a><br><br>
                            <a href="validar.php">Validar arquivo enviado</a>
                        </form>
                    </div>


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

                    // -------------------------------------
                    // 1) PROCESSAR ENVIO DE ARQUIVO
                    // -------------------------------------
                    if (isset($_POST['importar']) && $_POST['importar'] === 'ENVIAR') {

                        if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
                            echo "<p style='color:red;'>Erro no upload.</p>";
                        } else {

                            // Lê o arquivo
                            $arquivoTmp = $_FILES['arquivo']['tmp_name'];
                            $linhas = @file($arquivoTmp, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                            if (!$linhas) {
                                echo "<p style='color:red;'>Arquivo vazio ou inválido.</p>";
                            } else {

                                // Conecta no banco CADASTRO
                                $conn = new mysqli("localhost", "root", "", "cadastro");

                                // Descobre o próximo arquivo_id
                                $resMax = $conn->query("SELECT MAX(cam_arquivo_id) AS max_id FROM campo");
                                $rowMax = $resMax->fetch_assoc();
                                $arquivo_id = ((int)$rowMax['max_id']) + 1;

                                $sql = "INSERT INTO campo (
                cam_usu_id, cam_arquivo_id, cam_data,
                cam_1, cam_2, cam_3, cam_4, cam_5, cam_6, cam_7, cam_8, cam_9,
                cam_10, cam_11, cam_12, cam_13, cam_14, cam_15, cam_16, cam_17, cam_18, cam_19,
                cam_20, cam_21, cam_22, cam_23, cam_24, cam_25, cam_26, cam_27, cam_28, cam_29,
                cam_30, cam_31, cam_32, cam_33, cam_34, cam_35
            ) VALUES (
                ?, ?, ?,
                ?,?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?
            )";

                                $stmt = $conn->prepare($sql);
                                $tipos = "iis" . str_repeat("s", 35);

                                $contador = 0;

                                foreach ($linhas as $linha) {

                                    // remove BOM
                                    $linha = trim(preg_replace('/^\xEF\xBB\xBF/', '', $linha));

                                    // explode
                                    $campos = explode("|", $linha);

                                    // remove o primeiro vazio antes do primeiro "|"
                                    if (isset($campos[0]) && $campos[0] === "") {
                                        array_shift($campos);
                                    }

                                    // Garante 35 campos
                                    $valores = [];
                                    for ($i = 0; $i < 35; $i++) {
                                        $valores[$i] = isset($campos[$i]) && $campos[$i] !== "" ? $campos[$i] : NULL;
                                    }

                                    $data = date('Y-m-d H:i:s');
                                    $params = array_merge([$usu_id, $arquivo_id, $data], $valores);

                                    $stmt->bind_param($tipos, ...$params);
                                    $stmt->execute();
                                    $contador++;
                                }


                                echo "<p style='color:lightgreen;'>$contador linhas inseridas (Arquivo $arquivo_id).</p>";
                            }
                        }
                    }

                    // -------------------------------------
                    // 2) EXIBIR ARQUIVO SELECIONADO
                    // -------------------------------------
                    if (isset($_POST['arquivo_id']) && $_POST['arquivo_id'] !== "") {

                        $arquivoSelecionado = (int)$_POST['arquivo_id'];

                        $connVer = new mysqli("localhost", "root", "", "cadastro");

                        $sqlView = "
        SELECT *
        FROM campo
        WHERE cam_usu_id = {$usu_id}
        AND cam_arquivo_id = {$arquivoSelecionado}
        ORDER BY cam_id ASC";

                        $resultView = $connVer->query($sqlView);
                        echo "<h2>Exibindo Arquivo Nº {$arquivoSelecionado}</h2>";

                        if ($resultView->num_rows > 0) {

                            echo "<div class='tabela-wrapper'>";
                            echo "<table class='tabela-sped'>";
                            echo "<tr>";

                            while ($campo = $resultView->fetch_field()) {
                                echo "<th>{$campo->name}</th>";
                            }
                            echo "</tr>";

                            $resultView->data_seek(0);
                            while ($linha = $resultView->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($linha as $valor) {
                                    echo "<td>" . htmlspecialchars($valor ?? '') . "</td>";
                                }
                                echo "</tr>";
                            }

                            echo "</table></div>";

                            
                        } else {
                            echo "<p style='color:yellow;'>Nenhum dado encontrado neste arquivo.</p>";
                        }
                        $connVer->close();
                    }
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