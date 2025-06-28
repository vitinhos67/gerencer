# Upgrade de Autenticação - HTTP-Only Cookies + Tokens

## Resumo das Mudanças

Este upgrade implementa autenticação com **HTTP-only cookies** mantendo compatibilidade com **tokens Bearer**, oferecendo maior segurança e flexibilidade.

## 🚀 Funcionalidades Implementadas

### Backend (Laravel)

#### 1. AuthController Atualizado
- **Login dual**: Suporta tanto cookies HTTP-only quanto tokens Bearer
- **Detecção automática**: Verifica se o cliente quer usar cookies via header `X-Use-Cookies`
- **Logout inteligente**: Remove cookies ou tokens conforme o método usado
- **Endpoint `/me`**: Para verificar usuário atual

#### 2. Configurações Sanctum
- **Sessões habilitadas**: `'guard' => ['web']` no `config/sanctum.php`
- **Domínios stateful**: Inclui `localhost:8080` para desenvolvimento
- **Middleware web**: Adicionado ao grupo de middleware da API

#### 3. CORS Configurado
- **Credentials habilitados**: `'supports_credentials' => true`
- **Headers personalizados**: Suporte para `X-Use-Cookies`
- **Paths específicos**: `['api/*', 'sanctum/csrf-cookie']`

#### 4. Middleware Personalizado
- **ForceJsonResponse**: Adiciona headers CORS necessários
- **Cookies seguros**: Configurados com `httpOnly: true`, `secure: true`

### Frontend (Vue.js)

#### 1. LoginService Aprimorado
- **Login inteligente**: Tenta cookies primeiro, fallback para tokens
- **Logout unificado**: Remove cookies ou tokens conforme necessário
- **getCurrentUser**: Suporta ambos os métodos de autenticação

#### 2. ResourceService com Interceptors
- **Interceptor de request**: Adiciona token Bearer quando necessário
- **Interceptor de response**: Trata erros 401 e redireciona para login
- **withCredentials**: Habilitado por padrão para cookies

#### 3. Componentes Atualizados
- **LoginComponent**: Usa novo método de login
- **DashboardComponent**: Logout com novo serviço
- **Router**: Verifica autenticação considerando ambos os métodos

## 🔧 Como Funciona

### Fluxo de Login

1. **Frontend** envia requisição com `X-Use-Cookies: true`
2. **Backend** detecta e cria sessão + cookie HTTP-only
3. **Frontend** armazena `auth_method: 'cookies'` no localStorage
4. **Requests subsequentes** usam cookies automaticamente

### Fallback para Tokens

1. Se cookies falharem, frontend tenta login com tokens
2. Armazena `auth_method: 'token'` no localStorage
3. Requests subsequentes incluem `Authorization: Bearer <token>`

### Logout

1. **Backend** detecta método usado (cookies vs tokens)
2. **Remove sessão** ou **invalida token** conforme necessário
3. **Frontend** limpa localStorage e redireciona

## 🛡️ Segurança

### HTTP-Only Cookies
- **Não acessíveis via JavaScript** (proteção contra XSS)
- **Secure flag** em produção
- **SameSite=Lax** para proteção CSRF
- **Expiração de 7 dias**

### Tokens Bearer
- **Compatibilidade** com sistemas existentes
- **Fallback** quando cookies não funcionam
- **Expiração** configurável

## 📝 Rotas da API

### Públicas
- `POST /api/auth/login` - Login (cookies ou tokens)
- `POST /api/auth/logout` - Logout
- `POST /api/register` - Registro
- `POST /api/supplier` - Criar fornecedor

### Protegidas
- `GET /api/auth/me` - Usuário atual
- Todas as outras rotas existentes

## 🚀 Como Testar

### 1. Backend
```bash
cd back-end
php artisan serve
```

### 2. Frontend
```bash
cd front-end
npm run serve
```

### 3. Teste de Login
1. Acesse `http://localhost:8080/login`
2. Faça login com credenciais válidas
3. Verifique no DevTools > Application > Cookies se o `laravel_session` foi criado
4. Verifique no DevTools > Application > Local Storage se `auth_method: 'cookies'` foi salvo

### 4. Teste de Fallback
1. Simule erro de cookies (desabilite CORS no backend)
2. Faça login novamente
3. Verifique se `auth_method: 'token'` foi salvo

## 🔄 Migração de Sistemas Existentes

### Para Sistemas com Tokens
- **Sem mudanças necessárias**: Tokens continuam funcionando
- **Upgrade gradual**: Pode migrar para cookies quando conveniente

### Para Novos Sistemas
- **Recomendado**: Usar cookies HTTP-only por padrão
- **Configuração**: Definir `VUE_APP_API_URL` no frontend

## ⚠️ Considerações Importantes

### Produção
1. **HTTPS obrigatório** para cookies seguros
2. **Domínios específicos** no CORS (não `*`)
3. **Configurar `SANCTUM_STATEFUL_DOMAINS`** no `.env`

### Desenvolvimento
1. **localhost:8080** já configurado
2. **CORS permissivo** para desenvolvimento
3. **Cookies funcionam** mesmo sem HTTPS local

## 🐛 Troubleshooting

### Cookies não funcionam
1. Verifique se `withCredentials: true` está configurado
2. Confirme se CORS está habilitado no backend
3. Verifique se o domínio está em `SANCTUM_STATEFUL_DOMAINS`

### Tokens não funcionam
1. Verifique se `Authorization: Bearer` está sendo enviado
2. Confirme se o token está válido no localStorage
3. Verifique se `auth_method: 'token'` está salvo

### Erro 401 persistente
1. Limpe localStorage e cookies
2. Faça logout e login novamente
3. Verifique se o backend está rodando

## 📚 Recursos Adicionais

- [Laravel Sanctum Documentation](https://laravel.com/docs/sanctum)
- [HTTP-Only Cookies Security](https://owasp.org/www-community/HttpOnly)
- [CORS with Credentials](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS#credentials) 