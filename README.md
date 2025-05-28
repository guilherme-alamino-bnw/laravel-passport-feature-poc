![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue)
![Laravel](https://img.shields.io/badge/laravel->=10.10-red.svg?style=flat)

# 🛡️ Laravel Passport API — Autenticação com Escopos Personalizados

> POC (Prova de Conceito) com autenticação OAuth2 utilizando Laravel Passport e escopos personalizados para controle granular.

---

## 🧠 **Contexto**

Imagine um sistema onde cada usuário recebe uma *chave mágica* (token) com permissões exclusivas, como se fossem poderes em um RPG:

* 🧙 **[master@teste.com](mailto:master@teste.com)** → ✨ `user.master:read`
* 🧑‍💼 **[user@teste.com](mailto:user@teste.com)** → 🛠️ `user:read`, `user:write`
* 🧠 **[admin@admin.com](mailto:admin@admin.com)** → 📊 `admin.metrics:read`

Cada rota exige que o usuário use o token com o “**feitiço certo**” (escopo), ou o acesso é negado com uma mensagem direta.

---

## 📚 Visão Geral da API

* 🔐 Autenticação via Passport
* 🎯 Controle de escopos com middleware personalizado
* 🔁 API versionada (`/api/v1`)

---

## 🧱 Estrutura de Pastas

```
app/
├── Http/
│   ├── Controllers/
│   │   └── API/V1/
│   │       ├── Auth/AuthController.php
│   │       ├── User/UserController.php
│   │       └── Admin/AdminController.php
│   └── Middleware/ScopeCustomize.php
├── Providers/AuthServiceProvider.php
routes/
└── api.php
```

---

## 🔐 Registro de Escopos (AuthServiceProvider)

```php
Passport::tokensCan([
    'user.master:read'     => 'Acesso para leitura de todos os usuários',
    'user:read'            => 'Ler dados do usuário',
    'user:write'           => 'Alterar dados do usuário',
    'admin.metrics:read'   => 'Acesso administrativo para leitura de métricas',
]);
```

---

## ⚙️ Login com Poderes (Exemplo Lúdico)

```php
if ($user['email'] === 'admin@admin.com') {
    $tokenResult = $user->createToken($user['name'], ['admin.metrics:read']);
}

if ($user['email'] === 'user@teste.com') {
    $tokenResult = $user->createToken($user['name'], ['user:read', 'user:write']);
}

if ($user['email'] === 'master@teste.com') {
    $tokenResult = $user->createToken($user['name'], ['user.master:read']);
}
```

---

## 🧠 Middleware ScopeCustomize

```php
if (!$request->user() || !$request->user()->tokenCan($scope)) {
    return response()->json([
        'status'  => 'error',
        'code'    => 'forbidden',
        'message' => "Acesso negado: falta permissão “{$scope}”",
    ], 403);
}
```

---

## 📡 Rotas API — v1

| Método | Rota                | Controller      | Método   | Middleware                             | Escopo Necessário    |
| ------ | ------------------- | --------------- | -------- | -------------------------------------- | -------------------- |
| POST   | /auth/register      | AuthController  | register | -                                      | -                    |
| POST   | /auth/login         | AuthController  | login    | -                                      | -                    |
| POST   | /auth/logout        | AuthController  | logout   | auth\:api                              | -                    |
| GET    | /auth/user          | UserController  | index    | auth\:api + scope\:user.master\:read   | `user.master:read`   |
| GET    | /auth/user/profile  | UserController  | show     | auth\:api + scope\:user\:read          | `user:read`          |
| PUT    | /auth/user          | UserController  | update   | auth\:api + scope\:user\:write         | `user:write`         |
| GET    | /auth/admin/metrics | AdminController | metrics  | auth\:api + scope\:admin.metrics\:read | `admin.metrics:read` |

---

## 📬 Exemplo de Login

```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "admin@admin.com",
  "password": "secreto123"
}
```

### Resposta:

```json
{
  "access_token": "TOKEN_AQUI",
  "token_type": "Bearer",
  "expires_at": "2025-06-06T00:00:00.000000Z"
}
```

---

## 🪪 Requisições Autenticadas

```http
Authorization: Bearer {access_token}
Accept: application/json
```
## 📚 Referências e Documentação

- Documentação oficial Laravel Passport:  
  https://laravel.com/docs/10.x/passport

- Grant Type Password:  
  https://laravel.com/docs/10.x/passport#creating-a-password-grant-client

- OAuth 2.0 Specification [Access Token, Scope OAuth, Grant Type Password]:  
https://oauth.net/2/access-tokens/
https://oauth.net/2/scope/
https://www.oauth.com/oauth2-servers/access-tokens/password-grant/
---

> ⚙️ Quer rodar esse projeto localmente? Veja o guia de instalação em [`docs/setup.md`](docs/setup.md).
---


Esse projeto é uma maneira divertida de aprender como o Laravel Passport permite a construção de APIs seguras com **escopos sob medida**, imitando papéis, níveis e poderes de usuários.


> Feito com ❤️ & ☕


