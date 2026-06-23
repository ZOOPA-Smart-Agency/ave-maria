/* Fundació Ave Maria — interaccions del tema */
(function () {
  'use strict';
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function ready(fn) {
    if (document.readyState !== 'loading') { fn(); }
    else { document.addEventListener('DOMContentLoaded', fn); }
  }

  ready(function () {
    var reveals = document.querySelectorAll('.reveal');

    if (reduce || !('IntersectionObserver' in window)) {
      reveals.forEach(function (el) { el.classList.add('in'); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (x) {
        if (x.isIntersecting) {
          x.target.classList.add('in');
          io.unobserve(x.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

    reveals.forEach(function (el) { io.observe(el); });

    // Menú mòbil senzill: mostra/amaga la navegació principal.
    var btn = document.querySelector('.menu-btn');
    var nav = document.querySelector('header.site nav.main');
    if (btn && nav) {
      btn.addEventListener('click', function () {
        var open = nav.style.display === 'flex';
        nav.style.display = open ? '' : 'flex';
        nav.style.position = 'absolute';
        nav.style.top = '72px';
        nav.style.left = '0';
        nav.style.right = '0';
        nav.style.flexDirection = 'column';
        nav.style.background = '#fff';
        nav.style.borderBottom = '1px solid #E2E2E2';
        nav.style.padding = open ? '' : '18px 24px';
      });
    }
  });
})();
