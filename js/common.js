/* ══ Header scroll ══════════════════════════════════════ */
const hd = document.getElementById('hd');
const isSubPage = document.body.classList.contains('page-sub');

if (isSubPage) {
  // 下層ページは最初から白ヘッダー
  hd.classList.add('on');
} else {
  // トップページはスクロール量で切替
  window.addEventListener('scroll', () => {
    hd.classList.toggle('on', scrollY > 60);
  }, { passive: true });
}

/* ══ Hamburger ══════════════════════════════════════════ */
const hbg = document.getElementById('hbg');
const mnav = document.getElementById('mnav');
hbg.addEventListener('click', () => {
  const o = hbg.classList.toggle('op');
  mnav.style.display = o ? 'block' : 'none';
});
function cm(){ hbg.classList.remove('op'); mnav.style.display = 'none'; }

/* ══ FadeIn ═════════════════════════════════════════════ */
const obs = new IntersectionObserver(es => {
  es.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('vis');
      obs.unobserve(e.target);
    }
  });
}, { threshold: .1 });
document.querySelectorAll('.fi').forEach(el => obs.observe(el));
