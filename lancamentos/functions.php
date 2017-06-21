<?php
require_once('../config.php');
require_once(DBAPI);
$lancamentos = null;
$lancamento = null;
/**
 *  Listagem de Clientes
 */
function index() {
	global $lancamentos;
	$lancamentos = find_all('lancamentos');
}

/**
 *  Cadastro de Clientes
 */
function add() {
  if (!empty($_POST['customer'])) {
    
    $today = 
      date_create('now', new DateTimeZone('America/Sao_Paulo'));
    $lancamento = $_POST['customer'];
    $lancamento['modified'] = $lancamento['created'] = $today->format("Y-m-d H:i:s");
    
    save('lancamentos', $lancamento);
    header('location: index.php');
  }
}

/**
 *	Atualizacao/Edicao de Cliente
 */
function edit() {
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['customer'])) {
      $lancamento = $_POST['customer'];
      $lancamento['modified'] = $now->format("Y-m-d H:i:s");
      update('lancamentos', $id, $lancamento);
      header('location: index.php');
    } else {
      global $lancamento;
      $lancamento = find('lancamentos', $id);
    } 
  } else {
    header('location: index.php');
  }
}

/**
 *  Exclusão de um Cliente
 */
function delete($id = null) {
  global $lancamento;
  $lancamento = remove('lancamentos', $id);
  header('location: index.php');
}