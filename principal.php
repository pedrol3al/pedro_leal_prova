<?php
session_start();
require_once("conexao.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

//  OBTENDO O NOME DO PERFIL DO USUARIO LOGADO

$id_perfil = $_SESSION['perfil'];
$sqlPerfil = 'SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil';
$stmtPerfil = $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(':id_perfil', $id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil['nome_perfil'];

//DEFINIÇÃO DAS PERMISSÕES POR PERFIL

$permissoes = [

    1 => ["Cadastrar" => ["cadastro_usuario.php", "cadastro_perfil", "cadastro_cliente.php", "cadastro_fornecedor.php", "cadastro_produto.php", "cadastro_funcionario.php"]],

    "buscar" => ["buscar_usuario.php", "buscar_perfil", "buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php", "buscar_funcionario.php"],

    "alterar" => ["alterar_usuario.php", "alterar_perfil", "alterar_cliente.php", "alterar_fornecedor.php", "alterar_produto.php", "alterar_funcionario.php"],

    "excluir" => ["excluir_usuario.php", "excluir_perfil", "excluir_cliente.php", "excluir_fornecedor.php", "excluir_produto.php", "excluir_funcionario.php"],


    2 => ["Cadastrar" => ["cadastro_cliente.php"]],
    
    "Buscar" => [ "buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],

    "Alterar" => [ "alterar_fornecedor.php", "alterar_produto.php"],

    "Excluir" => ["excluir_produto.php"]]


    ?>