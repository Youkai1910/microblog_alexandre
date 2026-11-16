<?php

use Microblog\Auth\ControleDeAcesso;
use Microblog\Helpers\Utils;
use Microblog\Services\NoticiaServico;

require_once __DIR__ . '/../vendor/autoload.php';

ControleDeAcesso::exigirLogin();

$id = Utils::normalizarEntrada($_GET['id'] ?? null, 'inteiro');
Utils::verificarId($id);

try {
    $noticiaServico = new NoticiaServico();
    $noticiaServico->excluir($id);

    header('location:noticias.php');
    exit;
} catch (Throwable $e) {
    Utils::registrarLog($e);
    Utils::alertaErro('Não foi possível excluir a notícia. Ela pode não existir ou você não ter permissão.');
}
