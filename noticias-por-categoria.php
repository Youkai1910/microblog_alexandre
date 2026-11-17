<?php

use Microblog\Helpers\Utils;
use Microblog\Services\CategoriaServico;
use Microblog\Services\NoticiaServico;

require_once __DIR__ . '/vendor/autoload.php';

$id = Utils::normalizarEntrada($_GET['id'] ?? null, 'inteiro');
Utils::verificarId($id);

$dadosCategoria = null;
$listaDeNoticias = [];
$mensagemErro = '';

try {
    $categoriaServico = new CategoriaServico();
    $dadosCategoria = $categoriaServico->buscarPorId($id);

    if ($dadosCategoria !== null) {
        $noticiaServico = new NoticiaServico();
        $listaDeNoticias = $noticiaServico->listarPublicasPorCategoria($id);
    }
} catch (Throwable $e) {
    Utils::registrarLog($e);
    $mensagemErro = 'Não foi possível carregar as notícias desta categoria.';
}

require_once __DIR__ . '/includes/cabecalho.php';
?>

<div class="row my-1 mx-md-n1">

    <article class="col-12">
        <?php if ($dadosCategoria !== null): ?>
            <h2 class="text-center">
                Notícias sobre <span class="badge bg-primary"><?= Utils::escaparHtml($dadosCategoria['nome']) ?></span>
            </h2>
        <?php else: ?>
            <h2 class="text-center">Notícias por categoria</h2>
        <?php endif; ?>

        <div class="row my-1">
            <div class="col-12 px-md-1">
                <div class="list-group">
                    <?php if ($mensagemErro !== ''): ?>
                        <p class="alert alert-danger"><?= Utils::escaparHtml($mensagemErro) ?></p>
                    <?php elseif ($dadosCategoria === null): ?>
                        <p class="alert alert-warning">A categoria solicitada não foi encontrada.</p>
                    <?php elseif ($listaDeNoticias === []): ?>
                        <p class="text-center text-muted">Não há notícias cadastradas nesta categoria.</p>
                    <?php else: ?>
                        <?php foreach ($listaDeNoticias as $noticia): ?>
                            <?php
                            $autor = trim((string) ($noticia['autor'] ?? ''));
                            if ($autor === '') {
                                $autor = 'Equipe Microblog';
                            }
                            ?>
                            <a href="noticia.php?id=<?= Utils::escaparHtml($noticia['id']) ?>" class="list-group-item list-group-item-action">
                                <h3 class="fs-6"><?= Utils::escaparHtml($noticia['titulo']) ?></h3>
                                <p><time datetime="<?= Utils::escaparHtml(date('Y-m-d', strtotime($noticia['data']))) ?>"><?= Utils::escaparHtml(date('d/m/Y', strtotime($noticia['data']))) ?></time> - <?= Utils::escaparHtml($autor) ?></p>
                                <p><?= Utils::escaparHtml($noticia['resumo']) ?></p>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </article>
</div>

<?php
require_once __DIR__ . '/includes/todas.php';
require_once __DIR__ . '/includes/rodape.php';
?>
