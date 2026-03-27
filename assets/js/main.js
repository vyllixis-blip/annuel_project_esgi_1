/**
 * GAMELIB - Advanced JavaScript Experience 🎮
 * Featuring: Parallax, Particles, Dark Mode, Animations, Keyboard Shortcuts & More
 * ESGI PROJECT 2025
 */

// ============================================
// GLOBAL STATE MANAGEMENT
// ============================================
const GamelibState = {
  darkMode: localStorage.getItem('gamelib-darkmode') === 'true',
  wishlist: JSON.parse(localStorage.getItem('gamelib-wishlist') || '[]'),
  cursor: { x: 0, y: 0 },
  scrollPos: 0,
  isTouchDevice: () => (('ontouchstart' in window) || (navigator.maxTouchPoints > 0))
};

// ============================================
// PARTICLES & ANIMATED BACKGROUND
// ============================================
class ParticleBackground {
  constructor(container) {
    this.canvas = document.createElement('canvas');
    this.ctx = this.canvas.getContext('2d');
    this.particles = [];
    
    this.canvas.classList.add('particle-canvas');
    this.canvas.style.cssText = `
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    `;
    container.style.position = 'relative';
    container.appendChild(this.canvas);
    
    this.resize();
    window.addEventListener('resize', () => this.resize());
    this.createParticles();
    this.animate();
  }

  resize() {
    this.canvas.width = window.innerWidth;
    this.canvas.height = this.canvas.parentElement.offsetHeight;
  }

  createParticles() {
    const particleCount = Math.max(15, Math.floor(window.innerWidth / 150));
    for (let i = 0; i < particleCount; i++) {
      this.particles.push({
        x: Math.random() * this.canvas.width,
        y: Math.random() * this.canvas.height,
        vx: (Math.random() - 0.5) * 0.3,
        vy: (Math.random() - 0.5) * 0.3,
        radius: Math.random() * 1.5 + 0.5,
        opacity: Math.random() * 0.6 + 0.1,
        baseOpacity: Math.random() * 0.6 + 0.1
      });
    }
  }

  animate() {
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

    this.particles.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;

      if (p.x < 0 || p.x > this.canvas.width) p.vx *= -1;
      if (p.y < 0 || p.y > this.canvas.height) p.vy *= -1;

      p.opacity = p.baseOpacity * (0.5 + 0.5 * Math.sin(Date.now() * 0.001 + p.x));

      this.ctx.fillStyle = `rgba(124, 58, 237, ${p.opacity})`;
      this.ctx.beginPath();
      this.ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
      this.ctx.fill();
    });

    // Connection lines
    for (let i = 0; i < this.particles.length; i++) {
      for (let j = i + 1; j < this.particles.length; j++) {
        const dx = this.particles[i].x - this.particles[j].x;
        const dy = this.particles[i].y - this.particles[j].y;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < 120) {
          this.ctx.strokeStyle = `rgba(124, 58, 237, ${0.15 * (1 - distance / 120)})`;
          this.ctx.lineWidth = 0.8;
          this.ctx.beginPath();
          this.ctx.moveTo(this.particles[i].x, this.particles[i].y);
          this.ctx.lineTo(this.particles[j].x, this.particles[j].y);
          this.ctx.stroke();
        }
      }
    }

    requestAnimationFrame(() => this.animate());
  }
}

// ============================================
// DARK MODE TOGGLE
// ============================================
function initializeDarkMode() {
  let darkModeBtn = document.querySelector('[data-dark-mode-toggle]');
  if (!darkModeBtn) {
    darkModeBtn = document.createElement('button');
    darkModeBtn.setAttribute('data-dark-mode-toggle', '');
    darkModeBtn.className = 'dark-mode-toggle';
    const navbar = document.querySelector('nav');
    if (navbar) navbar.appendChild(darkModeBtn);
  }

  const applyDarkMode = (isDark) => {
    document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
    document.body.classList.toggle('dark-mode', isDark);
    darkModeBtn.innerHTML = isDark ? '☀️' : '🌙';
    darkModeBtn.title = isDark ? 'Mode Clair (Ctrl+D)' : 'Mode Sombre (Ctrl+D)';
    GamelibState.darkMode = isDark;
    localStorage.setItem('gamelib-darkmode', isDark);
  };

  if (GamelibState.darkMode) applyDarkMode(true);
  darkModeBtn.addEventListener('click', () => { applyDarkMode(!GamelibState.darkMode); });
}

// ============================================
// SMOOTH SCROLL & PARALLAX EFFECTS
// ============================================
function initializeScrollEffects() {
  window.addEventListener('scroll', () => {
    GamelibState.scrollPos = window.scrollY;
    const navbar = document.querySelector('nav');
    if (navbar) navbar.classList.toggle('navbar-scrolled', window.scrollY > 40);

    document.querySelectorAll('[data-parallax]').forEach(el => {
      const speed = parseFloat(el.dataset.parallax) || 0.5;
      el.style.transform = `translateY(${GamelibState.scrollPos * speed}px)`;
    });
  }, { passive: true });
}

// ============================================
// SCROLL ANIMATIONS
// ============================================
function initializeScrollAnimations() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view', 'fade-in-up');
        const children = entry.target.querySelectorAll('[data-stagger]');
        children.forEach((child, i) => {
          child.style.animationDelay = `${i * 0.08}s`;
          child.classList.add('stagger-item');
        });
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -80px 0px' });

  document.querySelectorAll('.game-card, .category-card, .featured-card-large, .team-member, .collection-card, .stat-item, [data-scroll-animate]').forEach(el => {
    observer.observe(el);
  });
}

// ============================================
// WISHLIST SYSTEM
// ============================================
function initializeWishlist() {
  document.querySelectorAll('.game-card-wishlist, [data-wishlist]').forEach(btn => {
    const gameId = btn.dataset.gameId || btn.closest('.game-card')?.dataset.gameId;
    if (gameId && GamelibState.wishlist.includes(gameId)) {
      btn.classList.add('active');
      btn.innerHTML = '♥';
    }
  });

  document.addEventListener('click', e => {
    const wishlistBtn = e.target.closest('.game-card-wishlist, [data-wishlist]');
    if (!wishlistBtn) return;

    const gameId = wishlistBtn.dataset.gameId || wishlistBtn.closest('.game-card')?.dataset.gameId;
    if (!gameId) return;

    wishlistBtn.classList.add('heartbeat');
    const heart = document.createElement('div');
    heart.innerHTML = '♥';
    heart.className = 'floating-heart';
    heart.style.cssText = `position: fixed; left: ${e.clientX}px; top: ${e.clientY}px; font-size: 24px; color: #ef4444; pointer-events: none; z-index: 10000; animation: floatHeart 1s ease-out forwards;`;
    document.body.appendChild(heart);

    if (GamelibState.wishlist.includes(gameId)) {
      GamelibState.wishlist = GamelibState.wishlist.filter(id => id !== gameId);
      wishlistBtn.classList.remove('active');
      wishlistBtn.innerHTML = '♡';
    } else {
      GamelibState.wishlist.push(gameId);
      wishlistBtn.classList.add('active');
      wishlistBtn.innerHTML = '♥';
    }

    localStorage.setItem('gamelib-wishlist', JSON.stringify(GamelibState.wishlist));
    setTimeout(() => {
      wishlistBtn.classList.remove('heartbeat');
      heart.remove();
    }, 1000);
  });
}

// ============================================
// FLASH MESSAGE ANIMATIONS
// ============================================
function initializeFlashMessages() {
  const flashes = document.querySelectorAll('.flash');
  flashes.forEach((flash, index) => {
    flash.style.animation = 'slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';
    flash.style.animationDelay = `${index * 100}ms`;

    const closeBtn = flash.querySelector('[data-close]');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        flash.style.animation = 'slideOutRight 0.3s ease forwards';
        setTimeout(() => flash.remove(), 300);
      });
    }

    setTimeout(() => {
      flash.style.animation = 'slideOutRight 0.3s ease forwards';
      setTimeout(() => flash.remove(), 300);
    }, 6000);
  });
}

// ============================================
// FORM INTERACTIONS & VALIDATION
// ============================================
function initializeFormInteractions() {
  document.querySelectorAll('.form-group input, .form-group textarea').forEach(input => {
    const updateLabel = () => {
      const group = input.closest('.form-group');
      input.value ? group?.classList.add('has-value') : group?.classList.remove('has-value');
    };
    input.addEventListener('focus', () => input.closest('.form-group')?.classList.add('focused'));
    input.addEventListener('blur', updateLabel);
    input.addEventListener('input', updateLabel);
    updateLabel();
  });

  document.addEventListener('click', e => {
    if (e.target.closest('[data-toggle-password]')) {
      const btn = e.target.closest('[data-toggle-password]');
      const input = btn.previousElementSibling?.querySelector('input') || btn.parentElement.querySelector('input[type="password"]');
      if (!input) return;
      input.type = input.type === 'password' ? 'text' : 'password';
      btn.innerHTML = input.type === 'text' ? '👁‍🗨' : '👁';
    }
  });

  document.querySelectorAll('input[data-validate], textarea[data-validate]').forEach(input => {
    input.addEventListener('input', () => {
      const rule = input.dataset.validate;
      const value = input.value;
      let isValid = true;

      if (rule === 'email' && value) isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
      else if (rule === 'password' && value) isValid = value.length >= 8;
      else if (rule === 'username' && value) isValid = /^[a-zA-Z0-9_-]{3,}$/.test(value);

      const feedback = input.parentElement?.querySelector('.form-feedback');
      input.classList.toggle('is-invalid', !isValid && value !== '');
      input.classList.toggle('is-valid', isValid && value !== '');
      if (feedback) feedback.style.opacity = (!isValid && value !== '') ? '1' : '0';
    });
  });
}

// ============================================
// KEYBOARD SHORTCUTS
// ============================================
function initializeKeyboardShortcuts() {
  document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
      e.preventDefault();
      document.querySelector('[data-dark-mode-toggle]')?.click();
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      document.querySelector('.hero-search-input, [data-search-input]')?.focus();
    }
    if (e.key === '/' && e.target !== document.querySelector('.hero-search-input, [data-search-input]')) {
      e.preventDefault();
      document.querySelector('.hero-search-input, [data-search-input]')?.focus();
    }
  });
}

// ============================================
// REAL-TIME SEARCH SUGGESTIONS
// ============================================
function initializeSearchSuggestions() {
  const searchInput = document.querySelector('.hero-search-input, [data-search-input]');
  if (!searchInput) return;

  const suggestionsContainer = document.createElement('div');
  suggestionsContainer.className = 'search-suggestions';
  suggestionsContainer.style.cssText = `position: absolute; top: 100%; left: 0; right: 0; background: var(--color-card, white); border-radius: 8px; margin-top: 8px; max-height: 300px; overflow-y: auto; display: none; z-index: 100; box-shadow: 0 10px 30px rgba(0,0,0,0.2);`;
  searchInput.parentElement?.appendChild(suggestionsContainer);

  searchInput.addEventListener('input', (e) => {
    const query = e.target.value.toLowerCase().trim();
    if (query.length < 2) {
      suggestionsContainer.style.display = 'none';
      return;
    }

    const suggestions = [
      { title: 'Elden Ring', icon: '⚔️' },
      { title: 'Baldur\'s Gate 3', icon: '🎭' },
      { title: 'Starfield', icon: '🚀' },
      { title: 'Cyberpunk 2077', icon: '🤖' },
      { title: 'Final Fantasy VII', icon: '⚡' }
    ].filter(s => s.title.toLowerCase().includes(query));

    suggestionsContainer.innerHTML = suggestions.map(s => 
      `<a href="/pages/games.php?q=${s.title}" class="suggestion-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; text-decoration: none; color: inherit; border-bottom: 1px solid rgba(0,0,0,0.1); transition: background 0.2s; cursor: pointer;"><span>${s.icon}</span><span style="flex: 1;">${s.title}</span><span style="opacity: 0.5; font-size: 12px;">→</span></a>`
    ).join('');

    suggestionsContainer.style.display = suggestions.length ? 'block' : 'none';
    suggestionsContainer.querySelectorAll('.suggestion-item').forEach(item => {
      item.addEventListener('mouseenter', (e) => { e.target.style.backgroundColor = 'rgba(124, 58, 237, 0.08)'; });
      item.addEventListener('mouseleave', (e) => { e.target.style.backgroundColor = 'transparent'; });
    });
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('[data-search-input], .hero-search-input, .search-suggestions')) {
      suggestionsContainer.style.display = 'none';
    }
  });
}

// ============================================
// SMOOTH PAGE TRANSITIONS
// ============================================
function initializePageTransitions() {
  document.addEventListener('click', e => {
    const link = e.target.closest('a:not([target="_blank"]):not([download])');
    if (!link) return;
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.closest('form')) return;
    e.preventDefault();
    document.body.classList.add('page-transitioning');
    setTimeout(() => { window.location.href = href; }, 300);
  });
  window.addEventListener('pageshow', () => {
    document.body.classList.remove('page-transitioning');
    document.body.style.opacity = '1';
  });
}

// ============================================
// BUTTON RIPPLE EFFECT
// ============================================
function initializeRippleEffect() {
  document.addEventListener('click', e => {
    const btn = e.target.closest('button, .btn, [role="button"]');
    if (!btn) return;
    const ripple = document.createElement('span');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;
    ripple.className = 'ripple';
    ripple.style.cssText = `position: absolute; width: ${size}px; height: ${size}px; background: rgba(255,255,255,0.5); border-radius: 50%; left: ${x}px; top: ${y}px; animation: rippleOut 0.6s ease-out forwards; pointer-events: none;`;
    btn.style.position = 'relative';
    btn.style.overflow = 'hidden';
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
  });
}

// ============================================
// ANIMATED COUNTERS
// ============================================
function initializeCounters() {
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
        const finalValue = parseInt(entry.target.textContent.replace(/\D/g, ''));
        animateCounter(entry.target, finalValue);
        entry.target.classList.add('counted');
        counterObserver.unobserve(entry.target);
      }
    });
  });
  document.querySelectorAll('[data-counter], .stat-value').forEach(el => {
    counterObserver.observe(el);
  });
}

function animateCounter(el, target) {
  let current = 0;
  const increment = target / 40;
  const originalText = el.textContent;
  const counter = setInterval(() => {
    current += increment;
    if (current >= target) {
      el.textContent = originalText;
      clearInterval(counter);
    } else {
      el.textContent = Math.floor(current).toLocaleString('fr-FR');
    }
  }, 20);
}

// ============================================
// MOUSE TRACKING
// ============================================
function initializeMouseTracking() {
  if (GamelibState.isTouchDevice()) return;
  document.addEventListener('mousemove', (e) => {
    GamelibState.cursor = { x: e.clientX, y: e.clientY };
    const navbar = document.querySelector('nav');
    if (navbar && GamelibState.scrollPos < 300) {
      const rect = navbar.getBoundingClientRect();
      const distance = Math.hypot(e.clientX - rect.right, e.clientY - rect.top);
      const glowIntensity = Math.max(0, 1 - distance / 300);
      navbar.style.boxShadow = `0 0 ${30 + glowIntensity * 40}px rgba(124, 58, 237, ${glowIntensity * 0.3})`;
    }
  });
}

// ============================================
// INITIALIZE ALL ON DOM READY
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  initializeDarkMode();
  initializeScrollEffects();
  initializeScrollAnimations();
  initializeWishlist();
  initializeFlashMessages();
  initializeFormInteractions();
  initializeKeyboardShortcuts();
  initializeSearchSuggestions();
  initializePageTransitions();
  initializeRippleEffect();
  initializeCounters();
  initializeMouseTracking();

  if (window.innerWidth > 768) {
    const hero = document.querySelector('.hero');
    if (hero) { try { new ParticleBackground(hero); } catch (e) { console.warn('Particles failed:', e); } }
  }

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', e => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  console.log('%c🎮 GameLib - Raccourcis Clavier', 'color: #7c3aed; font-size: 16px; font-weight: bold;');
  console.log('%c/ - Chercher | Ctrl+D - Dark Mode | Ctrl+K - Recherche', 'color: #06b6d4; font-size: 12px;');
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
  @keyframes floatHeart { 0% { opacity: 1; transform: translate(0, 0) scale(1); } 100% { opacity: 0; transform: translate(-20px, -100px) scale(0.5); } }
  @keyframes rippleOut { 0% { transform: scale(0); } 100% { transform: scale(1); opacity: 0; } }
  @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
  @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
  @keyframes fade-in-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes pageTransition { to { opacity: 0; } }
  .fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
  .stagger-item { animation: fade-in-up 0.6s ease-out forwards; }
  .page-transitioning { animation: pageTransition 0.3s ease forwards; }
  .dark-mode-toggle { width: 44px; height: 44px; border: none; background: transparent; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.3s ease; margin: 0 8px; }
  .dark-mode-toggle:hover { background: rgba(124, 58, 237, 0.1); transform: rotate(20deg); }
  .heartbeat { animation: heartbeat 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
  @keyframes heartbeat { 0% { transform: scale(1); } 25% { transform: scale(1.3); } 50% { transform: scale(1); } 75% { transform: scale(1.3); } 100% { transform: scale(1); } }
`;
document.head.appendChild(style);

window.GamelibState = GamelibState;
