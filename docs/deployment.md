# Guia de Deploy - MackAI OP-3

## Visão Geral

Este guia explica como fazer o deploy da aplicação MackAI OP-3 no Google Cloud Platform.

## Pré-requisitos

- Conta no Google Cloud Platform
- Google Cloud SDK instalado
- Docker instalado (para desenvolvimento local)
- Acesso ao projeto `mackai-468422`

## Configuração Inicial

### 1. Configurar Google Cloud SDK

```bash
# Fazer login
gcloud auth login

# Configurar projeto
gcloud config set project mackai-468422

# Configurar região padrão
gcloud config set run/region us-central1
```

### 2. Habilitar APIs Necessárias

```bash
gcloud services enable \
    cloudbuild.googleapis.com \
    run.googleapis.com \
    sqladmin.googleapis.com \
    artifactregistry.googleapis.com
```

### 3. Configurar Artifact Registry

```bash
# Criar repositório
gcloud artifacts repositories create mackai-op3 \
    --repository-format=docker \
    --location=us-central1 \
    --description="Repositório para MackAI OP-3"

# Configurar autenticação
gcloud auth configure-docker us-central1-docker.pkg.dev
```

## Deploy Manual

### 1. Build da Imagem

```bash
# Na raiz do projeto op-3
docker build -f docker/Dockerfile -t mackai-op3 .

# Tag para o registry
docker tag mackai-op3 us-central1-docker.pkg.dev/mackai-468422/mackai-op3/app:latest

# Push para o registry
docker push us-central1-docker.pkg.dev/mackai-468422/mackai-op3/app:latest
```

### 2. Deploy no Cloud Run

```bash
gcloud run deploy mackai-op3 \
    --image us-central1-docker.pkg.dev/mackai-468422/mackai-op3/app:latest \
    --region us-central1 \
    --platform managed \
    --allow-unauthenticated \
    --set-env-vars DB_HOST=34.63.216.169 \
    --set-env-vars DB_NAME=mackai \
    --set-env-vars DB_USER=root \
    --set-env-vars DB_PASS=aA!12345 \
    --set-env-vars BASE_URL=https://mackai-op3-mackai-468422.a.run.app
```

## Deploy Automatizado com Cloud Build

### 1. Configurar Cloud Build

O arquivo `docker/cloudbuild.yaml` já está configurado para deploy automático.

### 2. Conectar Repositório

```bash
# Conectar repositório GitHub (se aplicável)
gcloud builds triggers create github \
    --repo-name=mack-ai-plataforma \
    --repo-owner=rafavidal1709 \
    --branch-pattern="^main$" \
    --build-config=op-3/docker/cloudbuild.yaml \
    --working-dir=op-3
```

### 3. Deploy via Cloud Build

```bash
# Submit build manualmente
gcloud builds submit --config=docker/cloudbuild.yaml .
```

## Configuração do Banco de Dados

### 1. Usar Instância Existente

A aplicação está configurada para usar a instância Cloud SQL existente:
- **Host**: 34.63.216.169
- **Database**: mackai
- **User**: root
- **Password**: aA!12345

### 2. Executar Migrations

```bash
# Conectar à instância Cloud SQL
gcloud sql connect mackai --user=root

# Executar schema
mysql> source database/schema.sql;

# Executar seeds
mysql> source database/seeds.sql;
```

## Verificação do Deploy

### 1. Verificar Status do Serviço

```bash
gcloud run services describe mackai-op3 --region=us-central1
```

### 2. Verificar Logs

```bash
gcloud run services logs read mackai-op3 --region=us-central1
```

### 3. Testar Aplicação

```bash
# Obter URL do serviço
URL=$(gcloud run services describe mackai-op3 --region=us-central1 --format='value(status.url)')

# Testar endpoint
curl -I $URL
```

## Configurações de Produção

### 1. Variáveis de Ambiente

Configurar as seguintes variáveis no Cloud Run:

```bash
gcloud run services update mackai-op3 \
    --region=us-central1 \
    --set-env-vars APP_ENV=production \
    --set-env-vars APP_DEBUG=false \
    --set-env-vars CACHE_ENABLED=true
```

### 2. Configurar Domínio Customizado

```bash
# Mapear domínio (se disponível)
gcloud run domain-mappings create \
    --service mackai-op3 \
    --domain mackai.com.br \
    --region us-central1
```

## Monitoramento

### 1. Configurar Alertas

```bash
# Criar política de alerta para erros
gcloud alpha monitoring policies create \
    --policy-from-file=monitoring/error-policy.yaml
```

### 2. Configurar Uptime Checks

```bash
# Criar uptime check
gcloud alpha monitoring uptime create \
    --display-name="MackAI OP-3 Uptime" \
    --http-check-path="/" \
    --hostname="mackai-op3-mackai-468422.a.run.app"
```

## Troubleshooting

### Problemas Comuns

1. **Erro de Conexão com Banco**
   - Verificar se a instância Cloud SQL está ativa
   - Confirmar credenciais de acesso
   - Verificar rede autorizada

2. **Erro de Build**
   - Verificar Dockerfile
   - Confirmar dependências PHP
   - Verificar logs do Cloud Build

3. **Erro 500**
   - Verificar logs da aplicação
   - Confirmar variáveis de ambiente
   - Verificar permissões

### Comandos Úteis

```bash
# Ver logs em tempo real
gcloud run services logs tail mackai-op3 --region=us-central1

# Atualizar serviço
gcloud run services replace service.yaml --region=us-central1

# Rollback para versão anterior
gcloud run services update-traffic mackai-op3 \
    --to-revisions=PREVIOUS_REVISION=100 \
    --region=us-central1
```

## Backup e Recuperação

### 1. Backup do Banco

```bash
# Criar backup automático
gcloud sql backups create --instance=mackai

# Exportar dados
gcloud sql export sql mackai gs://mackai-backups/backup-$(date +%Y%m%d).sql \
    --database=mackai
```

### 2. Backup do Código

- Código versionado no Git
- Imagens Docker no Artifact Registry
- Configurações no Cloud Build

## Segurança

### 1. Configurações de Segurança

- HTTPS obrigatório (Cloud Run padrão)
- Headers de segurança configurados
- Variáveis sensíveis como secrets
- Rede privada para Cloud SQL

### 2. Atualizações

```bash
# Atualizar dependências regularmente
# Monitorar vulnerabilidades
# Aplicar patches de segurança
```
