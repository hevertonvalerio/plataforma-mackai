# Guia de Desenvolvimento - MackAI OP-3

## Configuração do Ambiente de Desenvolvimento

### Pré-requisitos

- PHP 8.3 ou superior
- MySQL 8.0 ou superior
- Composer (opcional, para futuras dependências)
- Git
- Editor de código (VS Code recomendado)

### Configuração Local

1. **Clone o repositório**
```bash
git clone https://github.com/rafavidal1709/mack-ai-plataforma.git
cd mack-ai-plataforma/op-3
```

2. **Configurar banco de dados local**
```bash
# Criar banco de dados
mysql -u root -p
CREATE DATABASE mackai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Importar schema
mysql -u root -p mackai < database/schema.sql

# Importar dados iniciais
mysql -u root -p mackai < database/seeds.sql
```

3. **Configurar variáveis de ambiente**
```bash
cp .env.example .env
# Editar .env com suas configurações locais
```

4. **Executar servidor local**
```bash
# Opção 1: Servidor embutido do PHP
php -S localhost:8080 -t public

# Opção 2: Docker
docker build -f docker/Dockerfile -t mackai-op3 .
docker run -p 8080:8080 mackai-op3
```

## Estrutura do Projeto

```
op-3/
├── public/                 # Arquivos públicos (ponto de entrada)
│   ├── index.php          # Router principal
│   ├── assets/            # CSS, JS, imagens
│   └── .htaccess          # Configurações Apache
├── src/                   # Código fonte
│   ├── controllers/       # Controladores MVC
│   ├── models/           # Modelos de dados
│   ├── views/            # Templates PHP
│   └── config/           # Configurações
├── database/             # Scripts SQL
├── docker/               # Configurações Docker/GCP
├── docs/                 # Documentação
└── README.md
```

## Arquitetura

### Padrão MVC Simplificado

- **Models**: Interação com banco de dados (BaseModel, Meeting, Group, Period)
- **Views**: Templates PHP com layout base
- **Controllers**: Lógica de negócio (BaseController + específicos)

### Roteamento

O roteamento é feito no `public/index.php`:
- URLs amigáveis (`/encontros`, `/encontro/1`)
- Mapeamento para controladores
- Tratamento de 404

### Banco de Dados

- **Conexão**: Singleton pattern (Database class)
- **Queries**: PDO com prepared statements
- **Migrations**: Scripts SQL manuais

## Convenções de Código

### PHP

```php
<?php
// Sempre usar tags completas
// PSR-12 para formatação
// Camelcase para métodos e variáveis
// PascalCase para classes

class ExampleController extends BaseController {
    public function methodName($parameter) {
        // Código aqui
    }
}
```

### CSS

```css
/* BEM methodology */
.block__element--modifier {
    /* Propriedades */
}

/* Variáveis CSS */
:root {
    --primary-color: #CE2029;
}
```

### JavaScript

```javascript
// ES6+ features
// Camelcase para variáveis e funções
// PascalCase para construtores

const functionName = () => {
    // Código aqui
};
```

## Adicionando Novas Funcionalidades

### 1. Nova Página

1. Criar controlador em `src/controllers/`
2. Criar view em `src/views/`
3. Adicionar rota em `public/index.php`
4. Atualizar navegação em `src/views/layout/base.php`

### 2. Novo Modelo

1. Criar classe em `src/models/` estendendo `BaseModel`
2. Definir propriedade `$table`
3. Implementar métodos específicos

### 3. Nova API Endpoint

1. Criar método no controlador
2. Retornar JSON usando `$this->json()`
3. Adicionar rota para `/api/*`

## Testes

### Testes Manuais

1. **Funcionalidade básica**
   - Navegação entre páginas
   - Exibição de encontros
   - Formulário de contato

2. **Responsividade**
   - Mobile (< 768px)
   - Tablet (768px - 1024px)
   - Desktop (> 1024px)

3. **Acessibilidade**
   - Navegação por teclado
   - Screen readers
   - Contraste de cores

### Checklist de Qualidade

- [ ] Código segue padrões PSR
- [ ] Queries usam prepared statements
- [ ] Dados são sanitizados
- [ ] Headers de segurança configurados
- [ ] Responsivo em todos os breakpoints
- [ ] Acessível (WCAG 2.1 AA)
- [ ] Performance otimizada

## Debugging

### Logs

```php
// Habilitar logs de erro
error_log("Debug: " . print_r($data, true));

// Verificar logs
tail -f /var/log/php_errors.log
```

### Banco de Dados

```sql
-- Verificar conexões
SHOW PROCESSLIST;

-- Verificar queries lentas
SHOW VARIABLES LIKE 'slow_query_log';
```

### Performance

```javascript
// Medir performance no browser
console.time('operacao');
// ... código ...
console.timeEnd('operacao');
```

## Segurança

### Checklist de Segurança

- [ ] Validação de entrada
- [ ] Sanitização de saída
- [ ] Prepared statements
- [ ] Headers de segurança
- [ ] HTTPS obrigatório
- [ ] Proteção CSRF
- [ ] Rate limiting

### Boas Práticas

1. **Nunca confie em dados do usuário**
2. **Sempre escape output**
3. **Use HTTPS em produção**
4. **Mantenha dependências atualizadas**
5. **Implemente logs de auditoria**

## Deploy

### Ambiente de Desenvolvimento

```bash
# Servidor local
php -S localhost:8080 -t public
```

### Ambiente de Staging

```bash
# Deploy para staging
gcloud builds submit --config=docker/cloudbuild.yaml .
```

### Ambiente de Produção

Ver `docs/deployment.md` para instruções completas.

## Contribuição

### Workflow

1. Fork do repositório
2. Criar branch feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit das mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para branch (`git push origin feature/nova-funcionalidade`)
5. Criar Pull Request

### Code Review

- Código deve seguir padrões estabelecidos
- Testes devem passar
- Documentação deve ser atualizada
- Performance não deve ser degradada

## Recursos Úteis

### Documentação

- [PHP Manual](https://www.php.net/manual/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Google Cloud Run](https://cloud.google.com/run/docs)

### Ferramentas

- [VS Code](https://code.visualstudio.com/)
- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
- [MySQL Workbench](https://www.mysql.com/products/workbench/)

### Extensões VS Code Recomendadas

```json
{
    "recommendations": [
        "bmewburn.vscode-intelephense-client",
        "bradlc.vscode-tailwindcss",
        "ms-vscode.vscode-json",
        "formulahendry.auto-rename-tag",
        "christian-kohler.path-intellisense"
    ]
}
```
