# Resumo da branch `09_aula1611`

Registro do trabalho realizado em 16/11/2026 nesta branch. Este resumo cobre somente as alterações da branch `09_aula1611`.

## Documentação e organização do projeto

- Criado e atualizado `AGENTS.md` com a estrutura do projeto, convenções, configuração local, schema do banco e estado das funcionalidades.
- Organizadas as imagens do site no diretório `images/`.
- Ajustada a configuração local da conexão com o banco de dados para remover a senha padrão registrada no código.

## Administração de notícias

- Implementado `NoticiaServico::buscarPorId()` para carregar os dados da notícia, categoria e autor. Administradores podem consultar qualquer notícia; editores só podem consultar as próprias.
- A página `admin/noticia-atualiza.php` usa o ID recebido pelo link da listagem, carrega todos os campos atuais e as categorias disponíveis, selecionando a categoria da notícia.
- Implementado `NoticiaServico::atualizar()` e conectado o formulário de edição ao fluxo POST. O servidor valida os campos, mantém a imagem existente quando nenhum arquivo novo é enviado e usa `Utils::upload()` quando há substituição. A atualização limita editores às próprias notícias.
- Implementado `NoticiaServico::excluir()` com autorização aplicada na consulta SQL. A página `admin/noticia-exclui.php` valida o ID, executa a exclusão e redireciona à listagem em caso de sucesso; tentativa sem notícia correspondente ou sem permissão é bloqueada.

## Verificação

- Executado `php -l` nos arquivos PHP alterados para carregar, atualizar e excluir notícias; a sintaxe foi aprovada.
