document.addEventListener('DOMContentLoaded', () => {
  const menu = document.getElementById('mobileMenu');
  const sidebar = document.getElementById('sidebar');
  if (menu && sidebar) menu.addEventListener('click', () => sidebar.classList.toggle('open'));
  document.querySelectorAll('form[data-confirm]').forEach(form => form.addEventListener('submit', e => {
    if (!window.confirm(form.dataset.confirm)) e.preventDefault();
  }));
  const otp = document.querySelector('.otp-input');
  if (otp) otp.addEventListener('input', () => { otp.value = otp.value.replace(/\D/g, '').slice(0, 6); });
});
