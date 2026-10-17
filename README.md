# HelpDesk Inteligente

Sistema de gerenciamento de chamados de suporte técnico desenvolvido para fins de estudo e portfólio.

O projeto tem como objetivo demonstrar conhecimentos em desenvolvimento back-end com Laravel, modelagem de banco de dados, construção de APIs e futura integração com Inteligência Artificial para classificação automática de chamados.

---

## Tecnologias

### Back-end

- PHP 8.5
- Laravel 13
- PostgreSQL

### Front-end

- Blade
- Bootstrap 5
- JavaScript

### Inteligência Artificial (em desenvolvimento)

- Python
- FastAPI

### Ferramentas

- Git
- GitHub
- Laragon
- VS Code

---

## Estrutura do Projeto

```text
helpdesk-Inteligente/
│
├── backend/        # Aplicação Laravel
│
├── ia-service/     # Serviço de IA com FastAPI
│
├── .venv/          # Ambiente virtual Python
│
└── README.md
```

---

## Funcionalidades Implementadas

### Módulo de Chamados

- Cadastro de chamados
- Listagem paginada
- Visualização detalhada
- Integração com PostgreSQL
- Validação de formulários

Campos atualmente disponíveis:

- Título
- Descrição
- Categoria
- Prioridade
- Status

---

## Banco de Dados

Banco utilizado:

```text
PostgreSQL
```

Tabela implementada:

```text
tickets
```

Campos:

```text
id
title
description
category
priority
status
created_at
updated_at
```

---

## Como Executar o Projeto

### Clonar o repositório

```bash
git clone https://github.com/MateusCoelhoSantos/helpdesk-inteligente.git
```

### Acessar o diretório

```bash
cd helpdesk-inteligente
```

### Executar o Laravel

```bash
cd backend

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve
```

A aplicação ficará disponível em:

```text
http://127.0.0.1:8000
```

---

## Roadmap

### Concluído

- [x] Configuração do Laravel
- [x] Integração com PostgreSQL
- [x] Cadastro de chamados
- [x] Listagem de chamados
- [x] Visualização de chamados

### Em desenvolvimento

- [ ] Edição de chamados
- [ ] Exclusão de chamados
- [ ] Filtros e pesquisa
- [ ] Testes automatizados

### Futuro

- [ ] Autenticação de usuários
- [ ] Controle de permissões
- [ ] API REST
- [ ] Integração Laravel + FastAPI
- [ ] Classificação automática com IA
- [ ] Dashboard gerencial

---

## Autor

Mateus Coelho Santos

GitHub:
https://github.com/MateusCoelhoSantos