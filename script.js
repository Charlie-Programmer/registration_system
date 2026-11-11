
document.addEventListener('click', e => {
  const btn = e.target.closest('.eye');
  if (!btn) return;
  e.preventDefault();
  const input = btn.parentElement.querySelector('input');
  const show = input.type === 'password';
  input.type = show ? 'text' : 'password';
  btn.setAttribute('aria-pressed', String(show));
  btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
});

