(function() {
    // Ao carregar a página, aguardar o DOM pronto
    document.addEventListener('DOMContentLoaded', function() {
      // Alias dos elementos-chave
      const menuToggleBtn = document.getElementById('menu-toggle');
      const closeMenuBtn  = document.getElementById('close-menu');
      const offcanvasMenu = document.getElementById('offcanvas-menu');
      const backdrop      = document.getElementById('offcanvas-backdrop');
  
      if (!menuToggleBtn || !closeMenuBtn || !offcanvasMenu || !backdrop) {
        // Se algum deles não existir, abortar
        return;
      }
  
      // Função genérica para abrir o menu
      function abrirMenu() {
        // Remove a classe que deixa o menu escondido (deslizando pra fora)
        offcanvasMenu.classList.remove('-translate-x-full');
        offcanvasMenu.classList.add('translate-x-0');
  
        // Exibe o backdrop
        backdrop.classList.remove('hidden');
      }
  
      // Função para fechar o menu
      function fecharMenu() {
        // Volta o menu a ficar deslocado para a esquerda
        offcanvasMenu.classList.remove('translate-x-0');
        offcanvasMenu.classList.add('-translate-x-full');
  
        // Oculta o backdrop
        backdrop.classList.add('hidden');
      }
  
      // Ao clicar no botão “Menu” (ícone de hambúrguer)
      menuToggleBtn.addEventListener('click', function() {
        abrirMenu();
      });
  
      // Ao clicar no “X” dentro do menu
      closeMenuBtn.addEventListener('click', function() {
        fecharMenu();
      });
  
      // Também fechar ao clicar sobre o próprio backdrop
      backdrop.addEventListener('click', function() {
        fecharMenu();
      });
    });
  })();
  