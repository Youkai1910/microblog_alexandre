# Resumo da branch `08_aula-1311`

Registro do trabalho realizado em 13/11/2026 nesta branch.

## Listagem administrativa de notícias

- Implementado `NoticiaServico::listarTodos()` com resultados conforme o usuário autenticado: administradores recebem todas as notícias com o nome do autor; editores recebem somente as próprias notícias, sem o nome do autor.
- Atualizada a página `admin/noticias.php` para carregar e exibir os registros do serviço em vez de usar dados estáticos.
- A tabela mostra título, data formatada, destaque e operações; a coluna de autor é exibida somente para administradores.
- Adicionados contador dinâmico, mensagem para lista vazia e tratamento de erros com registro no log e aviso ao usuário.
