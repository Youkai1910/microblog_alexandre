<?php

use Microblog\Auth\ControleDeAcesso;
use Microblog\Helpers\Utils;
use Microblog\Services\UsuarioServico;

require_once __DIR__ . '/../vendor/autoload.php';

ControleDeAcesso::exigirAdmin();

$id = Utils::normalizarEntrada($_GET['id'] ?? null, 'inteiro');
Utils::verificarId($id);

// Impedindo a exclusão do próprio usuário logado
if($id === $_SESSION['id']){
    Utils::alertaErro("Não é possivel excluir a própria conta.");
}

try {
$usuario = new UsuarioServico();
$usuario->excluir($id);
header("location:usuarios.php");
exit;
} catch (Throwable $e) {
Utils::registrarLog($e);
Utils::alertaErro("Nao foi possivel excluir o usuário. Tente novamente");
}
