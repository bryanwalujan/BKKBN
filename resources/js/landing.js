// State
let heroItems = [];
let heroIndex = 0;
let heroTimer = null;
let heroLayer = 'a';

const LANDING_DATA_CACHE_KEY = 'landing-data:v1';
const EDUKASI_CATEGORY_LABELS = {
  penyebaran_informasi_media: 'Penyebaran Informasi melalui Media',
  konseling_perubahan_perilaku: 'Konseling Perubahan Perilaku Antar Pribadi',
  konseling_pengasuhan: 'Konseling Pengasuhan untuk Orang Tua',
  paud: 'PAUD (Pendidikan Anak Usia Dini)',
  konseling_kesehatan_reproduksi: 'Konseling Kesehatan Reproduksi untuk Remaja',
  ppa: 'PPA (Pemberdayaan Perempuan dan Perlindungan Anak)',
  modul_buku_saku: 'Modul dan Buku Saku Pencegahan dan Penanganan Stunting',
};
const RISET_CHART_COLORS = ['#1d4ed8', '#0ea5e9', '#22c55e', '#f97316', '#f43f5e', '#8b5cf6', '#f59e0b', '#14b8a6'];

function applyLandingData(data) {
  if (!data || typeof data !== 'object') return false;
  heroItems = Array.isArray(data.carousels) ? data.carousels : [];
  heroIndex = 0;
  renderHeroItem(heroIndex);
  startHeroRotation();
  renderTentangKami(data.tentang_kami || null);
  renderServices(data.services || data.layanan_kami || []);
  renderDataRiset(data.data_riset || data.stats || []);
  renderGaleri(data.galeri_program || []);
  renderEdukasi(data.edukasi || []);
  return true;
}

function hydrateLandingFromCache() {
  if (typeof sessionStorage === 'undefined') return false;
  try {
    const raw = sessionStorage.getItem(LANDING_DATA_CACHE_KEY);
    if (!raw) return false;
    const cached = JSON.parse(raw);
    if (!applyLandingData(cached)) return false;
    observeStaticReveals();
    return true;
  } catch (err) {
    console.warn('Failed to restore landing data cache', err);
    return false;
  }
}

// Data
async function fetchLandingData() {
  try {
    const res = await fetch('/landing/data', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if (!res.ok) throw new Error('Network response was not ok');
    const data = await res.json();
    if (!applyLandingData(data)) return;
    try {
      if (typeof sessionStorage !== 'undefined') {
        sessionStorage.setItem(LANDING_DATA_CACHE_KEY, JSON.stringify(data));
      }
    } catch (err) {
      console.warn('Failed to cache landing data', err);
    }
    observeStaticReveals();
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
  if (!heroItems || heroItems.length <= 1) {
    heroTimer = null;
    return;
  }
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

function setupReveal(el, opts = {}) {
  if (!el) return;
  const alreadyBound = el.getAttribute('data-reveal-bound') === '1';
  const hasDistance = opts.distance !== undefined || el.hasAttribute('data-reveal-distance');
  const hasDirection = Boolean(opts.direction) || el.hasAttribute('data-reveal-direction');
  if (hasDistance || hasDirection) {
    const directionAttr = opts.direction || el.getAttribute('data-reveal-direction') || 'up';
    const direction = typeof directionAttr === 'string' ? directionAttr.toLowerCase() : 'up';
    const distanceSource = opts.distance !== undefined ? opts.distance : el.getAttribute('data-reveal-distance');
    const dist = distanceSource !== null && distanceSource !== undefined && distanceSource !== ''
      ? Math.max(Number(distanceSource) || 0, 0)
      : 16;
    let transform = `translate3d(0, ${dist}px, 0)`;
    switch (direction) {
      case 'down':
        transform = `translate3d(0, ${-dist}px, 0)`;
        break;
      case 'left':
        transform = `translate3d(${-dist}px, 0, 0)`;
        break;
      case 'right':
        transform = `translate3d(${dist}px, 0, 0)`;
        break;
      case 'none':
      case 'static':
        transform = 'translate3d(0, 0, 0)';
        break;
      default:
        transform = `translate3d(0, ${dist}px, 0)`;
    }
    if (dist === 0) transform = 'translate3d(0, 0, 0)';
    el.style.setProperty('--reveal-transform', transform);
  }

  const delaySource = opts.delay !== undefined ? opts.delay : el.getAttribute('data-reveal-delay');
  if (delaySource !== null && delaySource !== undefined && delaySource !== '') {
    const delay = Number(delaySource);
    if (Number.isFinite(delay) && delay >= 0) {
      el.style.transitionDelay = `${delay}ms`;
    }
  }

  const durationSource = opts.duration !== undefined ? opts.duration : el.getAttribute('data-reveal-duration');
  if (durationSource !== null && durationSource !== undefined && durationSource !== '') {
    const duration = Number(durationSource);
    if (Number.isFinite(duration) && duration > 0) {
      el.style.transitionDuration = `${duration}ms`;
    }
  }

  const easingAttr = opts.easing || el.getAttribute('data-reveal-easing');
  if (easingAttr) {
    el.style.transitionTimingFunction = easingAttr;
  }

  if (!alreadyBound) {
    ensureRevealObserver().observe(el);
    el.setAttribute('data-reveal-bound', '1');
  }
}

function observeStaticReveals() {
  document.querySelectorAll('.reveal-on-scroll').forEach((el) => {
    setupReveal(el);
  });
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
  if (!grid) return;
  grid.innerHTML = '';
  list.forEach((s, idx) => {
    const card = document.createElement('div');
    card.className = 'border border-gray-200 bg-white rounded p-4 flex gap-3 hover:shadow-lg transition-shadow reveal-on-scroll';
    const safeTitle = s.judul_layanan || '';
    if (s.ikon) {
      const icon = document.createElement('img');
      icon.src = buildImageUrl(s.ikon);
      icon.alt = safeTitle || 'ikon layanan';
      icon.className = 'w-12 h-12 object-contain';
      icon.loading = 'lazy';
      icon.decoding = 'async';
      card.appendChild(icon);
    } else {
      const placeholder = document.createElement('div');
      placeholder.className = 'w-12 h-12 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 font-semibold';
      placeholder.textContent = (safeTitle.slice(0, 1).toUpperCase()) || 'L';
      card.appendChild(placeholder);
    }
    const body = document.createElement('div');
    const title = document.createElement('h3');
    title.className = 'font-semibold break-words';
    title.textContent = safeTitle || 'Layanan';
    const desc = document.createElement('p');
    desc.className = 'text-sm text-gray-600 break-words';
    desc.textContent = s.deskripsi_singkat || '';
    body.appendChild(title);
    body.appendChild(desc);
    card.appendChild(body);
    grid.appendChild(card);
    setupReveal(card, { delay: Math.min(idx * 60, 360) });
  });
}
// Tentang Kami
function renderTentangKami(about) {
  const title = document.getElementById('about-title');
  const p1 = document.getElementById('about-p1');
  const p2 = document.getElementById('about-p2');
  const btn = document.getElementById('about-cta');
  const main = document.getElementById('about-main');
  const overlayFrame = document.getElementById('about-overlay-frame');
  const overlay = document.getElementById('about-overlay');
  if (!about) {
    if (p1) p1.textContent = '';
    if (p2) { p2.textContent = ''; p2.classList.add('hidden'); }
    if (btn) btn.classList.add('hidden');
    if (main) main.setAttribute('hidden', '');
    if (overlay) overlay.setAttribute('hidden', '');
    if (overlayFrame) overlayFrame.classList.add('hidden');
    return;
  }
  if (title) title.textContent = about.judul_utama || 'BKKBN';
  if (p1) p1.textContent = about.paragraf_1 || '';
  if (p2) {
    if (about.paragraf_2) {
      p2.textContent = about.paragraf_2;
      p2.classList.remove('hidden');
    } else {
      p2.textContent = '';
      p2.classList.add('hidden');
    }
  }
  if (btn) {
    if (about.teks_tombol && about.link_tombol) {
      btn.textContent = about.teks_tombol;
      btn.href = about.link_tombol;
      btn.classList.remove('hidden');
    } else {
      btn.textContent = '';
      btn.classList.add('hidden');
    }
  }
  if (main) {
    if (about.gambar_utama) {
      main.src = buildImageUrl(about.gambar_utama);
      main.removeAttribute('data-src');
      main.style.removeProperty('display');
      main.removeAttribute('hidden');
    } else {
      main.removeAttribute('src');
      main.setAttribute('hidden', '');
    }
  }
  if (overlay) {
    if (about.gambar_overlay) {
      overlay.src = buildImageUrl(about.gambar_overlay);
      overlay.removeAttribute('data-src');
      overlay.style.removeProperty('display');
      overlay.removeAttribute('hidden');
      if (overlayFrame) overlayFrame.classList.remove('hidden');
    } else {
      overlay.removeAttribute('src');
      overlay.setAttribute('hidden', '');
      if (overlayFrame) overlayFrame.classList.add('hidden');
    }
  } else if (overlayFrame) {
    overlayFrame.classList.add('hidden');
  }
}

// Data Riset
function renderDataRiset(list) {
  const grid = document.getElementById('riset-grid');
  if (!grid) return;
  grid.innerHTML = '';
  const countObs = ensureCountUpObserver();
  (list || []).forEach((r, idx) => {
    const card = document.createElement('div');
    card.className = 'riset-card reveal-on-scroll soft-lift';
    const title = document.createElement('div');
    title.className = 'text-sm text-gray-500 break-words';
    title.textContent = r.judul || '';
    const value = document.createElement('div');
    value.className = 'text-2xl font-bold text-blue-600';
    value.textContent = '0';
    value.setAttribute('data-count-target', String(Number(r.angka || 0)));
    const time = document.createElement('div');
    time.className = 'text-xs text-gray-400 break-words';
    if (r.tanggal_update) time.textContent = formatDateTime(r.tanggal_update);
    card.appendChild(title);
    card.appendChild(value);
    card.appendChild(time);
    grid.appendChild(card);
    countObs.observe(value);
    setupReveal(card, { delay: Math.min(idx * 70, 320) });
  });
  renderRisetDistribution(list);
}

function renderRisetDistribution(list) {
  const visual = document.getElementById('riset-chart-visual');
  const legend = document.getElementById('riset-chart-legend');
  const totalEl = document.getElementById('riset-chart-total');
  const emptyEl = document.getElementById('riset-chart-empty');
  const card = document.getElementById('riset-chart-card');
  if (!visual || !legend || !totalEl || !emptyEl) return;

  const items = Array.isArray(list) ? list : [];
  const entries = items.map((item, idx) => {
    const rawValue = Number(
      item && item.angka !== undefined
        ? item.angka
        : item && item.nilai !== undefined
          ? item.nilai
          : item && item.value !== undefined
            ? item.value
            : 0,
    );
    const value = Number.isFinite(rawValue) ? Math.max(rawValue, 0) : 0;
    return {
      label: item && item.judul ? item.judul : `Indikator ${idx + 1}`,
      value,
    };
  });

  legend.innerHTML = '';
  if (card) setupReveal(card, { delay: Math.min(entries.length * 60, 260) });

  const total = entries.reduce((sum, entry) => sum + entry.value, 0);
  totalEl.textContent = formatNumber(total);
  emptyEl.classList.toggle('hidden', Boolean(total));

  visual.style.background = 'conic-gradient(#e2e8f0 0deg 360deg)';

  if (!total) {
    return;
  }

  let cursor = 0;
  const segments = [];
  entries.forEach((entry, idx) => {
    const color = RISET_CHART_COLORS[idx % RISET_CHART_COLORS.length];
    const li = document.createElement('li');
    li.className = 'flex items-center gap-3';
    const marker = document.createElement('span');
    marker.className = 'inline-flex h-3.5 w-3.5 rounded-full';
    marker.style.backgroundColor = color;
    if (entry.value === 0) marker.style.opacity = '0.35';
    const wrap = document.createElement('div');
    wrap.className = 'flex-1 leading-tight';
    const label = document.createElement('p');
    label.className = 'font-medium text-gray-700';
    label.textContent = entry.label;
    const detail = document.createElement('p');
    detail.className = 'text-xs text-gray-500';
    const percent = total ? (entry.value / total) * 100 : 0;
    detail.textContent = `${formatNumber(entry.value)} (${formatPercent(percent)})`;
    wrap.appendChild(label);
    wrap.appendChild(detail);
    li.appendChild(marker);
    li.appendChild(wrap);
    legend.appendChild(li);

    if (entry.value <= 0) {
      return;
    }
    const start = (cursor / total) * 360;
    cursor += entry.value;
    const end = (cursor / total) * 360;
    segments.push(`${color} ${start.toFixed(2)}deg ${end.toFixed(2)}deg`);
  });

  if (segments.length) {
    visual.style.background = `conic-gradient(${segments.join(', ')})`;
  }
}

// Galeri Program
function renderGaleri(list) {
  const grid = document.getElementById('galeri-grid');
  if (!grid) return;
  grid.innerHTML = '';
  (list || []).forEach((g, idx) => {
    const card = document.createElement('div');
    card.className = 'group bg-white rounded shadow overflow-hidden transition-shadow hover:shadow-lg reveal-on-scroll';
    if (g.gambar) {
      const img = document.createElement('img');
      img.src = buildImageUrl(g.gambar);
      img.alt = g.judul || 'program';
      img.className = 'w-full h-44 object-cover transition-transform duration-300 ease-out group-hover:scale-105';
      img.loading = 'lazy';
      img.decoding = 'async';
      card.appendChild(img);
    }
    const body = document.createElement('div');
    body.className = 'p-4';
    const title = document.createElement('div');
    title.className = 'font-semibold break-words';
    title.textContent = g.judul || '';
    const desc = document.createElement('div');
    desc.className = 'text-sm text-gray-600 break-words';
    desc.textContent = g.deskripsi || '';
    body.appendChild(title);
    body.appendChild(desc);
    card.appendChild(body);
    grid.appendChild(card);
    setupReveal(card, { delay: Math.min(idx * 60, 300) });
  });
}

function renderEdukasi(list) {
  const section = document.getElementById('edukasi');
  const grid = document.getElementById('edukasi-grid');
  const empty = document.getElementById('edukasi-empty');
  if (!grid || !section) return;
  grid.innerHTML = '';
  const items = Array.isArray(list) ? list : [];
  if (!items.length) {
    grid.classList.add('hidden');
    if (empty) empty.hidden = false;
    return;
  }
  grid.classList.remove('hidden');
  if (empty) empty.hidden = true;
  items.forEach((item, idx) => {
    const card = document.createElement('article');
    card.className = 'group bg-white border border-blue-100 rounded-2xl overflow-hidden shadow-sm transition-all hover:shadow-lg reveal-on-scroll';
    const figure = document.createElement('div');
    figure.className = 'relative aspect-[4/3] w-full overflow-hidden bg-blue-50';
    if (item.gambar) {
      const img = document.createElement('img');
      img.src = buildImageUrl(item.gambar);
      img.alt = item.judul || 'Materi edukasi';
      img.loading = 'lazy';
      img.decoding = 'async';
      img.className = 'h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105';
      figure.appendChild(img);
    } else {
      const placeholder = document.createElement('div');
      placeholder.className = 'absolute inset-0 flex items-center justify-center text-3xl font-semibold text-blue-500/70';
      const fallback = (item.judul || '').trim().charAt(0) || 'E';
      placeholder.textContent = fallback.toUpperCase();
      figure.appendChild(placeholder);
    }
    card.appendChild(figure);

    const body = document.createElement('div');
    body.className = 'p-6 space-y-4';
    const badge = document.createElement('span');
    badge.className = 'inline-flex flex-wrap items-center justify-center rounded-full bg-blue-50 px-3 py-1 text-center text-xs font-semibold uppercase tracking-wide text-blue-600 break-words';
    badge.textContent = item.kategori_label || EDUKASI_CATEGORY_LABELS[item.kategori] || 'Materi Edukasi';
    body.appendChild(badge);

    const title = document.createElement('h3');
    title.className = 'text-lg font-semibold text-gray-900 break-words';
    title.textContent = item.judul || 'Materi Edukasi';
    body.appendChild(title);

    if (item.deskripsi) {
      const desc = document.createElement('p');
      desc.className = 'text-sm leading-relaxed text-gray-600 break-words';
      desc.textContent = item.deskripsi;
      body.appendChild(desc);
    }

    if (item.created_at) {
      const formatted = formatDateTime(item.created_at);
      if (formatted) {
        const meta = document.createElement('p');
        meta.className = 'text-xs text-gray-400 break-words';
        meta.textContent = `Diterbitkan ${formatted}`;
        body.appendChild(meta);
      }
    }

    const actions = document.createElement('div');
    actions.className = 'flex flex-wrap gap-3';
    let hasAction = false;
    if (item.tautan) {
      const link = document.createElement('a');
      link.href = item.tautan;
      link.target = '_blank';
      link.rel = 'noopener';
      link.className = 'inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700';
      link.textContent = 'Lihat rincian';
      actions.appendChild(link);
      hasAction = true;
    }
    if (item.file) {
      const download = document.createElement('a');
      download.href = buildStorageUrl(item.file);
      download.target = '_blank';
      download.rel = 'noopener';
      download.className = 'inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700';
      download.textContent = 'Unduh materi';
      actions.appendChild(download);
      hasAction = true;
    }
    if (hasAction) {
      body.appendChild(actions);
    }

    card.appendChild(body);
    grid.appendChild(card);
    setupReveal(card, { delay: Math.min(idx * 70, 280) });
  });
}

// Utils
function buildImageUrl(p) {
  return buildStorageUrl(p);
}

function buildStorageUrl(p) {
  if (!p) return '';
  if (p.startsWith('http://') || p.startsWith('https://')) return p;
  if (p.startsWith('/')) return p;
  if (p.startsWith('storage/')) return `/${p}`;
  return `/storage/${p}`;
}

function formatNumber(value) {
  const num = Number(value);
  if (!Number.isFinite(num)) return '0';
  if (Number.isInteger(num)) return num.toLocaleString('id-ID');
  return num.toLocaleString('id-ID', { maximumFractionDigits: 2 });
}

function formatPercent(value) {
  if (!Number.isFinite(value)) return '0%';
  const normalized = Math.max(0, Math.min(100, value));
  const fixed = normalized.toFixed(1);
  const trimmed = fixed.endsWith('.0') ? fixed.slice(0, -2) : fixed;
  return `${trimmed}%`;
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


// Deferred map loader that waits for intent or viewport visibility
function bindLazyMap() {
  const container = document.getElementById('contact-map');
  if (!container) return;
  const src = container.getAttribute('data-map-src');
  if (!src) return;

  const title = container.getAttribute('data-map-title') || 'Lokasi kantor';
  const referrer = container.getAttribute('data-map-referrerpolicy') || '';
  const placeholder = container.querySelector('[data-map-placeholder]');
  const message = placeholder ? placeholder.querySelector('[data-map-message]') : null;
  const trigger = container.querySelector('[data-map-trigger]');
  const rawConnection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  const prefersReducedData = typeof window !== 'undefined' && window.matchMedia ? window.matchMedia('(prefers-reduced-data: reduce)').matches : false;
  const saveData = Boolean(rawConnection && rawConnection.saveData);
  const allowAutoLoad = !(saveData || prefersReducedData);

  if (message && !allowAutoLoad) {
    message.textContent = 'Mode hemat data aktif. Tekan tombol untuk memuat peta.';
  }

  let loaded = container.getAttribute('data-map-loaded') === 'true' || Boolean(container.querySelector('iframe'));
  let observer;

  const mount = () => {
    if (loaded) return;
    loaded = true;
    const iframe = document.createElement('iframe');
    iframe.src = src;
    iframe.title = title;
    iframe.loading = 'lazy';
    iframe.className = 'w-full h-full border-0';
    if (referrer) iframe.referrerPolicy = referrer;
    iframe.allowFullscreen = true;
    container.appendChild(iframe);
    if (placeholder && placeholder.parentNode) placeholder.remove();
    container.setAttribute('data-map-loaded', 'true');
    if (observer) observer.disconnect();
  };

  if (trigger) {
    trigger.addEventListener('click', (event) => {
      event.preventDefault();
      mount();
    });
  }

  if (allowAutoLoad && 'IntersectionObserver' in window) {
    observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          mount();
        }
      });
    }, { rootMargin: '200px' });
    observer.observe(container);
  } else if (!allowAutoLoad) {
    container.setAttribute('data-map-autoload', 'disabled');
  } else {
    window.addEventListener('load', () => { setTimeout(mount, 800); });
  }
}
// Init
function init() {
  const hadCache = hydrateLandingFromCache();
  fetchLandingData();
  bindMobileMenu();
  bindHeroSwipe();
  bindLazyMap();
  if (!hadCache) observeStaticReveals();
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

        // Existing JavaScript will be loaded from resources/js/landing.js
        // This script enhances the visual elements
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize count-up animations for hero stats
            const heroStats = document.querySelectorAll('#hero [data-count-target]');
            const heroStatsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(entry.target.getAttribute('data-count-target'));
                        animateCounter(entry.target, target, 2000);
                        heroStatsObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            heroStats.forEach(stat => heroStatsObserver.observe(stat));
            
            // Enhanced fade-up animations
            const fadeElements = document.querySelectorAll('.fade-up');
            fadeElements.forEach((el, index) => {
                el.style.transitionDelay = `${index * 100}ms`;
            });
            
            // Smooth scrolling enhancement
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const headerOffset = 80;
                        const elementPosition = target.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Loading shimmer removal after content loads
            setTimeout(() => {
                document.querySelectorAll('.loading-shimmer').forEach(el => {
                    el.classList.remove('loading-shimmer');
                    el.style.background = '#f8fafc';
                });
            }, 1000);
            
            // Header background change on scroll
            const header = document.querySelector('header');
            let lastScrollY = window.scrollY;
            
            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;
                
                if (currentScrollY > 100) {
                    header.classList.add('backdrop-blur-md', 'bg-blue-700/90');
                } else {
                    header.classList.remove('backdrop-blur-md', 'bg-blue-700/90');
                }
                
                lastScrollY = currentScrollY;
            });
        });
        
        // Counter animation function
        function animateCounter(element, target, duration) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target.toLocaleString('id-ID');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start).toLocaleString('id-ID');
                }
            }, 16);
        }
        
        // Enhanced service card styling
        function enhanceServiceCards() {
            const serviceCards = document.querySelectorAll('#services-grid > div');
            serviceCards.forEach((card, index) => {
                card.classList.add('group');
                
                // Add enhanced styling
                card.classList.remove('border', 'border-gray-200', 'bg-white', 'rounded', 'p-4', 'flex', 'gap-3', 'hover:shadow-lg', 'transition-shadow');
                card.className += ' bg-gradient-to-br from-white to-blue-50 border border-blue-100 rounded-2xl p-6 flex items-start gap-4 soft-lift reveal-on-scroll';
                
                // Enhance icon container
                const iconContainer = card.querySelector('img, div');
                if (iconContainer) {
                    if (iconContainer.tagName === 'IMG') {
                        iconContainer.className = 'w-16 h-16 object-contain p-3 bg-blue-100 rounded-2xl group-hover:bg-blue-200 transition-colors';
                    } else {
                        iconContainer.className = 'service-icon flex-shrink-0 text-2xl group-hover:scale-110 transition-transform';
                    }
                }
                
                // Enhance text content
                const textContainer = card.querySelector('div:last-child');
                if (textContainer) {
                    const title = textContainer.querySelector('h3');
                    const description = textContainer.querySelector('p');
                    
                    if (title) {
                        title.className = 'text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors';
                    }
                    
                    if (description) {
                        description.className = 'text-gray-600 leading-relaxed group-hover:text-gray-700 transition-colors';
                    }
                }
                
                // Add hover effect
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        }
        
        // Enhanced gallery cards
        function enhanceGalleryCards() {
            const galleryCards = document.querySelectorAll('#galeri-grid > div');
            galleryCards.forEach((card) => {
                card.className = 'group bg-white rounded-2xl shadow-lg overflow-hidden soft-lift reveal-on-scroll border border-gray-100';
                
                const image = card.querySelector('img');
                if (image) {
                    image.className = 'w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500';
                }
                
                const content = card.querySelector('div:last-child');
                if (content) {
                    content.className = 'p-6';
                    
                    const title = content.querySelector('div:first-child');
                    if (title) {
                        title.className = 'font-bold text-lg text-gray-900 mb-2 group-hover:text-blue-700 transition-colors';
                    }
                    
                    const description = content.querySelector('div:last-child');
                    if (description) {
                        description.className = 'text-gray-600 leading-relaxed group-hover:text-gray-700 transition-colors';
                    }
                }
            });
        }
        
        // Call enhancement functions when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for dynamic content to load
            setTimeout(() => {
                enhanceServiceCards();
                enhanceGalleryCards();
            }, 1500);
        });
        
        // Enhanced riset card styling
        function enhanceRisetCards() {
            const risetCards = document.querySelectorAll('#riset-grid > div:not(.loading-shimmer)');
            risetCards.forEach((card, index) => {
                if (!card.classList.contains('riset-card')) {
                    card.className = 'riset-card soft-lift reveal-on-scroll group cursor-pointer';
                    
                    // Add icon based on content
                    const iconDiv = document.createElement('div');
                    iconDiv.className = 'absolute top-4 right-4 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center opacity-60 group-hover:opacity-100 transition-opacity';
                    iconDiv.innerHTML = '<i class="fas fa-chart-line text-blue-600"></i>';
                    card.appendChild(iconDiv);
                    
                    // Enhance number display
                    const numberEl = card.querySelector('div:nth-child(2)');
                    if (numberEl) {
                        numberEl.className = 'text-3xl font-bold text-blue-600 group-hover:text-blue-700 transition-colors mb-2';
                    }
                    
                    // Enhance title
                    const titleEl = card.querySelector('div:first-child');
                    if (titleEl) {
                        titleEl.className = 'text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors mb-1';
                    }
                    
                    // Enhance time
                    const timeEl = card.querySelector('div:last-child');
                    if (timeEl) {
                        timeEl.className = 'text-xs text-gray-500 flex items-center gap-1';
                        timeEl.innerHTML = '<i class="fas fa-clock"></i>' + timeEl.textContent;
                    }
                }
            });
        }
        
        // Observer for riset cards
        const risetObserver = new MutationObserver(() => {
            enhanceRisetCards();
        });
        
        const risetGrid = document.getElementById('riset-grid');
        if (risetGrid) {
            risetObserver.observe(risetGrid, { childList: true, subtree: true });
        }