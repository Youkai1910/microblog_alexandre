# Resumo da branch `07_aula-1311`

Registro do trabalho realizado em 13/11/2026 nesta branch.

## Cadastro de notícias

- Criado o serviço de notícias com inserção no banco por consulta preparada e associação dos campos do modelo.
- Adicionado tratamento de falhas na inserção, com registro do erro e propagação de uma mensagem de exceção.
- Ajustado o modelo `Noticia` para receber os dados de uma notícia e permitir que ID e data sejam opcionais na criação.
- Implementado o formulário administrativo para cadastrar notícias: carrega categorias, recebe título, texto, resumo, imagem e opção de destaque.
- Inicializados os valores do formulário e preservados os campos de texto enviados quando ocorre um erro.
- Incluídas validações para categoria, título, texto, resumo e destaque antes do envio da imagem.
- Após o cadastro bem-sucedido, o usuário é redirecionado para a listagem de notícias; erros de validação são exibidos no formulário e falhas inesperadas são registradas no log.

## Imagens

- Adicionadas à pasta `images` as imagens `felicidade.jpg`, `mais.jpg` e `sanduiche.jpg`.
