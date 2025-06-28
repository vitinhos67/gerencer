<template>
  <NavBarComponent />
  <div class="about-page">
    <div class="about-content">
      <h1>Sobre o Gerencer</h1>
      <p>Somos uma plataforma inovadora que conecta fornecedores e clientes, 
      facilitando o gerenciamento de produtos e pedidos de forma eficiente e transparente.</p>
      <div class="about-stats">
        <div class="stat">
          <h3>100+</h3>
          <p>Fornecedores</p>
        </div>
        <div class="stat">
          <h3>1000+</h3>
          <p>Produtos</p>
        </div>
        <div class="stat">
          <h3>500+</h3>
          <p>Pedidos</p>
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
  name: 'AboutComponent',
  components: {
    FooterComponent,
    NavBarComponent
  }
}
</script>

<style scoped>
.about-page {
  flex: 1;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.about-content {
  flex: 1;
  max-width: 800px;
  margin: 0 auto;
  padding: 80px 20px;
  text-align: center;
}

.about-content h1 {
  font-size: 48px;
  font-weight: 700;
  margin-bottom: 30px;
  background: linear-gradient(45deg, #ff6b35, #f7931e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.about-content p {
  font-size: 18px;
  line-height: 1.6;
  margin-bottom: 60px;
  opacity: 0.9;
}

.about-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
  margin-top: 60px;
}

.stat {
  background: rgba(255, 255, 255, 0.1);
  padding: 30px;
  border-radius: 16px;
  backdrop-filter: blur(10px);
}

.stat h3 {
  font-size: 36px;
  font-weight: 700;
  margin-bottom: 10px;
  color: #ff6b35;
}

.stat p {
  font-size: 16px;
  opacity: 0.8;
  margin: 0;
}

/* Responsividade */
@media (max-width: 768px) {
  .about-content h1 {
    font-size: 36px;
  }
  
  .about-stats {
    grid-template-columns: 1fr;
  }
}
</style> 