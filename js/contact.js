/* ══ Form submit ════════════════════════════════════════ */
function hs(e){
  e.preventDefault();
  var btn = document.getElementById('sbtn');
  var form = document.getElementById('cform');
  btn.disabled = true;
  btn.querySelector('span').textContent = '送信中...';

  var fd = new FormData(form);

  fetch('mail.php', {
    method: 'POST',
    body: fd
  })
  .then(function(res){ return res.json(); })
  .then(function(data){
    if(data.status === 'ok'){
      document.getElementById('form-area').style.display = 'none';
      document.getElementById('form-done').style.display = 'block';
    } else {
      alert(data.message || '送信に失敗しました。');
      btn.disabled = false;
      btn.querySelector('span').textContent = '送信する';
    }
  })
  .catch(function(){
    alert('送信に失敗しました。時間をおいて再度お試しください。');
    btn.disabled = false;
    btn.querySelector('span').textContent = '送信する';
  });
}
