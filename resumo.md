# Resumo da branch `05_alua-1011`

Este resumo registra somente as mudanças acrescentadas nesta branch, após a branch `04_exercicio-categorias`.

## Exclusão de usuários

- **Exclusão no serviço e na área administrativa** — `64ef435` (`Implementa exclusão de usuários`)
  - Adicionou a exclusão de usuários ao serviço e conectou a ação administrativa ao banco.
  - Normalizou e verificou o ID recebido, registrando falhas e apresentando uma mensagem de erro quando necessário.
- **Correção de acentuação** — `4b857f9` (`Corrige acentuação na mensagem de exclusão`)
  - Corrigiu a mensagem de retorno relacionada à exclusão.

## Controle de acesso por sessão

- **Auxiliar de sessão** — `412c359` (`Adicionar auxiliar de controle de acesso baseado em sessão`)
  - Criou `ControleDeAcesso` para iniciar e encerrar sessões, exigir uma sessão autenticada e redirecionar visitantes não autenticados para o login.
- **Proteção da área administrativa** — `932659f` (`Protege o cabeçalho administrativo`)
  - Aplicou a verificação de login ao cabeçalho compartilhado da administração.
- **Operações de login e logout** — `89adc26` (`Adiciona login e logout à autenticação`)
  - Acrescentou ao auxiliar os métodos para armazenar os dados de usuário na sessão e encerrar a sessão durante o logout.

## Validação e feedback no login

- **Campos e mensagens** — `1477a8a` (`Validar campos de login e exibir feedback`)
  - Normalizou o e-mail enviado e interrompeu o envio quando e-mail ou senha estão vazios.
  - Acrescentou mensagens para campos obrigatórios, credenciais incorretas, logout, acesso não autorizado e falha no login.

## Resultado

Esta branch acrescenta ao projeto a exclusão de usuários e as bases de controle de acesso por sessão, além da validação dos campos e do feedback exibido pela página de login. As funcionalidades de categorias descritas no resumo da branch 4 não fazem parte das mudanças exclusivas desta branch.
