<?php
$servidor = "127.0.0.1"; // Define o endereço do servidor de banco de dados
$usuario = "root"; // Define o nome de usuário para acessar o banco de dados
$senha = ""; // Define a senha para acessar o banco de dados
$bancoDados = "cadastro"; //Define o nome do banco de dados que será utilizado

//Estabelece uma conexão com o banco de dados usando os dados fornecidos
$conexao = mysqli_connect($servidor,$usuario,$senha,$bancoDados)
or die ("problemas para conectar no banco, verifique os dados!!");
// Se a conexão falhar, exibe uma mensagem de erro e encerra o script
?>