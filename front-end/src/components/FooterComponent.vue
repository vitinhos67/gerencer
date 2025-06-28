<template>
  <footer class="footer">
    <div class="footer-content">
      <!-- Seção Principal -->
      <div class="footer-main">
        <div class="footer-section">
          <h3 class="footer-title">Gerencer</h3>
          <p class="footer-description">
            Plataforma completa para gerenciamento de fornecedores, produtos e pedidos. 
            Conectamos você aos melhores parceiros comerciais.
          </p>
          <div class="social-links">
            <a href="#" class="social-link">
              <v-icon>mdi-facebook</v-icon>
            </a>
            <a href="#" class="social-link">
              <v-icon>mdi-instagram</v-icon>
            </a>
            <a href="#" class="social-link">
              <v-icon>mdi-linkedin</v-icon>
            </a>
            <a href="#" class="social-link">
              <v-icon>mdi-twitter</v-icon>
            </a>
          </div>
        </div>

        <div class="footer-section">
          <h4 class="footer-subtitle">Para Fornecedores</h4>
          <ul class="footer-links">
            <li><a href="#" class="footer-link">Cadastre sua empresa</a></li>
            <li><a href="#" class="footer-link">Gerenciar produtos</a></li>
            <li><a href="#" class="footer-link">Relatórios de vendas</a></li>
            <li><a href="#" class="footer-link">Configurações de pagamento</a></li>
            <li><a href="#" class="footer-link">Horários de funcionamento</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h4 class="footer-subtitle">Para Clientes</h4>
          <ul class="footer-links">
            <li><a href="#" class="footer-link">Encontrar fornecedores</a></li>
            <li><a href="#" class="footer-link">Fazer pedidos</a></li>
            <li><a href="#" class="footer-link">Acompanhar entregas</a></li>
            <li><a href="#" class="footer-link">Histórico de compras</a></li>
            <li><a href="#" class="footer-link">Avaliações</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h4 class="footer-subtitle">Suporte</h4>
          <ul class="footer-links">
            <li><a href="#" class="footer-link">Central de ajuda</a></li>
            <li><a href="#" class="footer-link">Fale conosco</a></li>
            <li><a href="#" class="footer-link">Política de privacidade</a></li>
            <li><a href="#" class="footer-link">Termos de uso</a></li>
            <li><a href="#" class="footer-link">FAQ</a></li>
          </ul>
        </div>
      </div>

      <!-- Seção de Download -->
      <div class="footer-download">
        <div class="download-content">
          <h4 class="download-title">Baixe nosso app</h4>
          <p class="download-description">
            Gerencie seus fornecedores e pedidos de qualquer lugar
          </p>
          <div class="download-buttons">
            <a href="#" class="download-btn">
              <v-icon>mdi-apple</v-icon>
              <span>App Store</span>
            </a>
            <a href="#" class="download-btn">
              <v-icon>mdi-google-play</v-icon>
              <span>Google Play</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Linha divisória -->
    <div class="footer-divider"></div>

    <!-- Rodapé inferior -->
    <div class="footer-bottom">
      <div class="footer-bottom-content">
        <p class="copyright">
          © 2024 Gerencer. Todos os direitos reservados.
        </p>
        <div class="footer-bottom-links">
          <a href="#" class="bottom-link">Privacidade</a>
          <a href="#" class="bottom-link">Termos</a>
          <a href="#" class="bottom-link">Cookies</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'FooterComponent',
})
</script>

<style scoped>
.footer {
  background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
  color: #ffffff;
  padding: 0;
  margin-top: auto;
}

.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 60px 20px 40px;
}

.footer-main {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 40px;
  margin-bottom: 40px;
}

.footer-section {
  display: flex;
  flex-direction: column;
}

.footer-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 16px;
  background: linear-gradient(45deg, #ff6b35, #f7931e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.footer-description {
  font-size: 16px;
  line-height: 1.6;
  color: #b0b0b0;
  margin-bottom: 24px;
  max-width: 300px;
}

.social-links {
  display: flex;
  gap: 16px;
}

.social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  color: #ffffff;
  text-decoration: none;
  transition: all 0.3s ease;
}

.social-link:hover {
  background: linear-gradient(45deg, #ff6b35, #f7931e);
  transform: translateY(-2px);
}

.footer-subtitle {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 20px;
  color: #ffffff;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 12px;
}

.footer-link {
  color: #b0b0b0;
  text-decoration: none;
  font-size: 14px;
  transition: color 0.3s ease;
  display: block;
  padding: 4px 0;
}

.footer-link:hover {
  color: #ff6b35;
}

.footer-download {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 16px;
  padding: 32px;
  margin-top: 40px;
}

.download-content {
  text-align: center;
}

.download-title {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 12px;
  color: #ffffff;
}

.download-description {
  font-size: 16px;
  color: #b0b0b0;
  margin-bottom: 24px;
}

.download-buttons {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
}

.download-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(45deg, #ff6b35, #f7931e);
  color: #ffffff;
  text-decoration: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.download-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
}

.footer-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  margin: 0 20px;
}

.footer-bottom {
  padding: 24px 20px;
}

.footer-bottom-content {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}

.copyright {
  color: #b0b0b0;
  font-size: 14px;
}

.footer-bottom-links {
  display: flex;
  gap: 24px;
}

.bottom-link {
  color: #b0b0b0;
  text-decoration: none;
  font-size: 14px;
  transition: color 0.3s ease;
}

.bottom-link:hover {
  color: #ff6b35;
}

/* Responsividade */
@media (max-width: 768px) {
  .footer-main {
    grid-template-columns: 1fr;
    gap: 32px;
  }

  .footer-content {
    padding: 40px 20px 30px;
  }

  .footer-bottom-content {
    flex-direction: column;
    text-align: center;
  }

  .download-buttons {
    flex-direction: column;
    align-items: center;
  }

  .download-btn {
    width: 200px;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .footer-content {
    padding: 30px 16px 20px;
  }

  .footer-title {
    font-size: 24px;
  }

  .footer-description {
    font-size: 14px;
  }
}
</style> 