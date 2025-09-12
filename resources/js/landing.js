// State
let heroItems = [];
let heroIndex = 0;
let heroTimer = null;

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
    renderServices(data.services || []);
    renderPublications(data.publications || []);
    renderEntityStats(data.entity_counts || []);
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
  const slide = document.getElementById('hero-slide');
  const btn1 = document.getElementById('hero-btn-1');
  const btn2 = document.getElementById('hero-btn-2');
  if (sub) sub.textContent = item.sub_heading || 'Program Prioritas Nasional';
  if (head) head.textContent = item.heading || '';
  if (desc) desc.textContent = item.deskripsi || '';
  if (slide && item.gambar) {
    const buildImageUrl = (p) => {
      if (!p) return '';
      if (p.startsWith('http://') || p.startsWith('https://')) return p;
      if (p.startsWith('/')) return p;
      // Default to storage mapping
      return `/storage/${p}`;
    };
    slide.style.backgroundImage = `url(${buildImageUrl(item.gambar)})`;
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

function renderServices(list) {
  const grid = document.getElementById('services-grid');
  grid.innerHTML = '';
  list.forEach(s => {
    const card = document.createElement('div');
    card.className = 'border border-gray-200 bg-white rounded p-4 flex gap-3 hover:shadow-lg transition-shadow';
    const icon = document.createElement('img');
    icon.src = s.ikon ? `/storage/${s.ikon}` : '';
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
  });
}

function renderPublications(list) {
  const grid = document.getElementById('pub-grid');
  grid.innerHTML = '';
  list.forEach(p => {
    const card = document.createElement('div');
    card.className = 'bg-white rounded shadow overflow-hidden flex flex-col';
    if (p.gambar) {
      const img = document.createElement('img');
      img.src = `/storage/${p.gambar}`;
      img.alt = p.judul || 'publikasi';
      img.className = 'w-full h-40 object-cover';
      card.appendChild(img);
    }
    const body = document.createElement('div');
    body.className = 'p-4 flex flex-col gap-2 flex-1';
    const title = document.createElement('h3');
    title.className = 'font-semibold';
    title.textContent = p.judul;
    const cat = document.createElement('span');
    cat.className = 'text-xs text-gray-500';
    cat.textContent = p.kategori || '';
    const desc = document.createElement('p');
    desc.className = 'text-sm text-gray-600';
    desc.textContent = p.deskripsi || '';
    body.appendChild(title); body.appendChild(cat); body.appendChild(desc);
    const footer = document.createElement('div');
    footer.className = 'p-4 pt-0 mt-auto';
    if (p.link_aksi && p.teks_tombol) {
      const a = document.createElement('a');
      a.href = p.link_aksi; a.textContent = p.teks_tombol;
      a.className = 'inline-block bg-blue-600 text-white px-3 py-2 rounded text-sm';
      footer.appendChild(a);
    }
    card.appendChild(body); card.appendChild(footer);
    grid.appendChild(card);
  });
}

function renderEntityStats(entityCounts) {
  const grid = document.getElementById('stats-grid');
  grid.innerHTML = '';
  const appendCard = (titleText, valueText, timeText) => {
    const card = document.createElement('div');
    card.className = 'border border-gray-200 bg-white rounded p-6 hover:shadow-lg transition-shadow';
    const title = document.createElement('div');
    title.className = 'text-sm text-gray-500';
    title.textContent = titleText;
    const value = document.createElement('div');
    value.className = 'text-2xl font-bold text-blue-600';
    value.textContent = valueText;
    const time = document.createElement('div');
    time.className = 'text-xs text-gray-400';
    time.textContent = timeText || '';
    card.appendChild(title); card.appendChild(value); card.appendChild(time);
    grid.appendChild(card);
  };

  (entityCounts || []).forEach(e => {
    appendCard(e.judul, e.angka, '');
  });
}


// Init
fetchLandingData();
setInterval(fetchLandingData, 10000);

document.addEventListener('click', (e) => {
  const t = e.target;
  if (!(t instanceof Element)) return;
  if (t.id === 'hero-prev') { e.preventDefault(); prevHero(); startHeroRotation(); }
  if (t.id === 'hero-next') { e.preventDefault(); nextHero(); startHeroRotation(); }
});

