# 🚀 Guia de Instalação — Laravel Passport API

Este guia é voltado para quem deseja rodar o projeto localmente. Se você é iniciante, siga os passos abaixo com atenção. Caso já esteja familiarizado com Laravel, pode usar como checklist.

---

## ✅ Pré-requisitos

- PHP ^8.1  
- Composer  
- MySQL ou PostgreSQL  
- Laravel >= 10.10  
- Extensões do PHP: `Ctype`
,`cURL`,
`DOM`,
`Fileinfo`,
`Filter`,
`Hash`,
`Mbstring`,
`OpenSSL`,
`PCRE`,
`PDO`,
`Session`,
`Tokenizer`,
`XML`

---

## 📥 1. Clonando o repositório

```bash
git clone https://github.com/seu-usuario/nome-do-repositorio.git
cd nome-do-repositorio
```
## 📦 2. Instalando dependências PHP

```bash
composer install
```
## 🛠️ 3. Criando o .env
```bash
cp .env.example .env
```
Configure o banco de dados no .env:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=passport_db
DB_USERNAME=root
DB_PASSWORD=senha
```

## 🔑 4. Gerando chave da aplicação
```bash
php artisan key:generate
```

## 🔐 5. Instalando o Laravel Passport
Este comando cria as chaves necessárias para assinatura dos tokens e clientes OAuth.

```bash
php artisan passport:install
```

## 🧱 6. Rodando as migrations
```bash
php artisan migrate
```
## 🧙 7. Rodando o servidor local
```bash
php artisan serve
```

