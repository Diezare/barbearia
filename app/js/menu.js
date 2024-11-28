const btnMobile = document.getElementById('btn-mobile');

// Função para alternar o menu principal (mobile)
function toggleMenu(event) {
  if (event.type === 'touchstart') event.preventDefault();
  const nav = document.getElementById('nav');
  nav.classList.toggle('active');
  // Atualiza os atributos de acessibilidade (ARIA)
  const active = nav.classList.contains('active');
  event.currentTarget.setAttribute('aria-expanded', active);
  if (active) {
    event.currentTarget.setAttribute('aria-label', 'Fechar Menu');
  } else {
    event.currentTarget.setAttribute('aria-label', 'Abrir Menu');
  }
}

// Adiciona eventos de clique e toque para o botão de menu
btnMobile.addEventListener('click', toggleMenu);
btnMobile.addEventListener('touchstart', toggleMenu);

// Controle dos submenus
document.querySelectorAll('#menu .submenu > a').forEach(menuItem => {
  menuItem.addEventListener('click', function(event) {
      event.preventDefault(); // Evita que o link seja acionado

      const submenu = this.nextElementSibling;

      // Fecha todos os submenus, exceto o que foi clicado
      document.querySelectorAll('#menu .children').forEach(item => {
          if (item !== submenu) {
              item.classList.remove('open');
          }
      });

      // Alterna o estado do submenu atual
      submenu.classList.toggle('open');

      // Adiciona a classe 'active' ao item do menu clicado
      this.classList.toggle('active');
      
      // Remove a classe 'active' dos outros itens
      document.querySelectorAll('#menu .submenu > a').forEach(otherItem => {
          if (otherItem !== this) {
              otherItem.classList.remove('active');
          }
      });
  });
});

// Controle do cabeçalho fixo ao rolar
let lastScroll = 0;
const header = document.querySelector('#header');
const nav = document.getElementById('nav'); // Seleciona o menu principal

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;

  if (currentScroll <= 0) {
    header.classList.remove('hidden');
    return;
  }

  if (nav.classList.contains('active')) {
    // Se o menu está ativo, não esconder o cabeçalho
    header.classList.remove('hidden');
    return;
  }

  if (currentScroll > lastScroll) {
    // Rolando para baixo
    header.classList.add('hidden');
  } else {
    // Rolando para cima
    header.classList.remove('hidden');
  }

  lastScroll = currentScroll;
});
