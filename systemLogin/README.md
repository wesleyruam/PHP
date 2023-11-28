# Sistema de Login Seguro com PHP e MySQL

Este é um sistema simples de login criado usando PHP e MySQL, com foco na segurança. O código original foi baseado no tutorial do site [CodeShack](https://codeshack.io/secure-login-system-php-mysql/), e algumas modificações foram feitas, como a utilização de conexão com o MySQL por meio de PDO, técnicas para prevenção de SQL injection, e controle de acesso a páginas específicas.

## Funcionalidades

- **Login Seguro:** Utiliza boas práticas de segurança, como prepare e bind, para prevenir SQL injection.

- **Controle de Acesso:** Apenas usuários autenticados podem acessar determinadas páginas, como `profile.php` e `home.php`. Caso não esteja autenticado, o usuário será redirecionado para a tela de login.

## Pré-requisitos

- Servidor web (por exemplo, Apache)
- PHP
- MySQL

## Configuração

1. Clone o repositório:

    ```bash
    git clone https://github.com/seu-usuario/seu-projeto.git
    ```

2. Importe o arquivo SQL fornecido (`database.sql`) para criar a estrutura do banco de dados.

3. Configure as informações de conexão com o banco de dados em `config.php`.

4. Inicie o servidor web e abra o projeto no navegador.

## Contribuições

Contribuições são bem-vindas! Se você encontrar problemas ou melhorias potenciais, sinta-se à vontade para abrir uma issue ou enviar um pull request.

## Agradecimentos

- [CodeShack](https://codeshack.io/) pela inspiração e base do código original.
- Comunidade de desenvolvedores PHP e MySQL.
