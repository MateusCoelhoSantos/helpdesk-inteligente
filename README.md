# HelpDesk Inteligente

## Visão Geral

O HelpDesk Inteligente é uma plataforma de Service Desk desenvolvida com Laravel, PostgreSQL e Inteligência Artificial local utilizando Ollama. O projeto evoluiu de um sistema tradicional de chamados para uma solução de suporte inteligente com classificação automática, geração de resumos, base de conhecimento, processamento assíncrono e API REST documentada.

## Arquitetura

### Backend
- Laravel 12
- PHP 8.5+
- PostgreSQL
- Laravel Sanctum
- Laravel Queue
- OpenAPI (Scramble)
- Eloquent ORM

### Inteligência Artificial
- Ollama
- Qwen 2.5
- Arquitetura baseada em Providers
- Processamento assíncrono com Jobs e Queue

### Frontend
- React
- TypeScript
- Vite
- Axios
- React Router DOM
- Tailwind CSS (em implantação)

## Principais Funcionalidades

### Gestão de Chamados
- Criação de chamados
- Atualização de chamados
- Exclusão de chamados
- Controle de status
- Controle de categorias
- Controle de prioridades
- Pesquisa e filtros
- Ordenação dinâmica

### Colaboração
- Comentários em chamados
- Upload de anexos
- Histórico completo de alterações
- Auditoria de atividades

### Notificações
- Central de notificações
- Notificações não lidas
- Marcar individualmente como lida
- Marcar todas como lidas

### Dashboard
- Estatísticas operacionais
- Indicadores de SLA
- Chamados por categoria
- Chamados por status
- Chamados críticos

## Inteligência Artificial

### Classificação Inteligente
Classifica automaticamente:
- Categoria
- Prioridade
- Nível de confiança

### Resumo Inteligente
Gera resumos com base em:
- Ticket
- Comentários
- Histórico

### Sugestão de Respostas
Sugere respostas para agentes de suporte com base no contexto do chamado.

### Closure Report
Gera relatórios estruturados contendo:
- Resumo do incidente
- Causa raiz
- Solução aplicada
- Lições aprendidas

### Base de Conhecimento
Gera automaticamente artigos técnicos contendo:
- Problema
- Causa
- Solução
- Prevenção

### Busca de Conhecimento
Permite localizar artigos semelhantes para reutilização de soluções.

## Processamento Assíncrono

### Laravel Queue
Implementado para processamento de IA em background.

Jobs atualmente implementados:
- GenerateTicketSummaryJob
- GenerateKnowledgeArticleJob

### Histórico de IA
Tabela centralizada:

```text
ai_generations
```

Registra:
- Tipo da geração
- Status
- Resultado
- Erros
- Data da execução

## API REST

### Tickets
```http
GET    /api/v1/tickets
GET    /api/v1/tickets/{id}
POST   /api/v1/tickets
PUT    /api/v1/tickets/{id}
DELETE /api/v1/tickets/{id}
```

### Inteligência Artificial
```http
POST /api/v1/ai/classify-ticket
GET  /api/v1/tickets/{ticket}/summary
GET  /api/v1/tickets/{ticket}/suggest-reply
GET  /api/v1/tickets/{ticket}/closure-report
```

### Knowledge Base
```http
POST /api/v1/tickets/{ticket}/knowledge-articles
GET  /api/v1/knowledge-articles
POST /api/v1/knowledge-articles/suggest
```

### Histórico IA
```http
GET /api/v1/tickets/{ticket}/ai-generations
```

## Testes Automatizados

O projeto possui suíte automatizada utilizando PHPUnit.

Resultado atual:

```text
76 testes passando
166 assertions
0 falhas
```

Cobertura:
- Autenticação
- Tickets
- Comentários
- Anexos
- Dashboard
- Notificações
- Policies
- Providers de IA
- Resumo Inteligente
- Sugestão de Respostas
- Classificação de Tickets

Execução:

```bash
php artisan test
```

## Documentação da API

Gerada utilizando Scramble:

```bash
php artisan scramble:export
```

Arquivo gerado:

```text
api.json
```

## Instalação Backend

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
```

Executar API:

```bash
php artisan serve
```

## Instalação Frontend

```bash
cd frontend
npm install
npm run dev
```

## Estado Atual do Projeto

### Concluído
- Sistema de chamados
- Dashboard operacional
- Notificações
- Histórico e auditoria
- API REST
- Integração Ollama
- Classificação inteligente
- Resumo inteligente
- Sugestão de respostas
- Closure Reports
- Knowledge Base
- Busca de conhecimento
- Filas assíncronas
- Histórico de IA
- OpenAPI
- Testes automatizados

### Em Desenvolvimento
- Frontend React
- Dashboard avançado de IA
- Interface da base de conhecimento
- Integração completa React + Laravel

## Roadmap

### Próximas Entregas
- Interface React completa
- Dashboard de IA
- Closure Report assíncrono
- Métricas avançadas
- CI/CD
- Docker

## Licença

Projeto desenvolvido para fins de estudo, portfólio e evolução de arquitetura de software aplicada a Service Desk Inteligente com IA.