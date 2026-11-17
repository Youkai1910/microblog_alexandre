# Prompts utilizados no desenvolvimento (GitHub Copilot)

## 1.Menu de categorias 
use os arquivos agents.md e siga os codigos da pasta src não quero PDO 
Programe no includes/cabecalho.php para fazer com que o menu mostre todas as categorias.

## 2.Pagina Inicial
agora programar os destaques no index.php usando classes existentes no projeto senguindo o os arquivos agents.md
não quero PDO Para cada notícia marcada como destaque, exiba a imagem, o título e o resumo. Configure o link dinamico para abrir noticia.php 

## 3.Pagina Inicial 
vamos programar a listas de todas as noiticias cadastradas no banco de dados usando as classes do projeto seguindo os arquivos agents.md
quero manter o html/css configure o link dinamico de cada noticia para abrir noticia.php com o respectivo ID.

## 4.Detalhes da noticia
continue seguindo o que tem nos arquivos agents.md não quero PDO. No arquivo noticia.php
capture o ID da notícia recebido via URL ($_GET) e busque os dados completos usando as classes do projeto. Exiba o título, a data formatada no padrão brasileiro (dia/mês/ano), o autor, a imagem e o texto completo. Regra importante: caso a notícia não tenha um autor associado (nulo ou vazio), exiba o texto 'Equipe Microblog' como alternativa.

## 5.Filtro por Categoria
continua seguindo o arquivos agents.md, não quero PDO. No noticias-por-categoria.php capture o ID da categoria vindo da URL e liste apenas as notícias pertencentes a ela usando as classes do projeto. Para cada notícia, exiba: título, data formatada (dia/mês/ano), autor e resumo. Se não houver autor associado, exiba 'Equipe Microblog'. Configure o link dinâmico de cada item para abrir noticia.php com o ID da notícia.

## 6.Sistema de Busca Back-end
Analise primeiro a estrutura do formulário de busca no cabeçalho para garantir que os IDs e classes HTML batam com o JavaScript. (Não quero PDO)
continue seguindo o arquivos agents.md programe o arquivo resultados.php para receber o termo pesquisado via Get e POST conforme utilizado no projeto
consulta o banco de dados usando as classes e as operações

## 7.Sistema de Busca Front-end
continue seguindo os arquivos agents.md analise o arquivo include/cabecalho.php e programe o busca.js usando o JavaScript moderno para enviar o termo digitado para resultados.php de forma assincrona, sem recarregar a pagina, e renderize a resposta na área de resultados do front-end. (Não quero PDO)

 
