<?php

use Microblog\Helpers\Utils;
use Microblog\Services\NoticiaServico;

require_once __DIR__ . '/../vendor/autoload.php';

$listaDeNoticias = [];
$mensagemErroNoticias = '';

try {
    $noticiaServico = new NoticiaServico();
    $listaDeNoticias = $noticiaServico->listarTodasPublicas();
} catch (Throwable $e) {
    Utils::registrarLog($e);
    $mensagemErroNoticias = 'Não foi possível carregar a lista de notícias.';
}

?>
<hr class="my-5 w-50 mx-auto">

<div class="row my-1">
    <div class="col-12 px-md-1">
        <div class="list-group">
            <h2 class="fs-6 text-center text-muted">Todas as notícias</h2>

            <?php if ($mensagemErroNoticias !== ''): ?>
                <p class="alert alert-danger"><?= Utils::escaparHtml($mensagemErroNoticias) ?></p>
            <?php elseif ($listaDeNoticias === []): ?>
                <p class="text-center text-muted">Nenhuma notícia cadastrada.</p>
            <?php else: ?>
                <?php foreach ($listaDeNoticias as $noticia): ?>
                    <a href="noticia.php?id=<?= Utils::escaparHtml($noticia['id']) ?>" class="list-group-item list-group-item-action">
                        <h3 class="fs-6"><time datetime="<?= Utils::escaparHtml(date('Y-m-d', strtotime($noticia['data']))) ?>"><?= Utils::escaparHtml(Utils::formataData($noticia['data'])) ?></time> - <?= Utils::escaparHtml($noticia['titulo']) ?></h3>
                        <p><?= Utils::escaparHtml($noticia['resumo']) ?></p>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
