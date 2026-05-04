/* ══ Active nav (top page) ══════════════════════════════ */
const secs = document.querySelectorAll('section[id]');
const navAs = document.querySelectorAll('.nav a');
const secObs = new IntersectionObserver(es => {
  es.forEach(e => {
    if (e.isIntersecting) {
      navAs.forEach(a => {
        a.style.color = '';
        if (a.getAttribute('href') === 'index.html#' + e.target.id ||
            a.getAttribute('href') === '#' + e.target.id) {
          a.style.color = 'var(--green)';
        }
      });
    }
  });
}, { threshold: .35 });
secs.forEach(s => secObs.observe(s));
