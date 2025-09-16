// State
let heroItems = [];
let heroIndex = 0;
let heroTimer = null;
let heroLayer = 'a';

// Data
async function fetchLandingData() {
  try {
    const res = await fetch('/landing/data', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if (!res.ok) throw new Error('Network response was not ok');
    const data = await res.json();
    heroItems = Array.isArray(data.carousels) ? data.carousels : [];
    heroIndex = 0;
    renderHeroItem(heroIndex);
    startHeroRotation();
    renderTentangKami(data.tentang_kami || null);
    renderServices(data.services || data.layanan_kami || []);
    renderDataRiset(data.data_riset || data.stats || []);
    renderGaleri(data.galeri_program || []);
  } catch (e) {
    console.error('Failed fetching landing data', e);
  }
}

// Renderers
function renderHeroItem(i) {
  const item = heroItems[i];
  if (!item) return;
  const sub = document.getElementById('hero-subheading');
  const head = document.getElementById('hero-heading');
  const desc = document.getElementById('hero-description');
  const slideA = document.getElementById('hero-slide-a');
  const slideB = document.getElementById('hero-slide-b');
  const btn1 = document.getElementById('hero-btn-1');
  const btn2 = document.getElementById('hero-btn-2');
  if (sub) sub.textContent = item.sub_heading || 'Program Prioritas Nasional';
  if (head) head.textContent = item.heading || '';
  if (desc) desc.textContent = item.deskripsi || '';
  if (item.gambar && (slideA || slideB)) {
    const url = buildImageUrl(item.gambar);
    const show = heroLayer === 'a' ? slideB : slideA;
    const hide = heroLayer === 'a' ? slideA : slideB;
    if (show && hide) {
      show.style.backgroundImage = `url(${url})`;
      // force reflow then crossfade
      requestAnimationFrame(() => {
        show.classList.remove('opacity-0');
        show.classList.add('opacity-100');
        hide.classList.remove('opacity-100');
        hide.classList.add('opacity-0');
      });
      heroLayer = heroLayer === 'a' ? 'b' : 'a';
    }
  }
  if (btn1) {
    if (item.button_1_text && item.button_1_link) {
      btn1.textContent = item.button_1_text; btn1.href = item.button_1_link; btn1.classList.remove('hidden');
    } else { btn1.classList.add('hidden'); }
  }
  if (btn2) {
    if (item.button_2_text && item.button_2_link) {
      btn2.textContent = item.button_2_text; btn2.href = item.button_2_link; btn2.classList.remove('hidden');
    } else { btn2.classList.add('hidden'); }
  }

  // Stagger text fade-up each slide
  const toAnimate = [sub, head, desc];
  if (btn1 && !btn1.classList.contains('hidden')) toAnimate.push(btn1);
  if (btn2 && !btn2.classList.contains('hidden')) toAnimate.push(btn2);
  staggerIn(toAnimate.filter(Boolean), 60);
}

// Carousel controls
function nextHero() {
  if (!heroItems.length) return;
  heroIndex = (heroIndex + 1) % heroItems.length;
  renderHeroItem(heroIndex);
}

function prevHero() {
  if (!heroItems.length) return;
  heroIndex = (heroIndex - 1 + heroItems.length) % heroItems.length;
  renderHeroItem(heroIndex);
}

function startHeroRotation() {
  if (heroTimer) clearInterval(heroTimer);
  heroTimer = setInterval(nextHero, 6000);
}

// Reveal on scroll using IntersectionObserver
let revealObserver;
function ensureRevealObserver() {
  if (revealObserver) return revealObserver;
  // Animate once when an element first enters the viewport, then stop observing
  revealObserver = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in');
        // Stop observing so we don't retrigger while visible or on minor scrolls
        obs.unobserve(entry.target);
      }
    });
  }, { rootMargin: '0px 0px -10% 0px', threshold: 0.1 });
  return revealObserver;
}

// Count-up observer that replays each time the element re-enters view
let countUpObserver;
function ensureCountUpObserver() {
  if (countUpObserver) return countUpObserver;
  countUpObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      const el = entry.target;
      const target = Number(el.getAttribute('data-count-target') || '0');
      if (entry.isIntersecting) {
        if (el.getAttribute('data-count-playing') === '1') return;
        el.setAttribute('data-count-playing', '1');
        el.textContent = '0';
        countUp(el, target, 1000, () => {
          el.classList.add('pulse-update');
          setTimeout(() => el.classList.remove('pulse-update'), 800);
          el.setAttribute('data-count-playing', '0');
        });
      } else {
        // Reset when out of view so it replays on next enter
        el.textContent = '0';
        el.setAttribute('data-count-playing', '0');
      }
    });
  }, { rootMargin: '0px 0px -10% 0px', threshold: 0.4 });
  return countUpObserver;
}

function renderServices(list) {
  const grid = document.getElementById('services-grid');
  grid.innerHTML = '';
  const obs = ensureRevealObserver();
  list.forEach((s, idx) => {
    const card = document.createElement('div');
    card.className = 'border border-gray-200 bg-white rounded p-4 flex gap-3 hover:shadow-lg transition-shadow reveal-on-scroll';
    const icon = document.createElement('img');
    icon.src = s.ikon ? buildImageUrl(s.ikon) : '';
    icon.alt = s.judul_layanan || 'ikon';
    icon.className = 'w-12 h-12 object-contain';
    const body = document.createElement('div');
    const title = document.createElement('h3');
    title.className = 'font-semibold';
    title.textContent = s.judul_layanan;
    const desc = document.createElement('p');
    desc.className = 'text-sm text-gray-600';
    desc.textContent = s.deskripsi_singkat || '';
    body.appendChild(title); body.appendChild(desc);
    card.appendChild(icon); card.appendChild(body);
    grid.appendChild(card);
    // stagger reveal
    card.style.transitionDelay = `${Math.min(idx * 50, 300)}ms`;
    obs.observe(card);
  });
}
// Tentang Kami
function renderTentangKami(about) {
  const title = document.getElementById('about-title');
  const p1 = document.getElementById('about-p1');
  const p2 = document.getElementById('about-p2');
  const btn = document.getElementById('about-cta');
  const main = document.getElementById('about-main');
  const overlay = document.getElementById('about-overlay');
  if (!about) return;
  if (about.judul_utama && title) title.textContent = about.judul_utama;
  if (about.paragraf_1 && p1) p1.textContent = about.paragraf_1;
  if (about.paragraf_2 && p2) { p2.textContent = about.paragraf_2; p2.classList.remove('hidden'); }
  if (about.teks_tombol && about.link_tombol && btn) { btn.textContent = about.teks_tombol; btn.href = about.link_tombol; btn.classList.remove('hidden'); }
  if (about.gambar_utama && main) { main.src = buildImageUrl(about.gambar_utama); }
  if (about.gambar_overlay && overlay) { overlay.src = buildImageUrl(about.gambar_overlay); /* keep hidden on mobile; md:block shows on larger */ }
}

// Data Riset
function renderDataRiset(list) {
  const grid = document.getElementById('riset-grid');
  if (!grid) return;
  grid.innerHTML = '';
  const obs = ensureRevealObserver();
  const countObs = ensureCountUpObserver();
  (list || []).forEach(r => {
    const card = document.createElement('div');
    card.className = 'border border-gray-200 bg-white rounded p-6 hover:shadow-lg transition-shadow reveal-on-scroll';
    const title = document.createElement('div');
    title.className = 'text-sm text-gray-500';
    title.textContent = r.judul || '';
    const value = document.createElement('div');
    value.className = 'text-2xl font-bold text-blue-600';
    value.textContent = '0';
    value.setAttribute('data-count-target', String(Number(r.angka || 0)));
    const time = document.createElement('div');
    time.className = 'text-xs text-gray-400';
    if (r.tanggal_update) time.textContent = formatDateTime(r.tanggal_update);
    card.appendChild(title); card.appendChild(value); card.appendChild(time);
    grid.appendChild(card);
    // observe for replaying count-up each time in view
    countObs.observe(value);
    obs.observe(card);
  });
}

// Galeri Program
function renderGaleri(list) {
  const grid = document.getElementById('galeri-grid');
  if (!grid) return;
  grid.innerHTML = '';
  (list || []).forEach(g => {
    const card = document.createElement('div');
    card.className = 'group bg-white rounded shadow overflow-hidden reveal-on-scroll';
    if (g.gambar) {
      const img = document.createElement('img');
      img.src = buildImageUrl(g.gambar);
      img.alt = g.judul || 'program';
      img.className = 'w-full h-44 object-cover transition-transform duration-300 ease-out group-hover:scale-105';
      card.appendChild(img);
    }
    const body = document.createElement('div');
    body.className = 'p-4';
    const title = document.createElement('div');
    title.className = 'font-semibold';
    title.textContent = g.judul || '';
    const desc = document.createElement('div');
    desc.className = 'text-sm text-gray-600';
    desc.textContent = g.deskripsi || '';
    body.appendChild(title); body.appendChild(desc);
    card.appendChild(body);
    grid.appendChild(card);
    ensureRevealObserver().observe(card);
  });
}

// Utils
function buildImageUrl(p) {
  if (!p) return '';
  if (p.startsWith('http://') || p.startsWith('https://')) return p;
  if (p.startsWith('/')) return p;
  return `/storage/${p}`;
}

function formatDateTime(iso) {
  try {
    const d = new Date(iso);
    if (Number.isNaN(d.getTime())) return '';
    return d.toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short' });
  } catch (_) { return ''; }
}
// Count up animation
function countUp(el, to, duration = 1000, onEnd) {
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReduced) { el.textContent = String(to); if (onEnd) onEnd(); return; }
  const start = performance.now();
  const from = 0;
  const ease = (t) => 1 - Math.pow(1 - t, 3); // easeOutCubic
  function frame(now) {
    const p = Math.min(1, (now - start) / duration);
    const val = Math.round(from + (to - from) * ease(p));
    el.textContent = String(val);
    if (p < 1) requestAnimationFrame(frame); else if (onEnd) onEnd();
  }
  requestAnimationFrame(frame);
}
// Mobile menu toggle
function bindMobileMenu() {
  const btn = document.getElementById('mobile-menu-toggle');
  const menu = document.getElementById('mobile-menu');
  if (!btn || !menu) return;
  const setOpen = (open) => {
    menu.setAttribute('data-open', String(open));
    btn.setAttribute('aria-expanded', String(open));
  };
  btn.addEventListener('click', () => {
    const isOpen = menu.getAttribute('data-open') === 'true';
    setOpen(!isOpen);
  });
  // Close on link click
  menu.addEventListener('click', (e) => {
    const t = e.target;
    if (t && t.tagName === 'A') setOpen(false);
  });
}

// Touch swipe on hero for mobile
function bindHeroSwipe() {
  const el = document.getElementById('hero');
  if (!el) return;
  let startX = 0; let startY = 0; let moved = false;
  el.addEventListener('touchstart', (e) => {
    const t = e.changedTouches[0];
    startX = t.clientX; startY = t.clientY; moved = false;
  }, { passive: true });
  el.addEventListener('touchmove', () => { moved = true; }, { passive: true });
  el.addEventListener('touchend', (e) => {
    const t = e.changedTouches[0];
    const dx = t.clientX - startX; const dy = t.clientY - startY;
    if (!moved || Math.abs(dx) < 40 || Math.abs(dx) < Math.abs(dy)) return;
    if (dx < 0) nextHero(); else prevHero();
    startHeroRotation();
  }, { passive: true });
}

// Init
function init() {
  fetchLandingData();
  bindMobileMenu();
  bindHeroSwipe();
}
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else { init(); }

document.addEventListener('click', (e) => {
  const t = e.target;
  if (!(t instanceof Element)) return;
  if (t.id === 'hero-prev') { e.preventDefault(); prevHero(); startHeroRotation(); }
  if (t.id === 'hero-next') { e.preventDefault(); nextHero(); startHeroRotation(); }
});

// Stagger helper
function staggerIn(nodes, baseDelay = 50) {
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  nodes.forEach((el, idx) => {
    el.classList.add('fade-up');
    el.classList.remove('in');
    if (prefersReduced) { el.classList.add('in'); return; }
    const delay = Math.min(baseDelay * idx, 300);
    setTimeout(() => el.classList.add('in'), delay);
  });
}

