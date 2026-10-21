/* ===== Beállítások ===== */
const CONFIG = {
  excelFile: 'posts.xlsx',   // az Excel-fájl neve a HTML mellett
  imageFolder: 'images/',    // a D oszlopban szereplő fájlnevek ebben a mappában vannak
  perPage: 4,                // ennyi poszt jelenik meg elsőre és "View More"-onként
  locale: 'en-GB'            // dátumformátum; magyarhoz: 'hu-HU'
};

/* ===== Téma váltó ===== */
(function () {
  const btn = document.querySelector('.theme-toggle');
  if (!btn) return;
  btn.addEventListener('click', () => {
    const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
    document.documentElement.dataset.theme = next;
    try { localStorage.setItem('theme', next); } catch (e) {}
  });
})();
document.querySelectorAll('.year').forEach(el => el.textContent = new Date().getFullYear());

/* ===== Segédfüggvények ===== */
const esc = s => String(s ?? '').replace(/[&<>"']/g, c =>
  ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

function parseDate(v) {
  if (v instanceof Date) return v;
  if (typeof v === 'number') {                       // Excel sorszám-dátum
    const d = XLSX.SSF.parse_date_code(v);
    return new Date(d.y, d.m - 1, d.d);
  }
  if (typeof v === 'string' && v.trim()) {           // pl. 2024.02.02 vagy 2024-02-02
    const m = v.trim().match(/^(\d{4})[.\-/ ]+(\d{1,2})[.\-/ ]+(\d{1,2})/);
    if (m) return new Date(+m[1], +m[2] - 1, +m[3]);
    const d = new Date(v);
    if (!isNaN(d)) return d;
  }
  return null;
}

function formatDate(d) {
  if (!d) return '';
  if (CONFIG.locale.startsWith('en')) {
    const mon = d.toLocaleDateString('en-GB', { month: 'short' });
    return `${d.getDate()} ${mon}, ${d.getFullYear()}`;   // 2 Feb, 2024
  }
  return d.toLocaleDateString(CONFIG.locale, { year: 'numeric', month: 'short', day: 'numeric' });
}

function imgSrc(v) {
  v = String(v ?? '').trim();
  if (!v) return '';
  return /^(https?:)?\/\//.test(v) || v.includes('/') ? v : CONFIG.imageFolder + v;
}

/* ===== Excel beolvasása =====
   A: dátum, B: cím, C: szöveg, D: kép (opcionális), E: címke (opcionális).
   Az első sor fejléc, ha az A cellája nem dátum. */
async function loadPosts() {
  const res = await fetch(CONFIG.excelFile, { cache: 'no-cache' });
  if (!res.ok) throw new Error(`Nem található: ${CONFIG.excelFile}`);
  const wb = XLSX.read(await res.arrayBuffer(), { cellDates: true });
  const rows = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]], { header: 1, raw: true, defval: '' });

  const posts = [];
  rows.forEach((r, i) => {
    const title = String(r[1] ?? '').trim();
    const date = parseDate(r[0]);
    if (!title || (i === 0 && !date)) return;          // üres sor vagy fejléc
    posts.push({
      id: i + 1,                                         // = Excel sorszáma, ezért stabil link
      date,
      title,
      text: String(r[2] ?? ''),
      image: imgSrc(r[3]),
      tag: String(r[4] ?? '').trim().replace(/^#/, '')
    });
  });
  posts.sort((a, b) => (b.date || 0) - (a.date || 0));
  return posts;
}

function metaHTML(p) {
  const tag = p.tag
    ? `<span class="dot"></span><a href="index.html?tag=${encodeURIComponent(p.tag)}#posts">#${esc(p.tag)}</a>`
    : '';
  return `<div class="meta"><time>${esc(formatDate(p.date))}</time>${tag}</div>`;
}

/* ===== Kezdőoldal: lista ===== */
async function renderList() {
  const list = document.getElementById('post-list');
  const more = document.getElementById('more');
  const params = new URLSearchParams(location.search);
  const tag = params.get('tag');

  let posts;
  try { posts = await loadPosts(); }
  catch (e) { list.innerHTML = `<li class="status">A posztok nem tölthetők be. (${esc(e.message)})</li>`; return; }

  if (tag) {
    posts = posts.filter(p => p.tag.toLowerCase() === tag.toLowerCase());
    document.getElementById('filter-note').innerHTML =
      `Címke: #${esc(tag)} · <a href="index.html#posts">összes poszt</a>`;
  }
  if (!posts.length) { list.innerHTML = '<li class="status">Még nincs poszt.</li>'; return; }

  let shown = 0;
  const showMore = () => {
    const next = posts.slice(shown, shown + CONFIG.perPage);
    list.insertAdjacentHTML('beforeend', next.map(p => `
      <li class="post-item">
        <div class="post-item-body">
          ${metaHTML(p)}
          <h3><a href="post.html?id=${p.id}">${esc(p.title)}</a></h3>
        </div>
        ${p.image ? `<a class="thumb" href="post.html?id=${p.id}" tabindex="-1"><img src="${esc(p.image)}" alt="" loading="lazy"></a>` : ''}
      </li>`).join(''));
    shown += next.length;
    more.hidden = shown >= posts.length;
  };
  more.addEventListener('click', showMore);
  showMore();
}

/* ===== Poszt-oldal ===== */
async function renderPost() {
  const box = document.getElementById('post');
  const id = +new URLSearchParams(location.search).get('id');
  let posts;
  try { posts = await loadPosts(); }
  catch (e) { box.innerHTML = `<p class="status">A poszt nem tölthető be. (${esc(e.message)})</p>`; return; }

  const p = posts.find(x => x.id === id);
  if (!p) { box.innerHTML = '<p class="status">Ez a poszt nem található.</p>'; return; }

  document.title = `${p.title} · Starter`;
  const paras = p.text.split(/\r?\n\s*\r?\n|\r?\n/).filter(s => s.trim());
  box.innerHTML = `
    ${metaHTML(p)}
    <h1>${esc(p.title)}</h1>
    ${p.image ? `<figure class="post-cover"><img src="${esc(p.image)}" alt=""></figure>` : ''}
    <div class="post-content">${paras.map(s => `<p>${esc(s)}</p>`).join('')}</div>
    <a class="back" href="index.html#posts">← Vissza a posztokhoz</a>`;
}

if (document.getElementById('post-list')) renderList();
if (document.getElementById('post')) renderPost();
