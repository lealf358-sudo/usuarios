# API REST de Usuários

## Identificação

**Nome:** Francisco Leal
**Curso:** Técnico em Informática
**Disciplina:** Desenvolvimento de Serviços Web
**Tecnologia:** PHP + Slim Framework

## Sobre o projeto

Este projeto consiste em uma API REST desenvolvida em PHP utilizando o Slim Framework.

A API permite cadastrar, consultar, editar e excluir usuários, além de realizar login e alteração de senha.

Os dados são enviados e recebidos no formato JSON.

## Tecnologias utilizadas

* PHP
* Slim Framework
* Composer
* Postman
* JSON

## Instalação

Primeiro, foi criada a pasta do projeto:

```bash
mkdir usuarios-api
cd usuarios-api
```

Depois foi inicializado o Composer:

```bash
composer init
```

E foram instaladas as dependências do Slim:

```bash
composer require slim/slim:"4.*" slim/psr7
```

## Execução

Para iniciar o servidor local, foi utilizado:

```bash
php -S localhost:8081 -t public public/index.php
```

A API fica disponível em:

```text
http://localhost:8081
```

## Endpoints

### GET /status

Verifica se a API está funcionando.

**Resposta esperada:**

```json
{
    "status": "API funcionando"
}
```

### GET /usuarios

Retorna todos os usuários cadastrados.

### GET /usuarios/{id}

Retorna um usuário específico através do seu ID.

Exemplo:

```text
GET /usuarios/1
```

### POST /usuarios

Cadastra um novo usuário.

Exemplo de JSON:

```json
{
    "nome": "Lucas Pereira",
    "email": "lucas@email.com",
    "senha": "123456"
}
```

Retorna o código HTTP `201` quando o usuário é criado.

### PUT /usuarios/{id}

Atualiza os dados de um usuário existente.

Exemplo:

```text
PUT /usuarios/1
```

JSON:

```json
{
    "nome": "João Atualizado",
    "email": "joao@email.com",
    "senha": "123456"
}
```

### DELETE /usuarios/{id}

Exclui um usuário através do seu ID.

Exemplo:

```text
DELETE /usuarios/5
```

### POST /login

Realiza a autenticação do usuário utilizando email e senha.

Exemplo:

```json
{
    "email": "joao@email.com",
    "senha": "123456"
}
```

Quando os dados estão corretos, a API retorna `200 OK`. Caso contrário, retorna `401 Unauthorized`.

### PUT /usuarios/{id}/senha

Altera a senha de um usuário.

Exemplo:

```text
PUT /usuarios/1/senha
```

JSON:

```json
{
    "senha": "nova123"
}
```

## Códigos HTTP utilizados

* `200 OK` — requisição realizada com sucesso.
* `201 Created` — usuário criado com sucesso.
* `401 Unauthorized` — email ou senha inválidos.
* `404 Not Found` — usuário não encontrado.

## Decisões técnicas

### Uso de um array

Os usuários foram armazenados em um array PHP para manter o projeto simples e focado no funcionamento dos endpoints da API, sem a necessidade de utilizar um banco de dados.

### Uso do JSON

O formato JSON foi utilizado para enviar e receber informações, pois é um formato comum em APIs REST e facilita a comunicação entre aplicações.

### Uso do getParsedBody()

Foi utilizado o método `getParsedBody()` para acessar os dados enviados no corpo das requisições POST e PUT.

Exemplo:

```php
$dados = $request->getParsedBody();
```

Dessa forma, os dados enviados pelo Postman podem ser utilizados dentro do PHP.

## Testes

Os endpoints foram testados utilizando o Postman, verificando tanto respostas de sucesso quanto situações de erro.

### Prints dos testes

#### Servidor iniciado

*No PDF.*

#### GET /status

*No PDF.*

#### GET /usuarios

*No PDF.*

#### GET /usuarios/{id}

*No PDF.*

#### POST /usuarios

*No PDF.*

#### PUT /usuarios/{id}

*No PDF.*

#### DELETE /usuarios/{id}

*No PDF.*

#### POST /login

*No PDF.*

#### Login inválido

*No PDF.*

#### Alteração de senha

*No PDF.*

## Conclusão

O projeto permitiu colocar em prática os principais conceitos de uma API REST utilizando PHP e Slim Framework, incluindo criação de rotas, utilização de parâmetros, recebimento de dados em JSON, códigos de status HTTP, cadastro e gerenciamento de usuários e autenticação.
# usuario_api
