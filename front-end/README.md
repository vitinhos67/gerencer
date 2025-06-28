# Sistema de Gerenciamento Administrativo

Este é um sistema de painel administrativo desenvolvido com Vue.js 3, TypeScript e Vuetify.

## Funcionalidades

### 🔐 Sistema de Autenticação
- Login com email e senha
- Validação de formulários
- Armazenamento seguro de token
- Redirecionamento automático após login

### 📊 Painel Administrativo
- **Dashboard**: Visão geral com estatísticas e atividades recentes
- **Usuários**: Gerenciamento completo de usuários (CRUD)
- **Configurações**: Configurações do sistema, email e segurança
- **Relatórios**: Geração e exportação de relatórios

### 🎨 Interface
- Barra lateral responsiva para navegação
- Design moderno e intuitivo
- Componentes reutilizáveis
- Layout adaptativo para diferentes dispositivos

## Estrutura do Projeto

```
src/
├── views/admin/
│   ├── LoginComponent.vue          # Página de login
│   ├── DashboardComponent.vue      # Layout principal do painel
│   ├── DashboardHomeComponent.vue  # Página inicial do dashboard
│   ├── UsersComponent.vue          # Gerenciamento de usuários
│   ├── SettingsComponent.vue       # Configurações do sistema
│   └── ReportsComponent.vue        # Relatórios
├── services/
│   ├── LoginService.ts             # Serviço de autenticação
│   └── ResourceService.ts          # Serviço base para APIs
├── router.ts                       # Configuração de rotas
└── App.vue                         # Componente raiz
```

## Rotas

- `/login` - Página de login
- `/admin/dashboard` - Dashboard principal
- `/admin/users` - Gerenciamento de usuários
- `/admin/settings` - Configurações
- `/admin/reports` - Relatórios

## Segurança

- Rotas protegidas com guarda de autenticação
- Verificação de token em localStorage
- Redirecionamento automático para login quando não autenticado
- Logout com limpeza de dados de sessão

## Como Usar

1. **Login**: Acesse `/login` e insira suas credenciais
2. **Navegação**: Use a barra lateral para navegar entre as seções
3. **Logout**: Clique no botão "Sair" na barra lateral

## Tecnologias Utilizadas

- **Vue.js 3** - Framework JavaScript
- **TypeScript** - Tipagem estática
- **Vuetify** - Framework de UI
- **Vue Router** - Roteamento
- **Axios** - Cliente HTTP

## Desenvolvimento

Para executar o projeto em modo de desenvolvimento:

```bash
npm install
npm run serve
```

## API

O sistema espera uma API REST com os seguintes endpoints:

- `POST /api/auth/login` - Autenticação
- `GET /api/users` - Listar usuários
- `POST /api/users` - Criar usuário
- `PUT /api/users/:id` - Atualizar usuário
- `DELETE /api/users/:id` - Deletar usuário

## Próximos Passos

- [ ] Implementar refresh token
- [ ] Adicionar notificações toast
- [ ] Implementar upload de arquivos
- [ ] Adicionar gráficos interativos
- [ ] Implementar sistema de permissões
