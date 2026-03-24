/**
 * ESGI PROJECT, 2025
 * assets/js/main.js
 * Global JavaScript for GameLib
 */

/* ─── Navbar scroll effect ───────────────────────────────────────── */
(function () {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;
    const onScroll = () => {
        navbar.classList.toggle('navbar-scrolled', window.scrollY > 40);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();

/* ─── Flash message auto-dismiss ────────────────────────────────── */
document.querySelectorAll('.flash').forEach(el => {
    setTimeout(() => el.remove(), 5000);
});

/* ─── Wishlist heart toggle ─────────────────────────────────────── */
document.addEventListener('click', e => {
    const btn = e.target.closest('.game-card-wishlist');
    if (!btn) return;
    const isFilled = btn.textContent.trim() === '♥';
    btn.textContent = isFilled ? '♡' : '♥';
    btn.style.color = isFilled ? '' : '#ef4444';
    btn.title = isFilled ? 'Ajouter aux favoris' : 'Retirer des favoris';
});

/* ─── Hero search: pressing Enter submits ───────────────────────── */
const heroInput = document.querySelector('.hero-search-input');
if (heroInput) {
    heroInput.closest('form')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') e.currentTarget.submit();
    });
}

/* ─── Smooth scroll for anchor links ────────────────────────────── */
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

/* ─── Game grid: filter chips (categories/games pages) ─────────── */
document.querySelectorAll('[data-filter-chip]').forEach(chip => {
    chip.addEventListener('click', () => {
        document.querySelectorAll('[data-filter-chip]').forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
    });
});

/* ─── Form: show/hide password ──────────────────────────────────── */
document.querySelectorAll('[data-toggle-password]').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.togglePassword);
        if (!input) return;
        const hidden = input.type === 'password';
        input.type = hidden ? 'text' : 'password';
        btn.textContent = hidden ? '🙈' : '👁';
    });
});

/* ─── Lazy-load placeholder gradients ───────────────────────────── */
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, { rootMargin: '100px' });

document.querySelectorAll('.game-card, .featured-card-large, .latest-game-card').forEach(el => {
    observer.observe(el);
});
