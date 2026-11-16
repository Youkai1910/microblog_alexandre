# Guia de desenvolvimento do Microblog

## Visão geral

Aplicação de microblog em PHP, com páginas públicas e uma área administrativa para usuários autenticados. A interface e as mensagens estão em português. O código de domínio fica em `src/`; as páginas PHP são organizadas na raiz, em `admin/` e em `includes/`.

## Ambiente e execução

- O projeto foi preparado para desenvolvimento local com XAMPP, Apache, PHP e MySQL em `localhost`.
- A conexão atual está configurada em `src/Database/ConexaoBD.php`: banco `microblog_2026`, usuário `root`, senha vazia e charset `utf8mb4`. Ajuste essa configuração para o ambiente local antes de executar, sem incluir credenciais no repositório.
- Para criar e popular o banco, use `_materiais/microblog_2026_completo.sql` no MySQL/phpMyAdmin. Esse dump contém tabelas e dados de demonstração.
- O autoload Composer usa PSR-4: `Microblog\` aponta para `src/`. As páginas carregam `vendor/autoload.php`.
- O código usa recursos de PHP 8.1 ou posterior, incluindo enums e tipos `mixed`.
- `composer.json` não declara dependências adicionais nem scripts de build, lint ou teste. Não há suíte de testes automatizados configurada no repositório.
- Para validar alterações PHP, rode `php -l caminho\do\arquivo.php` nos arquivos alterados. Em mudanças que adicionem classes ou namespaces, atualize/verifique o autoload Composer (`composer dump-autoload`) se necessário. Para alterações de banco ou fluxo, complemente com teste manual no ambiente local.

## Estrutura

- `src/Auth/`: controle de sessão e autorização.
- `src/Database/`: conexão PDO.
- `src/Enums/`: tipos de usuário e estado de destaque.
- `src/Helpers/`: normalização, validação, escape, logs, senha, datas e upload.
- `src/Models/`: entidades `Usuario`, `Categoria` e `Noticia`.
- `src/Services/`: operações PDO para usuários, categorias e notícias.
- `admin/`: painel, formulários e listagens administrativas.
- `includes/`: cabeçalhos, rodapés e componentes reaproveitados da área pública e administrativa.
- `images/`: imagens usadas pelo site e destino dos uploads de notícias.
- `css/`, `js/`: estilos e scripts do navegador.
- `_materiais/`: dumps SQL e documentação de apoio; confira se ainda correspondem ao código antes de tratá-los como especificação atual.
- `logs/erros.log`: destino esperado dos logs de exceção.

## Arquitetura e convenções

- Use namespaces sob `Microblog\`, seguindo a estrutura de pastas e o mapeamento PSR-4 existente.
- Nomes de classes, enums e arquivos de classe usam PascalCase; métodos, propriedades e variáveis usam camelCase. Os nomes de domínio e mensagens seguem o português já utilizado no projeto.
- Modelos são classes `final` com propriedades privadas tipadas, construtores que recebem os dados e getters. O padrão atual não faz validação dentro dos modelos; a validação fica nos helpers e nas páginas que recebem entradas.
- Serviços são classes `final`, instanciam a conexão via `ConexaoBD::getConexao()` e recebem modelos tipados para inserção/atualização. Consultas com entrada variável devem usar `prepare()` e parâmetros vinculados; consultas sem entrada podem usar `query()`.
- A conexão PDO está configurada para lançar exceções e retornar linhas como arrays associativos (`PDO::FETCH_ASSOC`).
- Para falhas de persistência, os serviços registram a exceção com `Utils::registrarLog()` e lançam uma exceção com mensagem genérica para a interface. Nas páginas, apresente mensagens compreensíveis, sem revelar detalhes internos, e registre erros inesperados.
- Use `Utils::normalizarEntrada()` para entradas de formulário e URL: o padrão e o modo `email` retornam strings aparadas; o modo `inteiro` valida com `FILTER_VALIDATE_INT` e retorna `0` se inválido. Use `Utils::verificarId()` para IDs de URL positivos.
- Use `Validacoes` para validar os campos recebidos. Os métodos atuais cobrem nome, e-mail, senha, tipo de usuário, título, texto, resumo, destaque e categoria. Tipos aceitos vêm dos enums `TipoUsuario` (`admin`, `editor`) e `Destaque` (`sim`, `nao`).
- Valide dados no servidor mesmo quando o formulário também restringir opções ou comprimentos.
- Escape sempre dados dinâmicos ao renderizar HTML com `Utils::escaparHtml()`. A normalização padrão remove espaços externos, mas preserva o texto; escape é responsabilidade da saída, não substitua por sanitização destrutiva.
- Senhas novas devem ser armazenadas com `Utils::codificarSenha()` (`password_hash`) e verificadas com `password_verify()`. Em formulários de edição, mantenha o hash existente quando a senha não for alterada; use `Utils::verificarSenha()` quando aplicável.
- Páginas administrativas incluem `vendor/autoload.php` e protegem o acesso com `ControleDeAcesso`. `includes/cabecalho-admin.php` também exige login; use `exigirAdmin()` nas operações exclusivas de administrador. O controle atual distingue `admin` e `editor`.
- Redirecionamentos após operações bem-sucedidas usam `header()` seguido de `exit`.
- Reutilize os helpers, modelos, enums e serviços existentes em vez de duplicar suas responsabilidades. Preserve o comportamento atual e mantenha alterações focadas.

## Uploads de imagem

`Utils::upload()` é o caminho comum para imagens de notícias. Ele valida o upload, limita o tamanho a 2 MB, confere o MIME e a extensão para JPEG, GIF, PNG ou WebP, limita o nome a 60 caracteres e salva em `images/`. Formulários com upload precisam de `enctype="multipart/form-data"`. Não confie apenas no atributo `accept` do HTML.

## Banco de dados e domínio

O schema atual tem as tabelas `usuarios`, `categorias` e `noticias`:

- Usuários possuem nome, e-mail único, hash de senha e tipo (`admin` ou `editor`).
- Categorias possuem nome.
- Notícias possuem data, título, texto, resumo, imagem, destaque (`sim` ou `nao`) e referências opcionais a usuário e categoria. As chaves estrangeiras do dump permitem `ON DELETE SET NULL`.
- A aplicação limita o resumo a 300 caracteres em `Validacoes`, embora o schema do dump aceite até 500 (`VARCHAR(500)`). Preserve a validação da aplicação, a menos que o requisito peça explicitamente alterá-la.

`_materiais/modelagem-fisica.md` está desatualizado em relação ao banco ativo: menciona `microblog_2025`, enquanto o código e os dumps atuais usam `microblog_2026`. Para o schema executável, confira a conexão e o dump `microblog_2026_completo.sql`.

## Funcionalidades e estado atual

- Login consulta usuário por e-mail, verifica o hash da senha e inicia uma sessão com ID, nome e tipo.
- Administradores gerenciam usuários e categorias. Editores acessam o painel de notícias e a listagem é limitada às notícias próprias.
- `NoticiaServico::listarTodos()` lista todas as notícias com autor para administradores e apenas as do usuário autenticado para outros usuários.
- `NoticiaServico::buscarPorId()`, `atualizar()` e `excluir()` permitem ao administrador operar qualquer notícia e restringem editores às notícias associadas ao ID da própria sessão.
- A inserção de notícia valida os campos, categoria e destaque e processa imagem por `Utils::upload()`.
- Usuários e categorias possuem serviços de listagem, busca, inserção, atualização e exclusão.
- `admin/noticia-atualiza.php` carrega e valida os campos para atualizar uma notícia, mantendo a imagem existente quando um novo arquivo não é enviado. `admin/noticia-exclui.php` remove a notícia com a checagem de autoria aplicada no serviço.
- As páginas públicas (`index.php`, `noticia.php`, `noticias-por-categoria.php` e a listagem em `includes/todas.php`) ainda apresentam conteúdo estático/provisório em vez de consultar o banco.
- `resumo.md` registra o contexto recente de implementação da listagem administrativa de notícias; é uma nota de trabalho, não uma especificação geral.

## Cuidados ao alterar

- `NoticiaServico::listarTodos()` depende de sessão ativa e valida que `$_SESSION['id']` seja um inteiro. Preserve o fluxo de autenticação quando mudar a consulta ou suas chamadas.
- A propriedade `usuario_id` determina a autoria; não aceite do formulário um ID de autor que possa substituir o usuário autenticado.
- Mantenha nomes de parâmetros SQL consistentes com os getters dos modelos e com as colunas existentes no schema.
- Ao alterar schema, atualize o dump/documentação pertinente e verifique efeitos nas consultas e nos formulários relacionados.
- Evite tratar páginas provisórias como implementações funcionais e não amplie seu escopo sem requisito explícito.
