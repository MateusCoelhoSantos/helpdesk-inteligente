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

## Instalação

### 1. Clonar o repositório

```bash
git clone https://github.com/seuusuario/helpdesk-inteligente.git
```

### 2. Entrar no diretório do projeto

```bash
cd helpdesk-inteligente/backend
```

### 3. Instalar dependências

```bash
composer install
```

### 4. Configurar ambiente

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

### 5. Configurar banco de dados

Edite o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=helpdesk
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Executar migrations

```bash
php artisan migrate
```

### 7. Criar link para armazenamento

```bash
php artisan storage:link
```

### 8. Iniciar aplicação

```bash
php artisan serve
```

A aplicação estará disponível em:

```text
http://localhost:8000
```
## API REST

A aplicação disponibiliza endpoints para integração com aplicações externas.

### Listar chamados

```http
GET /api/tickets
```

### Exibir um chamado

```http
GET /api/tickets/{id}
```

### Métricas do dashboard

```http
GET /api/dashboard
```

### Exemplo de resposta

```json
{
  "total_tickets": 24,
  "open_tickets": 8,
  "in_progress_tickets": 3,
  "waiting_tickets": 4,
  "resolved_tickets": 9,
  "critical_tickets": 8
}
```
## Funcionalidades Implementadas

### Autenticação

- Login
- Logout
- Recuperação de senha
- Verificação de e-mail

### Chamados

- Cadastro
- Edição
- Exclusão
- Filtros
- Pesquisa
- Categorias
- Prioridades
- Status

### Atendimento

- Comentários
- Anexos
- Responsáveis
- Histórico de alterações

### Notificações

- Central de notificações
- Notificações não lidas
- Contador em tempo real
- Marcar notificações como lidas
- Marcar todas como lidas

### Dashboard

- Indicadores operacionais
- Gráfico por status
- Gráfico por categoria
- Chamados críticos
- SLA médio
- Chamados dentro do SLA
- Chamados fora do SLA

### API

- Endpoints REST
- Resources Laravel
- Paginação
- Respostas em JSON

## Roadmap

### Em desenvolvimento

- [ ] Autenticação da API com Sanctum
- [ ] CRUD completo via API
- [ ] Exportação Excel
- [ ] Dashboard avançado de produtividade
- [ ] Integração com FastAPI

### Futuro

- [ ] Classificação automática de chamados com IA
- [ ] Base de conhecimento
- [ ] Chatbot de suporte
- [ ] Aplicação mobile

## Sobre o Projeto

O HelpDesk Inteligente é um sistema de gestão de chamados desenvolvido para simular um ambiente corporativo de suporte técnico.

O projeto evoluiu além de um CRUD tradicional e atualmente conta com:

- Gestão completa de chamados
- Dashboard analítico
- Métricas de SLA
- Central de notificações
- Histórico de auditoria
- API REST para integração

O objetivo é servir como ambiente de aprendizado prático em Laravel, arquitetura de software, APIs e futuras integrações com Inteligência Artificial.