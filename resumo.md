# Resumo do histórico de desenvolvimento

Este resumo considera a branch `01_aula-0311`, desde a versão inicial até o commit `03d0786` (03/11/2026).

## Visão geral

O projeto é um microblog em PHP com área pública para consulta de notícias e área administrativa para gerenciamento de conteúdo e usuários. A versão inicial já incluía páginas públicas, telas e operações administrativas, modelos, validações, utilitários, conexão com o banco de dados e arquivos SQL com dados iniciais.

## Principais etapas da branch

1. **Organização do código e autoload** — `5909c32` (`Adiciona autoload PSR-4 e namespaces`)
   - Configurou o autoload PSR-4 do Composer para o namespace `Microblog\`.
   - Organizou namespaces de enums, helpers e modelos.
   - Tornou os modelos finais e adicionou `vendor/` ao `.gitignore`.

2. **Serviço de usuários** — `71fa5ea` (`Adicionar serviço de usuário com conexão ao banco de dados`)
   - Criou `UsuarioServico`, responsável por obter a conexão via `ConexaoBD`.

3. **Consulta de usuários** — `6f1331e` (`Adicionar método de serviço para listagem de usuários`)
   - Implementou `listarTodos()`, que consulta `id`, `nome`, `email` e `tipo` na tabela `usuarios`, ordenando pelo nome.
   - Incluiu registro de falhas de consulta e uma exceção com mensagem genérica.

4. **Integração com o painel** — `cddb2d1` (`Carrega usuários no painel administrativo`)
   - Conectou a página de administração de usuários ao novo serviço.
   - Acrescentou tratamento de falha ao carregar os dados.

5. **Exibição de usuários reais** — `03d0786` (`Renderiza usuários reais na administração`)
   - Atualizou a tela para exibir os registros retornados do banco, a contagem de usuários e as ações de atualização e exclusão.
   - Aplicou escape aos dados apresentados na página.

## Estado registrado no último commit

A listagem administrativa utiliza `UsuarioServico::listarTodos()` para carregar os usuários e apresenta uma mensagem amigável quando a consulta falha. O histórico analisado não registra commits posteriores a `03d0786`.
