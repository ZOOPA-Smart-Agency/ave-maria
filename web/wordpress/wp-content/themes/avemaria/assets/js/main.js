if(location.hash==='#laboral'){location.replace('#families');}

// ---------- Page navigation (SPA) ----------
function scrollToTopHard(){
  // Força scroll al principi de manera fiable (3 estratègies)
  document.documentElement.scrollTop=0;
  document.body.scrollTop=0;
  window.scrollTo(0,0);
}
function showPage(pageId){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  const t=document.getElementById(pageId);
  if(t){
    t.classList.add('active');
    // Canvia el hash sense provocar el scroll automàtic del navegador
    if(history.replaceState){history.replaceState(null,'','#'+pageId);}else{window.location.hash=pageId;}
    // Scroll al principi diverses vegades per cobrir scripts que mouen el scroll (GSAP/ScrollTrigger, etc.)
    scrollToTopHard();
    requestAnimationFrame(scrollToTopHard);
    [10,50,120,260,500,800].forEach(d=>setTimeout(scrollToTopHard,d));
  }
  document.body.classList.remove('menu-open');
  // tanca el submenú obert (per donar feedback visual al clic)
  document.body.classList.add('nav-clicked');
  setTimeout(()=>document.body.classList.remove('nav-clicked'),550);
  // highlight current nav
  document.querySelectorAll('nav.main a.navlink').forEach(a=>a.classList.remove('current'));
  setTimeout(initReveal,40);
}
window.addEventListener('load',()=>{const h=location.hash.slice(1);if(h&&document.getElementById(h))showPage(h);initReveal();scrollToTopHard();});
window.addEventListener('hashchange',()=>{const h=location.hash.slice(1);if(h&&document.getElementById(h)){showPage(h);scrollToTopHard();}});

// ---------- Language ----------
function setLang(lang){
  document.body.classList.toggle('lang-es',lang==='es');
  document.querySelectorAll('.lang button').forEach(b=>b.classList.toggle('active',b.textContent===lang.toUpperCase()));
  localStorage.setItem('lang',lang);
}
window.addEventListener('load',()=>{const s=localStorage.getItem('lang');if(s)setLang(s);});

// ---------- Header: fons quan s'obre el submenú ----------
document.querySelectorAll('.nav-item.has-sub').forEach(item=>{
  item.addEventListener('mouseenter',()=>document.getElementById('header').classList.add('sub-open'));
  item.addEventListener('mouseleave',()=>document.getElementById('header').classList.remove('sub-open'));
});
document.querySelectorAll('.subnav').forEach(sn=>{
  sn.addEventListener('mouseenter',()=>document.getElementById('header').classList.add('sub-open'));
  sn.addEventListener('mouseleave',()=>document.getElementById('header').classList.remove('sub-open'));
});

// ---------- Header scroll + progress ----------
const header=document.getElementById('header'),progress=document.getElementById('progress');
function onScroll(){
  const y=window.scrollY;
  header.classList.toggle('scrolled',y>40);
  const h=document.documentElement.scrollHeight-window.innerHeight;
  progress.style.width=(h>0?(y/h*100):0)+'%';
}
window.addEventListener('scroll',onScroll,{passive:true});onScroll();

// ---------- Mobile menu ----------
document.getElementById('burger').addEventListener('click',()=>document.body.classList.toggle('menu-open'));

// ---------- Reveal on scroll ----------
let io;
function initReveal(){
  if(!io){io=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');if(e.target.hasAttribute('data-count'))runCount(e.target);io.unobserve(e.target);}})},{threshold:.15});}
  document.querySelectorAll('.page.active [data-reveal]:not(.in)').forEach(el=>io.observe(el));
  document.querySelectorAll('.page.active [data-count]').forEach(el=>{if(!el.dataset.done)io.observe(el);});
}

// ---------- Counter ----------
function runCount(el){
  if(el.dataset.done)return;el.dataset.done=1;
  const target=+el.dataset.target,prefix=el.dataset.prefix||'',sep=el.dataset.sep||'';
  const dur=1400,start=performance.now();
  function fmt(n){let s=Math.floor(n).toString();if(sep)s=s.replace(/\B(?=(\d{3})+(?!\d))/g,sep);return prefix+s;}
  function tick(now){const p=Math.min((now-start)/dur,1);const eased=1-Math.pow(1-p,3);el.textContent=fmt(target*eased);if(p<1)requestAnimationFrame(tick);else el.textContent=fmt(target);}
  requestAnimationFrame(tick);
}

// ---------- Testimonis ----------
// ---------- Carrusel de testimonis (loop infinit amb clones) ----------
(function(){
  const track=document.getElementById('testimonisTrack');
  const dotsBox=document.getElementById('testimonisDots');
  const carousel=document.querySelector('.testimoni-carousel');
  if(!track||!carousel)return;

  const originals=Array.from(track.children);
  const N=originals.length;
  if(!N)return;

  // Clones per a l'efecte infinit: 1 al principi (clon del últim) + N + 1 al final (clon del primer)
  const firstClone=originals[N-1].cloneNode(true);firstClone.classList.add('is-clone');
  const lastClone=originals[0].cloneNode(true);lastClone.classList.add('is-clone');
  track.insertBefore(firstClone,track.firstChild);
  track.appendChild(lastClone);

  let idx=0; // índex real (0..N-1), apunta a originals
  let isAnimating=false;
  let autoplayId=null;

  // Construir dots
  for(let i=0;i<N;i++){
    const b=document.createElement('button');
    b.addEventListener('click',()=>goTo(i,true));
    dotsBox.appendChild(b);
  }
  const dots=()=>Array.from(dotsBox.children);

  function cardStep(){
    const cards=track.querySelectorAll('.tc-card');
    if(cards.length<2)return 0;
    const r0=cards[0].getBoundingClientRect();
    const r1=cards[1].getBoundingClientRect();
    return r1.left-r0.left; // ample tarjeta + gap
  }

  function applyTransform(realIdx,animate){
    const step=cardStep();
    if(!step){requestAnimationFrame(()=>applyTransform(realIdx,animate));return;}
    track.style.transition=animate?'transform .65s cubic-bezier(.25,.46,.45,.94)':'none';
    const offset=-((realIdx+1)*step); // +1 perquè el primer fill és un clon
    track.style.transform=`translateX(${offset}px)`;
  }

  function updateActive(){
    const all=track.querySelectorAll('.tc-card');
    all.forEach(c=>c.classList.remove('is-active'));
    // L'actiu visualment és l'element idx+1 (perquè hi ha el clon al principi)
    if(all[idx+1])all[idx+1].classList.add('is-active');
    dots().forEach((d,i)=>d.classList.toggle('is-active',i===idx));
  }

  function goTo(newIdx,userAction){
    if(isAnimating)return;
    idx=newIdx;
    isAnimating=true;
    applyTransform(idx,true);
    updateActive();
    setTimeout(()=>{isAnimating=false;},700);
    if(userAction)resetAutoplay();
  }

  function next(){
    if(isAnimating)return;
    isAnimating=true;
    const newReal=idx+1;
    // Si vol superar el final, primer animo cap al clon després salto silenciós
    if(newReal>=N){
      const step=cardStep();
      track.style.transition='transform .65s cubic-bezier(.25,.46,.45,.94)';
      track.style.transform=`translateX(${-((N+1)*step)}px)`;
      const all=track.querySelectorAll('.tc-card');
      all.forEach(c=>c.classList.remove('is-active'));
      if(all[N+1])all[N+1].classList.add('is-active'); // el clon del primer
      dots().forEach((d,i)=>d.classList.toggle('is-active',i===0));
      setTimeout(()=>{
        idx=0;
        applyTransform(0,false);
        updateActive();
        isAnimating=false;
      },680);
    }else{
      idx=newReal;
      applyTransform(idx,true);
      updateActive();
      setTimeout(()=>{isAnimating=false;},700);
    }
  }

  function prev(){
    if(isAnimating)return;
    isAnimating=true;
    const newReal=idx-1;
    if(newReal<0){
      const step=cardStep();
      track.style.transition='transform .65s cubic-bezier(.25,.46,.45,.94)';
      track.style.transform=`translateX(0px)`; // pos 0 = clon del darrer
      const all=track.querySelectorAll('.tc-card');
      all.forEach(c=>c.classList.remove('is-active'));
      if(all[0])all[0].classList.add('is-active');
      dots().forEach((d,i)=>d.classList.toggle('is-active',i===N-1));
      setTimeout(()=>{
        idx=N-1;
        applyTransform(N-1,false);
        updateActive();
        isAnimating=false;
      },680);
    }else{
      idx=newReal;
      applyTransform(idx,true);
      updateActive();
      setTimeout(()=>{isAnimating=false;},700);
    }
  }

  // Fletxes
  const prevBtn=carousel.querySelector('.tc-prev');
  const nextBtn=carousel.querySelector('.tc-next');
  if(prevBtn)prevBtn.addEventListener('click',()=>{prev();resetAutoplay();});
  if(nextBtn)nextBtn.addEventListener('click',()=>{next();resetAutoplay();});

  // Autoplay
  function startAutoplay(){if(autoplayId)return;autoplayId=setInterval(()=>{if(!document.hidden)next();},6500);}
  function stopAutoplay(){if(autoplayId){clearInterval(autoplayId);autoplayId=null;}}
  function resetAutoplay(){stopAutoplay();startAutoplay();}
  carousel.addEventListener('mouseenter',stopAutoplay);
  carousel.addEventListener('mouseleave',startAutoplay);

  // Click a tarjeta no-activa va a aquesta
  track.addEventListener('click',e=>{
    const c=e.target.closest('.tc-card');
    if(!c||c.classList.contains('is-active')||c.classList.contains('is-clone'))return;
    const all=Array.from(track.querySelectorAll('.tc-card:not(.is-clone)'));
    const realIdx=all.indexOf(c);
    if(realIdx>=0)goTo(realIdx,true);
  });

  // Init
  function init(){
    applyTransform(0,false);
    updateActive();
    startAutoplay();
  }
  // Espera al càrrega de fonts/imatges
  requestAnimationFrame(()=>requestAnimationFrame(init));
  window.addEventListener('resize',()=>applyTransform(idx,false));
})();

// ---------- FAQ accordion ----------
document.addEventListener('click',e=>{const q=e.target.closest('.faq-question');if(q)q.parentElement.classList.toggle('open');});

// ---------- Donation selectors ----------
document.addEventListener('click',e=>{
  const a=e.target.closest('.amount-option');if(a){a.parentElement.querySelectorAll('.amount-option').forEach(o=>o.classList.remove('active'));a.classList.add('active');}
  const t=e.target.closest('.type-option');if(t){t.parentElement.querySelectorAll('.type-option').forEach(o=>o.classList.remove('active'));t.classList.add('active');}
});

// ---------- Custom cursor ----------
const cursor=document.getElementById('cursor');
if(window.matchMedia('(hover:hover)').matches){
  let cx=0,cy=0,tx=0,ty=0;
  window.addEventListener('mousemove',e=>{tx=e.clientX;ty=e.clientY;});
  (function loop(){cx+=(tx-cx)*.18;cy+=(ty-cy)*.18;cursor.style.left=cx+'px';cursor.style.top=cy+'px';requestAnimationFrame(loop);})();
  document.addEventListener('mouseover',e=>{if(e.target.closest('a,button,.servei-card,.amount-option,.faq-question'))cursor.classList.add('big');});
  document.addEventListener('mouseout',e=>{if(e.target.closest('a,button,.servei-card,.amount-option,.faq-question'))cursor.classList.remove('big');});
}

// ---------- Parallax (hero image + text fade) ----------
const heroImg=document.querySelector('.hero-img');
const heroLeft=document.querySelector('.hero-left');
function parallax(){
  if(!heroImg||!document.getElementById('home').classList.contains('active'))return;
  const y=window.scrollY,vh=window.innerHeight;
  if(y>vh*1.2)return;                      // només mentre el hero és visible
  const p=Math.min(y/vh,1);                // 0 → 1 (progrés dins del hero)
  const ty=p*vh*0.22;                       // fins ~200px de desplaçament màxim
  const sc=1+p*0.08;                        // escala fins 1.08 (sense excessos)
  heroImg.style.transform='translate3d(0,'+ty+'px,0) scale('+sc+')';
  if(heroLeft){
    heroLeft.style.transform='translate3d(0,'+(p*vh*-0.12)+'px,0)';
    heroLeft.style.opacity=Math.max(0,1-p*1.1);
  }
}
window.addEventListener('scroll',parallax,{passive:true});

// ---------- Magnetic buttons ----------
if(window.matchMedia('(hover:hover)').matches){
  document.querySelectorAll('.btn, .btn-dona, .brand-logo').forEach(el=>{
    const strength=el.classList.contains('brand-logo')?0.2:0.4;
    el.addEventListener('mousemove',e=>{const r=el.getBoundingClientRect();const mx=e.clientX-(r.left+r.width/2);const my=e.clientY-(r.top+r.height/2);el.style.transform='translate('+(mx*strength)+'px,'+(my*strength-2)+'px)';});
    el.addEventListener('mouseleave',()=>{el.style.transform='';});
  });
}

// ---------- Valors: bandes de color expandibles ----------
(function(){
  const group=document.getElementById('valsBands');
  if(!group)return;
  const bands=[...group.querySelectorAll('.vb')];
  bands.forEach(band=>{
    band.addEventListener('mouseenter',()=>{
      bands.forEach(b=>b.classList.remove('is-open'));
      band.classList.add('is-open');
    });
    band.addEventListener('click',()=>{
      bands.forEach(b=>b.classList.remove('is-open'));
      band.classList.add('is-open');
    });
  });
})();

// ---------- Serveis: ajusta dinàmicament l'offset al header ----------
(function(){
  const hdr=document.getElementById('header');
  if(!hdr)return;
  function syncOffset(){
    const h=hdr.getBoundingClientRect().height;
    document.documentElement.style.setProperty('--sr-hdr-off',h+'px');
  }
  window.addEventListener('scroll',syncOffset,{passive:true});
  window.addEventListener('resize',syncOffset);
  syncOffset();
})();

// ---------- Serveis: tabs apilables (clic per anar a la fila) ----------
(function(){
  const tabs=document.querySelectorAll('.sr-tab');
  if(!tabs.length)return;
  tabs.forEach(tab=>tab.addEventListener('click',()=>{
    const id=tab.getAttribute('data-target');
    const row=document.getElementById(id);
    if(!row)return;
    const cs=getComputedStyle(document.documentElement);
    const tabH=parseInt(cs.getPropertyValue('--sr-tab-h'))||46;
    const idx=parseInt(id.replace('sr-',''))-1;
    const offset=tabH*idx+8;
    const top=row.getBoundingClientRect().top+window.scrollY-offset;
    window.scrollTo({top,behavior:'smooth'});
  }));
})();

// ---------- Home serveis: scroller horitzontal amb drag, wheel intel·ligent i fletxes ----------
(function(){
  const el=document.getElementById('homeServScroller');if(!el)return;
  const arrows=document.getElementById('homeServArrows');
  const prevBtn=arrows&&arrows.querySelector('.is-prev');
  const nextBtn=arrows&&arrows.querySelector('.is-next');

  // Drag — la classe .drag NOMÉS s'aplica quan hi ha moviment real (>10px),
  // així un click simple sempre passa al link
  let down=false,sx=0,sl=0,moved=false;
  el.addEventListener('pointerdown',e=>{
    down=true;moved=false;sx=e.clientX;sl=el.scrollLeft;
  });
  window.addEventListener('pointermove',e=>{
    if(!down)return;
    const d=e.clientX-sx;
    if(!moved&&Math.abs(d)>10){moved=true;el.classList.add('drag');}
    if(moved){el.scrollLeft=sl-d;}
  });
  const endDrag=()=>{if(!down)return;down=false;el.classList.remove('drag');};
  window.addEventListener('pointerup',endDrag);
  window.addEventListener('pointercancel',endDrag);
  el.addEventListener('click',e=>{if(moved){e.preventDefault();e.stopPropagation();moved=false;}},true);
  // Tota la card és clickable — navega al servei del <a> interior si no hi ha hagut drag
  el.querySelectorAll('.servei-card').forEach(card=>{
    card.style.cursor='pointer';
    card.addEventListener('click',e=>{
      if(moved)return;
      if(e.target.closest('a'))return; // el <a> intern ja navega sol
      const link=card.querySelector('.servei-content a[href^="#"]');
      if(!link)return;
      const href=link.getAttribute('href').slice(1);
      if(typeof showPage==='function')showPage(href);
    });
  });

  // Nota: NO capturem el wheel vertical. El scroll vertical de la pàgina sempre funciona.
  // El carrusel es navega amb drag, fletxes o trackpad horitzontal natiu.

  // Fletxes
  function step(){
    const card=el.querySelector('.servei-card');
    if(!card)return 320;
    const styles=getComputedStyle(el);
    const gap=parseFloat(styles.columnGap||styles.gap||'0');
    return card.getBoundingClientRect().width+gap;
  }
  function updateArrows(){
    if(!arrows)return;
    const padLeft=parseFloat(getComputedStyle(el).paddingLeft)||0;
    const max=el.scrollWidth-el.clientWidth-1;
    prevBtn.classList.toggle('is-hidden',el.scrollLeft<=padLeft+8);
    nextBtn.classList.toggle('is-hidden',el.scrollLeft>=max-8);
  }
  if(prevBtn)prevBtn.addEventListener('click',()=>{el.scrollBy({left:-step(),behavior:'smooth'});});
  if(nextBtn)nextBtn.addEventListener('click',()=>{el.scrollBy({left:step(),behavior:'smooth'});});
  el.addEventListener('scroll',updateArrows,{passive:true});
  window.addEventListener('resize',updateArrows);
  updateArrows();
})();

// ---------- Timeline: drag + wheel horizontal scroll ----------
(function(){
  const tl=document.getElementById('timelineHist');if(!tl)return;
  let down=false,sx=0,sl=0,moved=false;
  tl.addEventListener('pointerdown',e=>{down=true;moved=false;sx=e.clientX;sl=tl.scrollLeft;tl.classList.add('drag');});
  window.addEventListener('pointermove',e=>{if(!down)return;const d=e.clientX-sx;if(Math.abs(d)>4)moved=true;tl.scrollLeft=sl-d;});
  window.addEventListener('pointerup',()=>{if(!down)return;down=false;tl.classList.remove('drag');});
  tl.addEventListener('click',e=>{if(moved){e.preventDefault();e.stopPropagation();}},true);
  // Wheel no es captura: el scroll vertical de la pàgina sempre funciona sobre el timeline
})();

(function(){
  if(!window.gsap||!window.ScrollTrigger)return;
  gsap.registerPlugin(ScrollTrigger);

  // Respecta prefers-reduced-motion
  if(window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;

  // Targets: imatges que tenen background-image (cards, galeries, files)
  const targets=document.querySelectorAll('.servei-img, .noticia-img, .galeria-item, .svc-gallery .ph, .svc-stat-imgs .ph, .sr-img, .ph.tl-img');
  targets.forEach(el=>{
    // Assegurem overflow:hidden i un origen consistent
    el.style.willChange='transform';
    gsap.fromTo(el,
      {scale:1, force3D:true},
      {
        scale:1.18,
        ease:'none',
        force3D:true,
        scrollTrigger:{
          trigger:el,
          start:'top bottom',
          end:'bottom top',
          scrub:1.2
        }
      }
    );
  });

  // Parallax dels heroes amb ::before (svc-hero, mv-hero): movem el background-position
  const heroes=document.querySelectorAll('.svc-hero, .mv-hero, .feature-quote');
  heroes.forEach(el=>{
    gsap.to(el,{
      backgroundPositionY:'30%',
      ease:'none',
      scrollTrigger:{
        trigger:el,
        start:'top bottom',
        end:'bottom top',
        scrub:1
      }
    });
  });

  // Refrescar quan canvia la pàgina (SPA)
  const refresh=()=>setTimeout(()=>ScrollTrigger.refresh(),100);
  window.addEventListener('hashchange',refresh);
  document.addEventListener('click',e=>{if(e.target.closest('[onclick*="showPage"]'))refresh();});
})();