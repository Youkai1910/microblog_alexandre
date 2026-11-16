# Prompts utilizados no desenvolvimento (GitHub Copilot)

## 1. Atualização de Notícias (`noticia-atualiza`)

**Prompt utilizado:**
> Com base na estrutura e nos padrões do meu projeto, crie um novo método na classe de Notícias para atualizar os dados de uma notícia existente no banco de dados. Em seguida, programe a página `noticia-atualiza.php` para carregar os dados atuais da notícia no formulário, processar o envio e salvar as alterações (incluindo o tratamento da imagem, caso uma nova seja enviada). Respeite as regras de permissão de acesso do sistema: se o usuário não for administrador (`!$usuarioEhAdmin`), ele só pode visualizar e atualizar as notícias criadas por ele mesmo.

---

## 2. Exclusão de Notícias (`noticia-exclui`)

**Prompt utilizado:**
> Com base na estrutura do meu projeto, crie um novo método na classe de Notícias para excluir uma notícia do banco de dados a partir do seu ID. Em seguida, programe a página `noticia-exclui.php` para executar essa exclusão e redirecionar o usuário de volta para a listagem de notícias. Inclua uma verificação de segurança para garantir que usuários que não são administradores (`!$usuarioEhAdmin`) só consigam excluir suas próprias notícias, bloqueando a ação caso tentem apagar a notícia de outro autor.
