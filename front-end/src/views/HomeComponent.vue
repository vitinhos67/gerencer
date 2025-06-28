<template>
  <NavBarComponent />
  <div class="home-page">
    <div class="hero-section">
      <div class="hero-content">
        <h1>Gerencer</h1>
        <p>Plataforma completa para gerenciamento de fornecedores, produtos e pedidos</p>
        <div class="hero-buttons">
          <button class="btn-primary">Começar agora</button>
          <button class="btn-secondary">Saiba mais</button>
        </div>
      </div>
    </div>
    <div class="features-section">
      <h2>Recursos principais</h2>
      <div class="features-grid">
        <div class="feature-card">
          <v-icon size="48" color="#ff6b35">mdi-store</v-icon>
          <h3>Gestão de Fornecedores</h3>
          <p>Cadastre e gerencie seus fornecedores de forma eficiente</p>
        </div>
        <div class="feature-card">
          <v-icon size="48" color="#ff6b35">mdi-package-variant</v-icon>
          <h3>Controle de Produtos</h3>
          <p>Organize seu catálogo de produtos com facilidade</p>
        </div>
        <div class="feature-card">
          <v-icon size="48" color="#ff6b35">mdi-cart</v-icon>
          <h3>Pedidos Inteligentes</h3>
          <p>Sistema completo de pedidos e entregas</p>
        </div>
      </div>
    </div>
    <FooterComponent />
  </div>
</template>

<script>
import FooterComponent from '../components/FooterComponent.vue'
import NavBarComponent from '../components/NavBarComponent.vue'

export default {
  name: 'HomeComponent',
  components: {
    FooterComponent,
    NavBarComponent
  }
}
</script>

<style scoped>
.home-page {
  flex: 1;
}

.hero-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 80px 20px;
  text-align: center;
}

.hero-content {
  max-width: 800px;
  margin: 0 auto;
}

.hero-content h1 {
  font-size: 48px;
  font-weight: 700;
  margin-bottom: 20px;
  background: linear-gradient(45deg, #ff6b35, #f7931e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-content p {
  font-size: 20px;
  margin-bottom: 40px;
  opacity: 0.9;
}

.hero-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-primary {
  background: linear-gradient(45deg, #ff6b35, #f7931e);
  color: white;
  border: none;
  padding: 15px 30px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
}

.btn-secondary {
  background: transparent;
  color: white;
  border: 2px solid white;
  padding: 13px 28px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-secondary:hover {
  background: white;
  color: #667eea;
}

.features-section {
  padding: 80px 20px;
  background: #f8f9fa;
}

.features-section h2 {
  text-align: center;
  font-size: 36px;
  font-weight: 600;
  margin-bottom: 60px;
  color: #333;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.feature-card {
  background: white;
  padding: 40px 30px;
  border-radius: 16px;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-5px);
}

.feature-card h3 {
  font-size: 24px;
  font-weight: 600;
  margin: 20px 0 15px;
  color: #333;
}

.feature-card p {
  color: #666;
  line-height: 1.6;
}

/* Responsividade */
@media (max-width: 768px) {
  .hero-content h1 {
    font-size: 36px;
  }
  
  .hero-content p {
    font-size: 18px;
  }
  
  .hero-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .btn-primary,
  .btn-secondary {
    width: 200px;
  }
  
  .features-grid {
    grid-template-columns: 1fr;
  }
}
</style> 