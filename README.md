# HelpDesk Inteligente

Sistema de gerenciamento de chamados desenvolvido com Laravel, focado em controle de atendimento, métricas operacionais, SLA, notificações internas e API REST.

## Demonstração

Em desenvolvimento.

## Funcionalidades

### Autenticação e Usuários

- Login e Logout
- Registro de usuários
- Recuperação de senha
- Controle de perfis
- Permissões por função

### Gestão de Chamados

- Criação de chamados
- Edição de chamados
- Exclusão de chamados
- Atribuição de responsáveis
- Controle de status
- Controle de prioridade
- Controle de categoria
- Filtros e pesquisa

### Colaboração

- Comentários em chamados
- Anexos em chamados
- Anexos em comentários

### Histórico e Auditoria

- Registro de alterações
- Timeline de histórico
- Alterações de status
- Alterações de prioridade
- Alterações de categoria
- Alterações de responsáveis

### Notificações

- Notificações internas
- Contador de notificações não lidas
- Dropdown de notificações
- Central de notificações
- Marcação individual de leitura
- Marcar todas como lidas

### SLA

- Registro automático de resolução
- Tempo de resolução por chamado
- Classificação de SLA
- Indicadores de desempenho

### Dashboard

- Total de chamados
- Chamados abertos
- Chamados em andamento
- Chamados aguardando retorno
- Chamados resolvidos
- Chamados críticos
- Chamados sem responsável
- Chamados atribuídos ao usuário
- SLA médio
- Chamados dentro do SLA
- Chamados fora do SLA
- Gráfico por status
- Gráfico por categoria

### API REST

- GET /api/tickets
- GET /api/tickets/{id}
- GET /api/dashboard

### Segurança

- Middleware de autenticação
- Políticas de acesso por perfil
- Laravel Sanctum (em implementação)

## Tecnologias Utilizadas

### Backend

- PHP 8+
- Laravel 11
- MySQL

### Frontend

- Blade
- Bootstrap 5
- Chart.js

### API

- Laravel API Resources
- REST API
- Laravel Sanctum

## Estrutura do Projeto

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Resources/
│   └── Requests/
├── Models/
├── Policies/
├── Notifications/
└── Services/

resources/
├── views/
├── css/
└── js/

routes/
├── web.php
└── api.php

Instalação
Clonar projeto

git clone https://github.com/seuusuario/helpdesk-inteligente.git
 
Entrar na pasta

cd helpdesk-inteligente/backend
Instalar dependências

composer install
Copiar ambiente

cp .env.example .env
Gerar chave

php artisan key:generate

Configurar banco

DB_DATABASE=helpdesk_db
DB_USERNAME=postgres
DB_PASSWORD=postgres

Executar migrations

php artisan migrate

Criar link storage

php artisan storage:link

Iniciar servidor

php artisan serve

Roadmap

Concluído
 Autenticação
 Dashboard
 Comentários
 Anexos
 Histórico
 Notificações
 SLA
 API REST

Próximas versões
 Autenticação da API com Sanctum
 CRUD completo via API
 Exportação Excel
 Dashboard avançado
 FastAPI
 Classificação automática de chamados com IA
 Base de conhecimento
 Chatbot de suporte
Autor

Mateus Coelho Santos