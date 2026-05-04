/* ══ Form submit ════════════════════════════════════════ */
function hs(e){
  e.preventDefault();
  const btn = document.getElementById('sbtn');
  btn.disabled = true;
  btn.querySelector('span').textContent = '送信中...';
  setTimeout(() => {
    document.getElementById('form-area').style.display = 'none';
    document.getElementById('form-done').style.display = 'block';
  }, 800);
}
