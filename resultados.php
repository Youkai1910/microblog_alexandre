<?php

use Microblog\Helpers\Utils;
use Microblog\Services\NoticiaServico;

require_once __DIR__ . '/vendor/autoload.php';

header('Content-Type: text/html; charset=UTF-8');

$entradaBusca = $_POST['busca'] ?? $_GET['busca'] ?? '';
$termoBusca = Utils::normalizarEntrada($entradaBusca);
$resultados = [];
$mensagemErro = '';

if ($termoBusca !== '') {
    if (mb_strlen($termoBusca) > 100) {
        $mensagemErro = 'A busca deve ter no máximo 100 caracteres.';
    } else {
        try {
            $noticiaServico = new NoticiaServico();
            $resultados = $noticiaServico->buscarPublicasPorTermo($termoBusca);
        } catch (Throwable $e) {
            Utils::registrarLog($e);
            $mensagemErro = 'Não foi possível realizar a busca.';
        }
    }
}

if ($mensagemErro !== ''): ?>
    <p class="text-danger mb-0"><?= Utils::escaparHtml($mensagemErro) ?></p>
<?php elseif ($termoBusca === ''): ?>
    <p class="text-muted mb-0">Digite um termo para pesquisar.</p>
<?php elseif ($resultados === []): ?>
    <p class="text-muted mb-0">Nenhuma notícia encontrada.</p>
<?php else: ?>
    <h2 class="fs-5">Resultados: <span class="badge rounded-pill text-bg-success"><?= Utils::escaparHtml(count($resultados)) ?></span></h2>
    <div class="list-group">
        <?php foreach ($resultados as $noticia): ?>
            <a class="list-group-item list-group-item-action" href="noticia.php?id=<?= Utils::escaparHtml($noticia['id']) ?>">
                <h3 class="fs-6 mb-1"><?= Utils::escaparHtml($noticia['titulo']) ?></h3>
                <p class="mb-0"><?= Utils::escaparHtml($noticia['resumo']) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
