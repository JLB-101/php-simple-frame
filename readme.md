# about piecing:
/* 
* framework: v1.0
* Name: Piecing
* Description: " modular and lightweight PHP framework built incrementally to facilitate secure, rapid information transport."
* By: kuzacraft.com
* Last-realize: 15/11/2024
*/

# Estrutura de Diretórios:
project-root/
│
├── app/
│   ├── Controllers/
│   │   └── PageController.php
│   └── (outros arquivos da app: mvc)
│
├── src/ (ou piecing - parts)
│   ├── routing/
│   │   ├── Router.php
│   │   └── Route.php
│   └── (outros arquivos ou parts )
│
├── vendor/
├── composer.json
└── (outros arquivos do projeto)


Com essa configuração, a estrutura de diretórios seria algo como:
# Explicação:

    "piecing\": "src/": Este mapeia o namespace piecing para o diretório src/. Então todas as classes com o namespace piecing (como piecing\routing\Router) deverão estar dentro do diretório src/.

    "app\": "app/": Este mapeia o namespace app para o diretório app/. Então todas as classes com o namespace app (como app\Controllers\PageController) deverão estar dentro do diretório app/.

# Observações importantes:

    O diretório app/ deve estar na raiz do seu projeto, como um diretório separado, e não dentro de src/, para garantir que o Composer consiga localizar corretamente as classes do namespace app.

    Após fazer essas modificações no composer.json, execute o comando:

    composer dump-autoload

    Isso vai atualizar o autoloader do Composer e refletir as alterações feitas.

Teste:

Depois de fazer essas modificações, se você rodar o código abaixo, ele deve retornar bool(true) se a classe for encontrada: