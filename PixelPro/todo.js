document.addEventListener('DOMContentLoaded', () => {
  const menu = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.primary-nav');
  menu?.addEventListener('click', () => {const open=nav.classList.toggle('open');menu.setAttribute('aria-expanded',String(open));});
  const more=document.querySelector('.nav-more');
  more?.addEventListener('click', () => {const open=more.closest('.nav-dropdown').classList.toggle('open');more.setAttribute('aria-expanded',String(open));});
  document.addEventListener('click',event=>{if(!event.target.closest('.nav-dropdown')){document.querySelector('.nav-dropdown')?.classList.remove('open');more?.setAttribute('aria-expanded','false');}});
  const clock=document.getElementById('reloj');
  if(clock){function tick(){clock.textContent=new Intl.DateTimeFormat('es-AR',{timeZone:'America/Argentina/Buenos_Aires',day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:false}).format(new Date());}tick();setInterval(tick,1000);}
  const io='IntersectionObserver' in window?new IntersectionObserver((entries)=>{entries.forEach(ent=>{if(ent.isIntersecting){ent.target.classList.add('in-view');io.unobserve(ent.target);}})},{threshold:0.08}):null;
  document.querySelectorAll('.reveal').forEach(el=>{if(io)io.observe(el);else el.classList.add('in-view');});
  const dialog=document.getElementById('imageDialog');
  document.querySelectorAll('.gallery-item').forEach(btn=>btn.addEventListener('click',()=>{const im=btn.querySelector('img');if(!dialog||!im)return;dialog.querySelector('img').src=im.src;dialog.showModal();}));
  dialog?.querySelector('.dialog-close')?.addEventListener('click',()=>dialog.close());
  dialog?.addEventListener('click',(ev)=>{if(ev.target===dialog)dialog.close();});
});
