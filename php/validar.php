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

    <title>Validar Arquivo de Texto</title>
</head>

<body class="servicos visualizacao-sped">
    <header>
        <div class="interface">
            <div class="titulo">
                <h1>Validar Arquivo de Texto</h1>
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

                            <!-- SELECT COM ARQUIVOS DO USUÁRIO -->
                            <label for="arquivos">Arquivos enviados:</label><br>
                            <select name="arquivo_id" id="arquivos" onchange="this.form.submit()">
                                <option value="">Selecione um arquivo para Validar</option>

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

                            <a href="visualizar_sped.php"> Visualizar Regras da ECD</a><br><br>
                            <a href="envioarquivo.php">Visualizar Arquivos enviados</a><br><br>
                        </form>
                    </div>

                    <br>

                    <?php

                    // ============================
                    // CONFIGURAÇÕES E SESSÃO
                    // ============================
                    date_default_timezone_set('America/Sao_Paulo');

                    if (!isset($_SESSION['usu_id'])) {
                        echo "<div class='erro'>Você precisa estar logado.</div>";
                        exit();
                    }

                    $usu_id = $_SESSION['usu_id'];
                    $usu_nome = $_SESSION['usu_nome'];
                    $usu_sobrenome = $_SESSION['usu_sobrenome'];

                    $dbCadastro = ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'db' => 'cadastro'];
                    $dbEcd      = ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'db' => 'cadastro'];

                    // ============================
                    // CONEXÕES
                    // ============================
                    $connCad = new mysqli($dbCadastro['host'], $dbCadastro['user'], $dbCadastro['pass'], $dbCadastro['db']);
                    $connEcd = new mysqli($dbEcd['host'], $dbEcd['user'], $dbEcd['pass'], $dbEcd['db']);

                    if ($connCad->connect_error) die("Erro conexão cadastro: " . $connCad->connect_error);
                    if ($connEcd->connect_error) die("Erro conexão ECD: " . $connEcd->connect_error);

                    // ============================
                    // SE NÃO HOUVE SUBMISSÃO DE ARQUIVO
                    // ============================
                    if (!isset($_POST['arquivo_id']) || empty($_POST['arquivo_id'])) {
                        echo "<div class='erro'>Selecione um arquivo para validar.</div>";
                        return;
                    }

                    $arquivo_id = (int) $_POST['arquivo_id'];

                    // ============================
                    // FUNÇÕES DE UTILIDADE
                    // ============================
                    function fetchRulesForRegistro($conn, $registro)
                    {
                        $registro = $conn->real_escape_string($registro);
                        $sql = "SELECT * FROM regras_ecd WHERE registro = '$registro' ORDER BY CAST(num AS UNSIGNED)";
                        $res = $conn->query($sql);
                        $arr = [];
                        if ($res) while ($r = $res->fetch_assoc()) $arr[] = $r;
                        return $arr;
                    }

                    function parseOcorrencia($oc)
                    {
                        if (!$oc) return [0, null];
                        $p = explode(':', $oc);
                        return [(int)$p[0], ($p[1] === 'N' ? null : (int)$p[1])];
                    }

                    function normalizeValue($v)
                    {
                        if ($v === null) return null;
                        $v = trim($v);
                        $v = str_replace('.', '', $v);
                        $v = str_replace(',', '.', $v);
                        return preg_replace('/[^\d\.-]/', '', $v);
                    }

                    // ============================
                    // CARREGA LINHAS DO ARQUIVO
                    // ============================
                    $sql = "SELECT * FROM campo 
        WHERE cam_usu_id = $usu_id AND cam_arquivo_id = $arquivo_id 
        ORDER BY cam_id ASC";

                    $res = $connCad->query($sql);

                    $linhas = [];
                    while ($row = $res->fetch_assoc()) {
                        $temp = [];
                        for ($i = 1; $i <= 35; $i++) {
                            $temp[$i] = $row["cam_$i"] ?? null;
                        }
                        $linhas[] = $temp;
                    }

                    if (empty($linhas)) {
                        echo "<div class='erro'>Arquivo vazio.</div>";
                        return;
                    }

                    // ============================
                    // ORGANIZA REGISTROS
                    // ============================
                    $regPorTipo = [];
                    foreach ($linhas as $l) {
                        $r = $l[1];
                        $regPorTipo[$r][] = $l;
                    }

                    // ============================
                    // CARREGA REGRAS (OCORRÊNCIAS)
                    // ============================
                    $rulesMeta = [];
                    $r = $connEcd->query("SELECT registro, ocorrencia FROM regras_ecd GROUP BY registro");
                    if ($r) while ($x = $r->fetch_assoc()) $rulesMeta[$x['registro']] = $x['ocorrencia'];

                    // ============================
                    // LISTAS DE ERROS E AVISOS
                    // ============================
                    $erros = [];
                    $avisos = [];

                    // ============================
                    // 1) VALIDAÇÃO ESTRUTURAL
                    // ============================
                    foreach ($linhas as $i => $linha) {
                        $num = $i + 1;
                        $reg = $linha[1];

                        $rules = fetchRulesForRegistro($connEcd, $reg);

                        if (!$rules) {
                            $avisos[] = "Linha $num: nenhuma regra encontrada para o registro $reg.";
                            continue;
                        }

                        foreach ($rules as $regra) {

                            // Corrige índice do campo (ex: "01" -> 1)
                            $campo = (int)$regra['num'];

                            $nomeCampo = $regra['campo'];

                            // Evita warnings caso o campo não exista
                            $valor = $linha[$campo] ?? null;

                            if ($regra['obrigatorio'] == 1 && ($valor === "" || $valor === null)) {
                                $erros[] = "Linha $num ($reg): Campo $campo ($nomeCampo) é obrigatório.";
                                continue;
                            }

                            if ($valor === "" || $valor === null) continue;

                            // Tipo numérico
                            if ($regra['tipo'] === 'N') {
                                $n = normalizeValue($valor);
                                if (!is_numeric($n)) {
                                    $erros[] = "Linha $num ($reg): Campo $campo ($nomeCampo) deve ser numérico. Valor recebido: '$valor'.";
                                }
                            }

                            // Tamanho
                            if (!empty($regra['tamanho']) && strlen($valor) > $regra['tamanho']) {
                                $erros[] = "Linha $num ($reg): Campo $campo ($nomeCampo) excede o tamanho máximo {$regra['tamanho']}.";
                            }

                            // Valores válidos
                            if (!empty($regra['valores_validos'])) {
                                $vv = explode(";", str_replace(['"', "'", '[', ']'], '', $regra['valores_validos']));
                                $vv = array_filter(array_map('trim', $vv));
                                if (!in_array($valor, $vv)) {
                                    $erros[] = "Linha $num ($reg): Campo $campo ($nomeCampo) contém valor inválido. Esperado: " . implode(",", $vv);
                                }
                            }
                        }
                    }

                    // ============================
                    // 2) VALIDAR OCORRÊNCIAS POR REGISTRO
                    // ============================
                    foreach ($rulesMeta as $reg => $oc) {
                        [$min, $max] = parseOcorrencia($oc);
                        $count = isset($regPorTipo[$reg]) ? count($regPorTipo[$reg]) : 0;

                        if ($min > 0 && $count < $min)
                            $erros[] = "Registro $reg: mínimo esperado $min, encontrado $count.";

                        if ($max !== null && $count > $max)
                            $erros[] = "Registro $reg: máximo permitido $max, encontrado $count.";
                    }

                    // ============================
                    // 3) REGRAS CRUZADAS (I200 x I250)
                    // ============================
                    if (isset($regPorTipo['I200'])) {

                        $i250 = $regPorTipo['I250'] ?? [];
                        $partidas = [];

                        foreach ($i250 as $p) {
                            $lcto = $p[2];
                            $partidas[$lcto][] = $p;
                        }

                        foreach ($regPorTipo['I200'] as $l) {
                            $lcto = $l[2];

                            if (!isset($partidas[$lcto])) {
                                $erros[] = "I200 $lcto: não há partidas (I250) relacionadas.";
                                continue;
                            }
                        }
                    }

                    // ============================
                    // 4) EXIBIR RESULTADO NO MESMO LAYOUT
                    // ============================

                    echo "<div class='resultado-validacao' 
      style='background:#222;padding:20px;border-radius:10px;margin-top:20px;'>";

                    echo "<h2 style='color:#00bcd4;'>Resultado da Validação</h2>";
                    echo "<p>Arquivo Nº <strong>$arquivo_id</strong></p>";
                    echo "<p>Data: " . date('d/m/Y H:i:s') . "</p><hr>";

                    if (empty($erros)) {
                        echo "<p style='color:#7dd77d;font-size:18px;'>
          ✔ Nenhum erro encontrado. Arquivo válido!
          </p>";
                    } else {
                        echo "<p style='color:#ff7070;font-size:18px;'>⚠ Foram encontrados " . count($erros) . " erros:</p>";
                        echo "<pre style='white-space:pre-wrap;color:#ffaaaa;font-size:14px;'>";
                        foreach ($erros as $e) echo $e . "\n";
                        echo "</pre>";
                    }

                    if (!empty($avisos)) {
                        echo "<p style='color:#ffd26b;font-size:18px;'>⚠ Avisos (" . count($avisos) . "):</p>";
                        echo "<pre style='white-space:pre-wrap;color:#fff2aa;font-size:14px;'>";
                        foreach ($avisos as $a) echo $a . "\n";
                        echo "</pre>";
                    }

                    echo "</div>";

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