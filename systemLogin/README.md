# Sistema de Login Seguro com PHP e MySQL

Este é um sistema simples de login criado usando PHP e MySQL, com foco na segurança. O código original foi baseado no tutorial do site [CodeShack](https://codeshack.io/secure-login-system-php-mysql/), e algumas modificações foram feitas, como a utilização de conexão com o MySQL por meio de PDO, técnicas para prevenção de SQL injection, e controle de acesso a páginas específicas.

## Funcionalidades

- **Login Seguro:** Utiliza boas práticas de segurança, como prepare e bind, para prevenir SQL injection.

- **Controle de Acesso:** Apenas usuários autenticados podem acessar determinadas páginas, como `profile.php` e `home.php`. Caso não esteja autenticado, o usuário será redirecionado para a tela de login.

## Pré-requisitos

- Servidor web (por exemplo, Apache)
- PHP
- MySQL

## Agradecimentos

- [CodeShack](https://codeshack.io/) pela inspiração e base do código original.
- Comunidade de desenvolvedores PHP e MySQL.
