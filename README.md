# MackAI - Plataforma Unificada (OP-3)

## 🎯 Visão Geral

O **OP-3** é a evolução natural dos projetos MackAI, combinando o melhor de dois mundos:

- **🏗️ Stack Robusta** do OP-2 (PHP + MySQL + Google Cloud)
- **🎨 Design Moderno** do OP-1 (Interface responsiva e atrativa)
- **🔗 Funcionalidades Integradas** (Site institucional + Plataforma de encontros)

Esta versão unificada oferece uma experiência completa para a Liga Acadêmica de Ciência de Dados e IA da UPM.

## 🚀 Funcionalidades

### ✅ Site Institucional
- Página inicial com estatísticas em tempo real
- Seção sobre a liga e áreas de atuação
- Portfólio de projetos e apresentações
- Formulário de contato funcional

### ✅ Plataforma de Encontros
- Listagem de encontros por grupo e período
- Player integrado do YouTube
- Sistema de filtros avançados
- Navegação intuitiva entre encontros

### ✅ Recursos Técnicos
- Design responsivo (mobile-first)
- Acessibilidade (WCAG 2.1 AA)
- SEO otimizado
- Performance otimizada
- Deploy automatizado na GCP

## 🛠️ Tecnologias

| Categoria | Tecnologia |
|-----------|------------|
| **Backend** | PHP 8.3 |
| **Banco de Dados** | MySQL 8.0 |
| **Frontend** | HTML5, CSS3, JavaScript (Vanilla) |
| **Cloud** | Google Cloud Platform |
| **Deploy** | Cloud Run + Cloud SQL |
| **Containerização** | Docker |

## 📁 Estrutura do Projeto

```
op-3/
├── 📁 public/                 # Arquivos públicos
│   ├── 🚪 index.php          # Ponto de entrada (Router)
│   ├── 📁 assets/            # CSS, JS, imagens
│   │   ├── 📁 css/           # Estilos
│   │   ├── 📁 js/            # JavaScript
│   │   └── 📁 images/        # Imagens
│   └── ⚙️ .htaccess          # Configurações Apache
├── 📁 src/                   # Código fonte
│   ├── 📁 controllers/       # Controladores MVC
│   ├── 📁 models/           # Modelos de dados
│   ├── 📁 views/            # Templates PHP
│   │   ├── 📁 layout/       # Layout base
│   │   ├── 📁 home/         # Página inicial
│   │   ├── 📁 meetings/     # Encontros
│   │   └── 📁 errors/       # Páginas de erro
│   └── 📁 config/           # Configurações
├── 📁 database/             # Scripts SQL
│   ├── 📄 schema.sql        # Estrutura do banco
│   └── 📄 seeds.sql         # Dados iniciais
├── 📁 docker/               # Deploy e containerização
│   ├── 🐳 Dockerfile        # Imagem Docker
│   └── ☁️ cloudbuild.yaml   # Build automático GCP
├── 📁 docs/                 # Documentação
│   ├── 📖 development.md    # Guia de desenvolvimento
│   └── 🚀 deployment.md     # Guia de deploy
└── 📄 README.md             # Este arquivo
```

## ⚡ Início Rápido

### 🔧 Desenvolvimento Local

1. **Clone o repositório**
```bash
git clone https://github.com/rafavidal1709/mack-ai-plataforma.git
cd mack-ai-plataforma/op-3
```

2. **Configure o banco de dados**
```bash
mysql -u root -p
CREATE DATABASE mackai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
mysql -u root -p mackai < database/schema.sql
mysql -u root -p mackai < database/seeds.sql
```

3. **Configure as variáveis de ambiente**
```bash
cp .env.example .env
# Edite o arquivo .env com suas configurações
```

4. **Execute o servidor**
```bash
php -S localhost:8080 -t public
```

5. **Acesse a aplicação**
```
http://localhost:8080
```

### 🐳 Com Docker

```bash
# Build da imagem
docker build -f docker/Dockerfile -t mackai-op3 .

# Executar container
docker run -p 8080:8080 \
  -e DB_HOST=seu_host \
  -e DB_NAME=mackai \
  -e DB_USER=seu_usuario \
  -e DB_PASS=sua_senha \
  mackai-op3
```

## 🌐 Deploy na GCP

### Deploy Automático

```bash
# Configurar projeto
gcloud config set project mackai-468422

# Submit build
gcloud builds submit --config=docker/cloudbuild.yaml .
```

### Deploy Manual

```bash
# Build e push da imagem
docker build -f docker/Dockerfile -t gcr.io/mackai-468422/mackai-op3 .
docker push gcr.io/mackai-468422/mackai-op3

# Deploy no Cloud Run
gcloud run deploy mackai-op3 \
  --image gcr.io/mackai-468422/mackai-op3 \
  --region us-central1 \
  --allow-unauthenticated
```

📖 **Consulte** [`docs/deployment.md`](docs/deployment.md) **para instruções detalhadas**

## 🏗️ Arquitetura

### Padrão MVC Simplificado

```mermaid
graph TD
    A[Router] --> B[Controller]
    B --> C[Model]
    B --> D[View]
    C --> E[Database]
    D --> F[HTML Response]
```

### Fluxo de Requisição

1. **Router** (`public/index.php`) recebe a requisição
2. **Controller** processa a lógica de negócio
3. **Model** interage com o banco de dados
4. **View** renderiza a resposta HTML
5. **Layout** aplica o template base

## 🎨 Design System

### Cores Principais

| Cor | Hex | Uso |
|-----|-----|-----|
| 🔴 Vermelho Mackenzie | `#CE2029` | Primária |
| ⚫ Cinza Escuro | `#343a40` | Texto |
| ⚪ Branco | `#ffffff` | Fundo |
| 🔵 Azul | `#2E86AB` | Secundária |

### Tipografia

- **Fonte Principal**: Segoe UI, system-ui
- **Tamanho Base**: 16px
- **Linha Base**: 1.6

### Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🔒 Segurança

### Medidas Implementadas

- ✅ Prepared Statements (SQL Injection)
- ✅ Input Sanitization (XSS)
- ✅ CSRF Protection
- ✅ Security Headers
- ✅ HTTPS Obrigatório
- ✅ Rate Limiting

### Headers de Segurança

```http
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Content-Security-Policy: default-src 'self'
```

## 📊 Performance

### Otimizações

- ✅ Lazy Loading de imagens
- ✅ Compressão GZIP
- ✅ Cache de assets
- ✅ Minificação CSS/JS
- ✅ Otimização de queries

### Métricas Alvo

- **First Contentful Paint**: < 2s
- **Largest Contentful Paint**: < 3s
- **Cumulative Layout Shift**: < 0.1
- **First Input Delay**: < 100ms

## ♿ Acessibilidade

### Conformidade WCAG 2.1 AA

- ✅ Navegação por teclado
- ✅ Screen reader friendly
- ✅ Contraste adequado (4.5:1)
- ✅ ARIA labels
- ✅ Foco visível
- ✅ Texto alternativo

## 🧪 Testes

### Checklist de Qualidade

- [ ] Funcionalidade básica
- [ ] Responsividade
- [ ] Acessibilidade
- [ ] Performance
- [ ] Segurança
- [ ] SEO

### Ferramentas Recomendadas

- **Lighthouse** (Performance/SEO)
- **axe DevTools** (Acessibilidade)
- **WAVE** (Acessibilidade)
- **GTmetrix** (Performance)

## 📚 Documentação

| Documento | Descrição |
|-----------|-----------|
| [`docs/development.md`](docs/development.md) | Guia de desenvolvimento |
| [`docs/deployment.md`](docs/deployment.md) | Guia de deploy |
| [`database/schema.sql`](database/schema.sql) | Estrutura do banco |
| [`.env.example`](.env.example) | Variáveis de ambiente |

## 🤝 Contribuição

### Como Contribuir

1. **Fork** o repositório
2. **Crie** uma branch (`git checkout -b feature/nova-funcionalidade`)
3. **Commit** suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. **Push** para a branch (`git push origin feature/nova-funcionalidade`)
5. **Abra** um Pull Request

### Padrões de Código

- **PHP**: PSR-12
- **CSS**: BEM methodology
- **JavaScript**: ES6+
- **Commits**: Conventional Commits

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👥 Equipe

**Liga MackAI** - Liga Acadêmica de Ciência de Dados e IA  
🏫 Universidade Presbiteriana Mackenzie  
📧 contato@mackai.com.br  

---

<div align="center">

**Desenvolvido com ❤️ pela Liga MackAI**

[🌐 Site](https://mackai.com.br) • [📧 Contato](mailto:contato@mackai.com.br) • [📱 Instagram](https://instagram.com/mackai) • [💼 LinkedIn](https://linkedin.com/company/mackai)

</div>
