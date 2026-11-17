<?php

use Microblog\Helpers\Utils;
use Microblog\Services\NoticiaServico;

require_once __DIR__ . '/vendor/autoload.php';

$id = Utils::normalizarEntrada($_GET['id'] ?? null, 'inteiro');
Utils::verificarId($id);

$dadosNoticia = null;
$mensagemErro = '';

try {
    $noticiaServico = new NoticiaServico();
    $dadosNoticia = $noticiaServico->buscarPublicaPorId($id);
} catch (Throwable $e) {
    Utils::registrarLog($e);
    $mensagemErro = 'Não foi possível carregar os dados da notícia.';
}

$autor = trim((string) ($dadosNoticia['autor'] ?? ''));
if ($autor === '') {
    $autor = 'Equipe Microblog';
}

require_once __DIR__ . '/includes/cabecalho.php';
?>

<div class="row my-1 mx-md-n1">

    <article class="col-12">
        <?php if ($mensagemErro !== ''): ?>
            <p class="alert alert-danger"><?= Utils::escaparHtml($mensagemErro) ?></p>
        <?php elseif ($dadosNoticia === null): ?>
            <p class="alert alert-warning">A notícia solicitada não foi encontrada.</p>
        <?php else: ?>
            <h2><?= Utils::escaparHtml($dadosNoticia['titulo']) ?></h2>
            <p class="font-weight-light">
                <time datetime="<?= Utils::escaparHtml(date('Y-m-d', strtotime($dadosNoticia['data']))) ?>"><?= Utils::escaparHtml(date('d/m/Y', strtotime($dadosNoticia['data']))) ?></time> -
                <span><?= Utils::escaparHtml($autor) ?></span>
            </p>
            <img src="images/<?= Utils::escaparHtml($dadosNoticia['imagem']) ?>" alt="<?= Utils::escaparHtml($dadosNoticia['titulo']) ?>" class="float-start pe-2 img-fluid">
            <p class="ajusta-texto"><?= Utils::escaparHtml($dadosNoticia['texto']) ?></p>
        <?php endif; ?>
    </article>
    
</div>

<?php
require_once __DIR__ . '/includes/todas.php';
require_once __DIR__ . '/includes/rodape.php';
?>
