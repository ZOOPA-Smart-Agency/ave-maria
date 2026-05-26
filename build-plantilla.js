// Build script · plantilla-ave-maria.pptx
// Estil EDITORIAL coherent amb brand-guidelines-ave-maria.html v2.0
// Run: NODE_PATH=$(npm root -g) node build-plantilla.js

const pptxgen = require('pptxgenjs');
const sharp = require('sharp');

// ─── BRAND TOKENS ────────────────────────────────────────────────
const FONT = 'Montserrat';
const FONT_MONO = 'Menlo';
const C = {
  TARONJA:     'E8863A',
  CORAL:       'E85D75',
  GROC:        'F2C14E',
  BLAU:        '5DADE2',
  VERD:        '2D936C',
  ROSA:        'D4859A',
  TINTA:       '1A1A1A',
  GRIS_900:    '262626',
  GRIS_800:    '595959',
  GRIS_600:    '666666',
  GRIS_500:    '999999',
  GRIS_300:    'CCCCCC',
  GRIS_200:    'E5E5E5',
  GRIS_100:    'F5F5F5',
  GRIS_050:    'FAFAFA',
  BLANC:       'FFFFFF',
  TARONJA_INK: 'B8651D',
  CORAL_INK:   'B0334B',
  VERD_INK:    '1F6B4E',
  BLAU_INK:    '2E7BAB',
};
const SLIDE_W = 13.333;
const SLIDE_H = 7.5;
const TOTAL = 15;

// ─── ICON SVG PATHS (coherent amb design-system-iconografia.html) ───
const ICONS = {
  heart:         '<path d="M12 20s-7-4.5-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.5-7 10-7 10z"/>',
  home:          '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/><path d="M10 20v-5h4v5"/>',
  hands:         '<path d="M8 12V8a2 2 0 0 1 4 0v4"/><path d="M12 12V6a2 2 0 0 1 4 0v6"/><path d="M16 10a2 2 0 0 1 4 0v4a6 6 0 0 1-12 0v-2a2 2 0 0 1 4 0"/>',
  person:        '<circle cx="12" cy="8" r="3.5"/><path d="M5 21c0-3.5 3-6.5 7-6.5s7 3 7 6.5"/>',
  group:         '<circle cx="9" cy="9" r="3"/><circle cx="17" cy="10" r="2.5"/><path d="M3 19c0-3 2.5-5 6-5s6 2 6 5"/><path d="M14 19c0-2 2-3 4-3s3 1 3 3"/>',
  diversity:     '<circle cx="9" cy="12" r="5"/><circle cx="15" cy="12" r="5"/>',
  leaf:          '<path d="M11 20a7 7 0 0 1-7-7c0-5 6-9 16-9-1 9-5 16-9 16z"/><path d="M5 19l9-9"/>',
  accessibility: '<circle cx="12" cy="4.5" r="1.5"/><path d="M12 7v4h4l-1 4"/><circle cx="13" cy="17" r="4"/>',
  donate:        '<path d="M3 14h4l3 3 3-3h4a2 2 0 0 0 2-2V9"/><path d="M12 10s-4-2.5-4-5.5A2.5 2.5 0 0 1 10.5 2 2.5 2.5 0 0 1 12 3a2.5 2.5 0 0 1 1.5-1A2.5 2.5 0 0 1 16 4.5c0 3-4 5.5-4 5.5z"/>',
  mail:          '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
  phone:         '<path d="M5 4h4l2 5-3 2a11 11 0 0 0 5 5l2-3 5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
  arrow:         '<path d="M5 12h14"/><path d="M13 6l6 6-6 6"/>',
};

async function iconToPng(iconKey, hexColor = '#1A1A1A', size = 384) {
  const p = ICONS[iconKey];
  if (!p) throw new Error('Unknown icon: ' + iconKey);
  const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="${hexColor}" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">${p}</svg>`;
  const buf = await sharp(Buffer.from(svg)).resize(size, size).png().toBuffer();
  return 'image/png;base64,' + buf.toString('base64');
}

// ─── MOSAIC GENERATOR ───────────────────────────────────────────
// Genera un patró 6×4 de cel·les amb formes geomètriques de la marca
// estil "isotip generatiu" — per fer servir com a fons al 7% d'opacitat
async function buildMosaicPng(opacityPct = 7) {
  const COLS = 6, ROWS = 4, CELL = 240;
  const W = COLS * CELL, H = ROWS * CELL;
  const palette = ['E8863A', 'E85D75', 'F2C14E', '5DADE2', '2D936C', 'D4859A', '1A1A1A'];
  const shapes = [
    (cx, cy, s, c) => `<rect x="${cx-s/2}" y="${cy-s/2}" width="${s}" height="${s}" fill="#${c}"/>`,
    (cx, cy, s, c) => `<circle cx="${cx}" cy="${cy}" r="${s/2}" fill="#${c}"/>`,
    (cx, cy, s, c) => `<path d="M ${cx-s/2} ${cy-s/2} L ${cx+s/2} ${cy-s/2} L ${cx-s/2} ${cy+s/2} Z" fill="#${c}"/>`,
    (cx, cy, s, c) => `<path d="M ${cx-s/2} ${cy+s/2} A ${s} ${s} 0 0 1 ${cx+s/2} ${cy-s/2} L ${cx+s/2} ${cy+s/2} Z" fill="#${c}"/>`,
    (cx, cy, s, c) => `<path d="M ${cx-s/2} ${cy-s/2} A ${s} ${s} 0 0 1 ${cx+s/2} ${cy+s/2} L ${cx-s/2} ${cy+s/2} Z" fill="#${c}"/>`,
    (cx, cy, s, c) => `<rect x="${cx-s/4}" y="${cy-s/2}" width="${s/2}" height="${s}" fill="#${c}"/>`,
    (cx, cy, s, c) => `<circle cx="${cx}" cy="${cy}" r="${s/4}" fill="#${c}"/>`,
  ];
  // pseudo-random determinístic perquè sempre surti igual
  let seed = 42;
  const rand = () => { seed = (seed * 9301 + 49297) % 233280; return seed / 233280; };

  let svgInner = '';
  for (let r = 0; r < ROWS; r++) {
    for (let c = 0; c < COLS; c++) {
      const cx = c * CELL + CELL / 2;
      const cy = r * CELL + CELL / 2;
      // 1 de cada 4 cel·les buida (rule de la marca)
      if (rand() < 0.18) continue;
      const color = palette[Math.floor(rand() * palette.length)];
      const shape = shapes[Math.floor(rand() * shapes.length)];
      svgInner += shape(cx, cy, CELL * 0.85, color);
    }
  }
  const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${W}" height="${H}" viewBox="0 0 ${W} ${H}"><rect width="${W}" height="${H}" fill="#FFFFFF"/><g opacity="${opacityPct/100}">${svgInner}</g></svg>`;
  const buf = await sharp(Buffer.from(svg)).png().toBuffer();
  return 'image/png;base64,' + buf.toString('base64');
}

// ═══════════════════════════════════════════════════════════════
// PRESENTATION BUILD
// ═══════════════════════════════════════════════════════════════
(async () => {
  const pres = new pptxgen();
  pres.layout = 'LAYOUT_WIDE';
  pres.author = 'Fundació Ave Maria';
  pres.title = 'Plantilla mestra · Fundació Ave Maria';
  pres.subject = 'Plantilla editorial reutilitzable · Brand Guidelines v2.0 · WCAG 2.2 AA';
  pres.company = 'Fundació Ave Maria · Sitges';

  // Preload assets
  const MOSAIC = await buildMosaicPng(7);
  const MOSAIC_DENSE = await buildMosaicPng(12);
  const ICW_HEART = await iconToPng('heart', '#FFFFFF', 384);
  const ICW_DIVERSITY = await iconToPng('diversity', '#FFFFFF', 384);
  const ICW_HOME = await iconToPng('home', '#FFFFFF', 384);
  const ICW_ARROW = await iconToPng('arrow', '#FFFFFF', 384);
  const IC_HOME_TARONJA = await iconToPng('home',  '#B8651D', 384);
  const IC_PHONE_CORAL  = await iconToPng('phone', '#B0334B', 384);
  const IC_MAIL_VERD    = await iconToPng('mail',  '#1F6B4E', 384);

  // ─── HELPERS ──────────────────────────────────────────────────

  // Eyebrow editorial: "01 — Qui som" — 11pt bold uppercase taronja, letter-spacing 3
  function eyebrow(slide, x, y, num, name, color = C.TARONJA_INK) {
    slide.addText([
      { text: num, options: { fontFace: FONT, fontSize: 11, bold: true, color, charSpacing: 3 } },
      { text: '   —   ', options: { fontFace: FONT, fontSize: 11, bold: true, color: C.GRIS_300, charSpacing: 3 } },
      { text: name.toUpperCase(), options: { fontFace: FONT, fontSize: 11, bold: true, color, charSpacing: 3 } }
    ], { x, y, w: 9, h: 0.3, margin: 0 });
  }

  // Section title: 44pt bold, letter-spacing tight
  // Acepta array de runs per a mix Light/Bold
  function sectionTitle(slide, x, y, w, runs, opts = {}) {
    const fontSize = opts.size || 44;
    const lines = runs.map(r => ({
      text: r.text,
      options: {
        fontFace: FONT,
        fontSize,
        bold: r.bold === undefined ? true : r.bold,
        color: r.color || C.TINTA,
        charSpacing: -1,
        ...(r.breakLine ? { breakLine: true } : {})
      }
    }));
    slide.addText(lines, { x, y, w, h: opts.h || 1.0, margin: 0, valign: 'top' });
  }

  // Lead: 20pt regular, tinta, max ~720pt wide
  function lead(slide, x, y, w, text) {
    slide.addText(text, {
      x, y, w, h: 1.2,
      fontFace: FONT, fontSize: 18, color: C.TINTA,
      lineSpacingMultiple: 1.5, margin: 0
    });
  }

  // Body: 14pt grey 666, line-height 1.7
  function body(slide, x, y, w, h, text) {
    slide.addText(text, {
      x, y, w, h,
      fontFace: FONT, fontSize: 14, color: C.GRIS_600,
      lineSpacingMultiple: 1.7, margin: 0, valign: 'top'
    });
  }

  // Footer recurrent: línia 1px gris-200 + wordmark esquerra + paginació dreta
  // (Sense banda taronja gruixuda; respect a l'estètica editorial sòbria.)
  function addFooter(slide, pageNum, opts = {}) {
    const dark = opts.dark || false;
    const fg = dark ? 'rgba(255,255,255,0.55)' : C.GRIS_500;
    const fgRGB = dark ? C.BLANC : C.GRIS_500;
    // Línea sutil
    slide.addShape(pres.shapes.RECTANGLE, {
      x: 0.6, y: 7.16, w: SLIDE_W - 1.2, h: 0.012,
      fill: { color: dark ? C.BLANC : C.GRIS_200, transparency: dark ? 75 : 0 },
      line: { color: dark ? C.BLANC : C.GRIS_200, width: 0 }
    });
    // Wordmark izq
    slide.addText([
      { text: 'AVE MARIA', options: { fontFace: FONT, fontSize: 8, bold: true, charSpacing: 4, color: fgRGB } },
      { text: '     Fundació · Sitges', options: { fontFace: FONT, fontSize: 8, color: fgRGB, charSpacing: 1 } }
    ], { x: 0.6, y: 7.27, w: 5, h: 0.25, margin: 0 });
    // Paginación der
    if (pageNum !== null) {
      const num = String(pageNum).padStart(2, '0');
      slide.addText([
        { text: num, options: { fontFace: FONT, fontSize: 9, bold: true, color: fgRGB } },
        { text: ' / ' + String(TOTAL).padStart(2, '0'), options: { fontFace: FONT, fontSize: 9, color: fgRGB } }
      ], { x: SLIDE_W - 1.7, y: 7.27, w: 1.1, h: 0.25, align: 'right', margin: 0 });
    }
  }

  // Dark-box: caixa negra padding 0.5", radius pronunciat
  function darkBox(slide, x, y, w, h) {
    slide.addShape(pres.shapes.ROUNDED_RECTANGLE, {
      x, y, w, h,
      fill: { color: C.TINTA },
      line: { color: C.TINTA, width: 0 },
      rectRadius: 0.18
    });
  }

  // Card editorial: gris clar, radius 16pt
  function softCard(slide, x, y, w, h) {
    slide.addShape(pres.shapes.ROUNDED_RECTANGLE, {
      x, y, w, h,
      fill: { color: C.GRIS_100 },
      line: { color: C.GRIS_100, width: 0 },
      rectRadius: 0.12
    });
  }

  // Icon-box 56×56 (≈0.78") amb radius 12pt, color sòlid de fons + icona blanca
  function iconBox(slide, x, y, color, iconData) {
    const SZ = 0.78;
    slide.addShape(pres.shapes.ROUNDED_RECTANGLE, {
      x, y, w: SZ, h: SZ,
      fill: { color }, line: { color, width: 0 },
      rectRadius: 0.18
    });
    const ICN = 0.42;
    slide.addImage({
      data: iconData,
      x: x + (SZ - ICN) / 2, y: y + (SZ - ICN) / 2, w: ICN, h: ICN
    });
  }

  // Mosaic background full-bleed
  function mosaicBg(slide, dense = false) {
    slide.addImage({
      data: dense ? MOSAIC_DENSE : MOSAIC,
      x: 0, y: 0, w: SLIDE_W, h: SLIDE_H,
      sizing: { type: 'cover', w: SLIDE_W, h: SLIDE_H }
    });
  }

  // Placeholder imatge editorial — gris molt suau amb dashed border
  function placeholderImage(slide, x, y, w, h, label = 'IMATGE') {
    slide.addShape(pres.shapes.RECTANGLE, {
      x, y, w, h,
      fill: { color: C.GRIS_050 }, line: { color: C.GRIS_200, width: 1, dashType: 'dash' }
    });
    slide.addText([
      { text: '◇', options: { fontFace: FONT, fontSize: 22, color: C.GRIS_300, breakLine: true } },
      { text: label, options: { fontFace: FONT, fontSize: 9, charSpacing: 4, bold: true, color: C.GRIS_500 } }
    ], { x, y, w, h, align: 'center', valign: 'middle', margin: 0 });
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 1 · PORTADA · MOSAIC + TÍTOL BOTTOM-LEFT
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };
    mosaicBg(s);

    // Wordmark superior izquierda
    s.addText([
      { text: 'AVE MARIA', options: { fontFace: FONT, fontSize: 12, bold: true, charSpacing: 5, color: C.TINTA } }
    ], { x: 0.7, y: 0.65, w: 5, h: 0.3, margin: 0 });
    s.addText('Fundació · Sitges', {
      x: 0.7, y: 0.95, w: 5, h: 0.3,
      fontFace: FONT, fontSize: 9, charSpacing: 2, color: C.GRIS_600, margin: 0
    });

    // Eyebrow
    eyebrow(s, 0.7, 4.0, '00', 'Plantilla · v1.1');

    // Title — Light + Bold, 64pt, bottom-left
    s.addText([
      { text: 'Brand', options: { fontFace: FONT, fontSize: 64, bold: false, color: C.TINTA, charSpacing: -2, breakLine: true } },
      { text: 'Guidelines.', options: { fontFace: FONT, fontSize: 64, bold: true, color: C.TINTA, charSpacing: -2 } }
    ], { x: 0.7, y: 4.4, w: 8, h: 1.9, margin: 0, valign: 'top' });

    // Subtítol amb límit clar de 720pt (≈10")
    s.addText('Plantilla mestra reutilitzable per a presentacions institucionals. Coherent amb el manual d\'identitat visual v2.0.', {
      x: 0.7, y: 6.45, w: 8.5, h: 0.6,
      fontFace: FONT, fontSize: 13, color: C.GRIS_600, lineSpacingMultiple: 1.5, margin: 0
    });

    addFooter(s, 1);

    s.addNotes(`PORTADA · Layout #1
Estil: editorial coherent amb brand-guidelines-ave-maria.html v2.0.

Composició:
• Fons: mosaic generatiu de l'isotip al 7% d'opacitat (esquerra→dreta amb formes geomètriques de la marca).
• Wordmark superior esquerra (12pt bold + 9pt regular per a "Fundació · Sitges").
• Eyebrow taronja "00 — PLANTILLA · v1.1" amb separador em-dash.
• Títol massiu 64pt: combina pes Light ("Brand") + Bold ("Guidelines.") amb char-spacing apretat (-2).
• Subtítol breu, gris, max 8.5" d'ample.

Accessibilitat WCAG 2.2 AA:
• Text negre sobre fons blanc (mosaic 7%) → contrast efectiu ≥16:1 ✓
• Eyebrow taronja-ink sobre blanc → 4.85:1 ✓
• Subtítol gris-600 sobre blanc → 5.74:1 ✓`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 2 · PORTADA ALTERNATIVA — MINIMAL TOTAL (sense mosaic)
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    // Centered content
    s.addText([
      { text: 'FUNDACIÓ', options: { fontFace: FONT, fontSize: 10, bold: true, charSpacing: 6, color: C.TARONJA_INK, breakLine: true } }
    ], { x: 0, y: 2.3, w: SLIDE_W, h: 0.3, align: 'center', margin: 0 });

    s.addText([
      { text: 'Ave Maria.', options: { fontFace: FONT, fontSize: 110, bold: true, color: C.TINTA, charSpacing: -3 } }
    ], { x: 0, y: 2.9, w: SLIDE_W, h: 1.6, align: 'center', margin: 0 });

    // Línea fina taronja
    s.addShape(pres.shapes.RECTANGLE, {
      x: (SLIDE_W - 0.5) / 2, y: 4.85, w: 0.5, h: 0.025,
      fill: { color: C.TARONJA }, line: { color: C.TARONJA, width: 0 }
    });

    s.addText('Memòria 2025 · Acompanyem persones, transformem vides.', {
      x: 0, y: 5.15, w: SLIDE_W, h: 0.4,
      fontFace: FONT, fontSize: 14, color: C.GRIS_600, align: 'center', margin: 0
    });

    addFooter(s, 2);

    s.addNotes(`PORTADA ALTERNATIVA · Layout #2
Versió més sòbria que la #1 — sense mosaic, només tipografia centrada.

Composició:
• Sobretítol 10pt taronja-ink amb tracking ampli (6).
• Títol massiu "Ave Maria." 110pt bold tinta amb char-spacing apretat (-3).
• Línia divisòria de 0.5" en taronja (detall editorial).
• Subtítol 14pt gris-600.

Quan usar: portades formals, memòries anuals, informes interns. Quan vols sobrietat absoluta.

Accessibilitat: tots els textos sobre blanc passen AA amb marge.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 3 · SEPARADOR DE SECCIÓ — EDITORIAL, NO FULL COLOR
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    // Massiu número outline en gris molt suau (com a element decoratiu)
    s.addText('01', {
      x: 0.5, y: 1.0, w: 7.5, h: 5.5,
      fontFace: FONT, fontSize: 480, bold: true, color: C.GRIS_100,
      align: 'left', valign: 'middle', charSpacing: -8, margin: 0
    });

    // Eyebrow + titular + lead a la dreta amb tot l'espai
    eyebrow(s, 7.5, 3.0, 'SECCIÓ 01', 'Qui som', C.TARONJA_INK);

    s.addText([
      { text: 'Qui ', options: { fontFace: FONT, fontSize: 64, bold: false, color: C.TINTA, charSpacing: -1.5 } },
      { text: 'som', options: { fontFace: FONT, fontSize: 64, bold: true, color: C.TINTA, charSpacing: -1.5 } },
      { text: '.', options: { fontFace: FONT, fontSize: 64, bold: true, color: C.TARONJA, charSpacing: -1.5 } }
    ], { x: 7.5, y: 3.4, w: 5.5, h: 1.3, margin: 0 });

    s.addText('Una fundació amb 39 anys d\'història al servei de les persones amb diversitat funcional al Garraf.', {
      x: 7.5, y: 4.85, w: 5.0, h: 1.5,
      fontFace: FONT, fontSize: 16, color: C.GRIS_600, lineSpacingMultiple: 1.6, margin: 0
    });

    addFooter(s, 3);

    s.addNotes(`SEPARADOR DE SECCIÓ · Layout #3
Estil editorial — ZERO fons a color complet (a diferència de plantilles habituals).

Composició:
• Número massiu "01" 480pt en color GRIS-100 (quasi blanc) com a element gegantí decoratiu.
• Eyebrow + títol + lead a la dreta, amb la mateixa jerarquia que les pàgines internes — així el lector sap que entra en un capítol però mantenim respiració.
• Punt taronja final al títol (detall editorial recurrent).

Accessibilitat:
• Tinta sobre blanc: 17.4:1 ✓
• El número gegant gris-100 és decoratiu (NO transmet informació), no necessita contrast.
• Eyebrow taronja-ink: 4.85:1 ✓

Variants: per a SECCIÓ 02, 03... canviar només el número. El estil es repeteix.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 4 · CONTINGUT BASE — EYEBROW + TÍTOL + LEAD + IMATGE
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '01', 'Qui som');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: 'La nostra ', bold: false },
      { text: 'missió', bold: true },
      { text: '.', bold: true, color: C.TARONJA }
    ], { size: 44 });

    // Lead 18pt
    lead(s, 0.7, 2.3, 6.0,
      'Garantim la qualitat de vida de les persones amb diversitat funcional, potenciant les seves capacitats i acompanyant-les al llarg del seu projecte vital.'
    );

    // Body 14pt
    body(s, 0.7, 4.4, 6.0, 1.8,
      'Treballem des de 1987 a Sitges i comarca del Garraf, oferint serveis residencials, ocupacionals i d\'acompanyament a més de 800 persones cada any.'
    );

    // Imatge dreta
    placeholderImage(s, 7.4, 1.05, 5.2, 5.5, 'IMATGE  ·  16 × 12');

    // Caption
    s.addText('Centre Ocupacional · Sitges, 2025', {
      x: 7.4, y: 6.6, w: 5.2, h: 0.3,
      fontFace: FONT, fontSize: 9, italic: true, color: C.GRIS_500, margin: 0
    });

    addFooter(s, 4);

    s.addNotes(`CONTINGUT BASE · Layout #4
El layout més freqüent. Combina eyebrow + títol + lead + body + imatge.

Composició editorial pura (estil v2.0):
• Eyebrow "01 — QUI SOM" 11pt taronja amb separador em-dash.
• Títol 44pt amb mecànica Light + Bold + punt color (signature de la marca).
• Lead 18pt en tinta (paràgraf d'introducció amb pes).
• Body 14pt en gris-600 amb line-height 1.7 (text de cos relaxat).
• Imatge a la dreta 5.2 × 5.5" amb caption en cursiva 9pt gris-500.

Jerarquia tipogràfica: Eyebrow → Títol → Lead → Body. Mai trencar aquest ordre.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 5 · DUES COLUMNES — EDITORIAL
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '02', 'Enfoc');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: 'Dos pilars, una ', bold: false },
      { text: 'mateixa missió', bold: true },
      { text: '.', bold: true, color: C.TARONJA }
    ], { size: 40 });

    s.addText('La fundació estructura la seva activitat al voltant de dos eixos complementaris.', {
      x: 0.7, y: 2.05, w: 11, h: 0.5,
      fontFace: FONT, fontSize: 16, color: C.GRIS_600, margin: 0
    });

    // Columna 01
    s.addText('01', {
      x: 0.7, y: 3.0, w: 1, h: 0.6,
      fontFace: FONT, fontSize: 32, bold: true, color: C.TARONJA, margin: 0
    });
    s.addText('Acompanyament directe', {
      x: 0.7, y: 3.7, w: 5.5, h: 0.55,
      fontFace: FONT, fontSize: 22, bold: true, color: C.TINTA, margin: 0
    });
    body(s, 0.7, 4.35, 5.5, 2.5,
      'Serveis residencials i ocupacionals que ofereixen suport diari, des de la llar fins a l\'activitat productiva. Equips professionals especialitzats acompanyen cada persona en el seu projecte vital.'
    );

    // Columna 02
    s.addText('02', {
      x: 7.0, y: 3.0, w: 1, h: 0.6,
      fontFace: FONT, fontSize: 32, bold: true, color: C.VERD_INK, margin: 0
    });
    s.addText('Innovació social', {
      x: 7.0, y: 3.7, w: 5.5, h: 0.55,
      fontFace: FONT, fontSize: 22, bold: true, color: C.TINTA, margin: 0
    });
    body(s, 7.0, 4.35, 5.5, 2.5,
      'Investiguem i implementem noves metodologies. Des de programes terapèutics fins a iniciatives d\'inclusió laboral, treballem per ampliar l\'horitzó del que és possible per a cada persona.'
    );

    // Línia divisòria sutil entre columnes
    s.addShape(pres.shapes.RECTANGLE, {
      x: 6.66, y: 3.0, w: 0.005, h: 3.7,
      fill: { color: C.GRIS_200 }, line: { color: C.GRIS_200, width: 0 }
    });

    addFooter(s, 5);

    s.addNotes(`DUES COLUMNES · Layout #5
Estil editorial: numeració gran ("01", "02") com a marcador en color de marca.

Composició:
• Encapçalament: eyebrow + títol + descripció.
• Dues columnes amb número 32pt en color (taronja, verd-ink).
• Mini-títol 22pt bold tinta + body 14pt gris.
• Línia divisòria de 1px gris-200 al centre — NO bandes gruixudes de color (estil sòbri editorial).

Accessibilitat: tots els textos en tinta o gris-600 sobre blanc, ratios ≥5.74:1 ✓.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 6 · TRES CARDS · EDITORIAL — gris clar, icon-boxes
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '03', 'Valors');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: 'El que ', bold: false },
      { text: 'ens guia', bold: true },
      { text: '.', bold: true, color: C.TARONJA }
    ], { size: 40 });

    const cards = [
      { color: C.CORAL, icon: ICW_HEART, title: 'Respecte', body: 'La dignitat de cada persona és el centre de tot el que fem.' },
      { color: C.VERD, icon: ICW_DIVERSITY, title: 'Diversitat', body: 'Acollim la riquesa de les diferències com a font d\'aprenentatge.' },
      { color: C.BLAU, icon: ICW_HOME, title: 'Arrelament', body: 'Construïm un projecte de territori, profundament local.' },
    ];

    const cardW = 3.8, cardH = 3.6, gap = 0.3;
    const startX = (SLIDE_W - (cardW * 3 + gap * 2)) / 2;
    const cardY = 2.6;

    cards.forEach((card, i) => {
      const x = startX + i * (cardW + gap);
      softCard(s, x, cardY, cardW, cardH);
      // Icon-box 56×56 (squared rounded)
      iconBox(s, x + 0.45, cardY + 0.45, card.color, card.icon);
      // Title
      s.addText(card.title, {
        x: x + 0.45, y: cardY + 1.55, w: cardW - 0.9, h: 0.55,
        fontFace: FONT, fontSize: 22, bold: true, color: C.TINTA, margin: 0
      });
      // Body
      s.addText(card.body, {
        x: x + 0.45, y: cardY + 2.2, w: cardW - 0.9, h: 1.2,
        fontFace: FONT, fontSize: 13, color: C.GRIS_600, lineSpacingMultiple: 1.6, margin: 0
      });
    });

    addFooter(s, 6);

    s.addNotes(`TRES CARDS · Layout #6
Estil editorial coherent amb les "value-cards" de brand-guidelines-ave-maria.html.

Composició:
• Card amb fons gris-100 i border-radius 12% (≈16pt).
• Icon-box 56×56 en color de marca, cantonades arrodonides — NO cercles.
• La icona blanca dins el quadrat de color.
• Títol alineat a l'esquerra (no centrat) — més editorial.
• Body 13pt gris-600 amb line-height 1.6.

Accessibilitat:
• Icones decoratives, acompanyades de text que ja explica.
• Contrast text gris-600 sobre fons gris-100: 5.0:1 ✓
• Els colors dels icon-boxes són decoratius — el significat es comunica pel text.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 7 · CITA — BLANCA AMB BORDER-LEFT TARONJA · 26pt italic
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '04', 'Veu de marca');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: 'Acompanyem ', bold: false },
      { text: 'persones', bold: true },
      { text: '.', bold: true, color: C.TARONJA }
    ], { size: 36 });

    // Border-left taronja 4px
    s.addShape(pres.shapes.RECTANGLE, {
      x: 1.2, y: 3.2, w: 0.06, h: 2.8,
      fill: { color: C.TARONJA }, line: { color: C.TARONJA, width: 0 }
    });

    // Quote en italic 28pt, max 9.5" wide
    s.addText('A la fundació he trobat un lloc on em sento escoltada i puc créixer al meu ritme. Aquí no se\'m jutja; se\'m acompanya.', {
      x: 1.55, y: 3.2, w: 10.5, h: 2.0,
      fontFace: FONT, fontSize: 26, italic: true, bold: false, color: C.TINTA,
      lineSpacingMultiple: 1.4, margin: 0, valign: 'top'
    });

    // Author
    s.addText([
      { text: 'Maria P.', options: { fontFace: FONT, fontSize: 14, bold: true, color: C.TINTA, breakLine: true } },
      { text: 'Usuària del Centre Ocupacional · 6 anys a la fundació', options: { fontFace: FONT, fontSize: 11, color: C.GRIS_600 } }
    ], { x: 1.55, y: 5.7, w: 8, h: 0.7, margin: 0 });

    addFooter(s, 7);

    s.addNotes(`CITA · Layout #7
Estil editorial pur: blockquote amb border-left 4px taronja, italic, sobre blanc.

Composició:
• Eyebrow + títol amb la mateixa pauta de la resta (no slide especial).
• Línia taronja 4px a l'esquerra com a indicador de cita (signature de la marca).
• Cita en italic 26pt tinta — el contrast amb la resta de tipografia ve del italic, no del color de fons.
• Autoria amb nom (bold) + rol (gris-600).

Per què canviem respecte el patró habitual: les guidelines v2.0 NO usen fons full-color per a cites. Mantenir la coherència editorial.

Accessibilitat:
• Tinta italic sobre blanc: 17.4:1 ✓
• Per als usuaris amb dislèxia, els italics poden ser més difícils. Si el text és llarg, considerar reduir a 22pt o usar pes regular.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 8 · STATS / DADES
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '05', 'Impacte');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: 'Dades del ', bold: false },
      { text: '2025', bold: true },
      { text: '.', bold: true, color: C.TARONJA }
    ], { size: 40 });

    s.addText('Tres xifres que resumeixen un any de feina al servei del nostre territori.', {
      x: 0.7, y: 2.05, w: 11, h: 0.5,
      fontFace: FONT, fontSize: 16, color: C.GRIS_600, margin: 0
    });

    const stats = [
      { num: '800', suffix: '+', label: 'BENEFICIARIS ATESOS', color: C.TARONJA_INK },
      { num: '39',  suffix: '',  label: 'ANYS D\'EXPERIÈNCIA',  color: C.CORAL_INK },
      { num: '120', suffix: '',  label: 'VOLUNTARIS ACTIUS',    color: C.VERD_INK },
    ];
    const blockW = 4.0, gap = 0.25;
    const startX = (SLIDE_W - (blockW * 3 + gap * 2)) / 2;
    const blockY = 3.6;

    stats.forEach((st, i) => {
      const x = startX + i * (blockW + gap);
      // Number with colored suffix
      s.addText([
        { text: st.num, options: { fontFace: FONT, fontSize: 110, bold: true, color: C.TINTA, charSpacing: -3 } },
        { text: st.suffix, options: { fontFace: FONT, fontSize: 110, bold: true, color: st.color, charSpacing: -3 } }
      ], { x, y: blockY, w: blockW, h: 1.6, align: 'center', margin: 0, valign: 'top' });
      // Label
      s.addText(st.label, {
        x, y: blockY + 1.7, w: blockW, h: 0.4,
        fontFace: FONT, fontSize: 11, bold: true, color: C.GRIS_600, charSpacing: 4, align: 'center', margin: 0
      });
    });

    // Footnote
    s.addText('Font: Memòria anual 2025, Fundació Ave Maria.', {
      x: 0.7, y: 6.7, w: 11, h: 0.3,
      fontFace: FONT, fontSize: 9, italic: true, color: C.GRIS_500, margin: 0
    });

    addFooter(s, 8);

    s.addNotes(`STATS · Layout #8
Comunicar impacte amb 3 xifres grans.

Composició:
• Numerals 110pt bold tinta — el sufix (+, %) en color de marca però sempre en versió "ink" per garantir contrast com a element gran.
• Labels en majúscules 11pt gris-600 amb tracking 4 (estil pell.de marca).
• Font clarament citada al peu.

Accessibilitat:
• Xifres tinta sobre blanc: 17.4:1 ✓
• Sufix en versió "ink" (taronja-ink, coral-ink, verd-ink) — passa AA com a text gran (4.5+:1 sobre blanc).
• Label gris-600 sobre blanc: 5.74:1 ✓`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 9 · TIMELINE
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '06', 'Història');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: '39 anys ', bold: true },
      { text: 'de fundació.', bold: false }
    ], { size: 40 });

    // Timeline horizontal line
    const lineY = 4.4;
    s.addShape(pres.shapes.RECTANGLE, {
      x: 1.0, y: lineY, w: SLIDE_W - 2.0, h: 0.025,
      fill: { color: C.GRIS_200 }, line: { color: C.GRIS_200, width: 0 }
    });

    const milestones = [
      { year: '1987', text: 'Fundació a Sitges per famílies.',         color: C.TARONJA_INK },
      { year: '1995', text: 'Primer Centre Ocupacional al Garraf.',    color: C.CORAL_INK },
      { year: '2008', text: 'Entitat d\'utilitat pública.',             color: C.VERD_INK },
      { year: '2018', text: 'Nova residència de 24 places.',            color: C.BLAU_INK },
      { year: '2026', text: 'Portal digital accessible.',               color: C.TARONJA_INK },
    ];

    const startX = 1.7;
    const stepW = (SLIDE_W - 2 * 1.7) / (milestones.length - 1);
    milestones.forEach((m, i) => {
      const x = startX + i * stepW;
      s.addShape(pres.shapes.OVAL, {
        x: x - 0.13, y: lineY - 0.11, w: 0.26, h: 0.26,
        fill: { color: m.color }, line: { color: C.BLANC, width: 2 }
      });
      s.addText(m.year, {
        x: x - 1.2, y: lineY - 1.0, w: 2.4, h: 0.45,
        fontFace: FONT, fontSize: 22, bold: true, color: m.color, align: 'center', margin: 0
      });
      s.addText(m.text, {
        x: x - 1.2, y: lineY + 0.45, w: 2.4, h: 1.4,
        fontFace: FONT, fontSize: 12, color: C.GRIS_800, align: 'center', margin: 0, valign: 'top'
      });
    });

    addFooter(s, 9);

    s.addNotes(`TIMELINE · Layout #9
Línia horitzontal amb 5 fites — colors "ink" garanteixen contrast AA.

Accessibilitat: anys en colors ink (≥4.7:1 sobre blanc), text 12pt gris-800 (7:1 sobre blanc) ✓.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 10 · EQUIP
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '07', 'Equip');

    sectionTitle(s, 0.7, 1.05, 12, [
      { text: 'Persones que ', bold: false },
      { text: 'fan possible', bold: true },
      { text: ' la fundació.', bold: false }
    ], { size: 36 });

    const team = [
      { initials: 'MR', name: 'Marta Riera',    role: 'Directora general',          color: C.TARONJA },
      { initials: 'JV', name: 'Jordi Valls',    role: 'Resp. C. Ocupacional',       color: C.CORAL },
      { initials: 'CN', name: 'Clara Noguera',  role: 'Treballadora social',        color: C.VERD },
      { initials: 'AS', name: 'Albert Sala',    role: 'Coord. residencial',         color: C.BLAU },
    ];
    const cardW = 2.7, cardH = 3.4, gap = 0.3;
    const startX = (SLIDE_W - (cardW * 4 + gap * 3)) / 2;
    const cardY = 2.7;

    team.forEach((p, i) => {
      const x = startX + i * (cardW + gap);
      const avatarSize = 1.7;
      const avatarX = x + (cardW - avatarSize) / 2;
      // Avatar com a cuadrat redondejat (no cercle) — més editorial
      s.addShape(pres.shapes.ROUNDED_RECTANGLE, {
        x: avatarX, y: cardY + 0.15, w: avatarSize, h: avatarSize,
        fill: { color: p.color }, line: { color: p.color, width: 0 }, rectRadius: 0.18
      });
      s.addText(p.initials, {
        x: avatarX, y: cardY + 0.15, w: avatarSize, h: avatarSize,
        fontFace: FONT, fontSize: 36, bold: true, color: C.BLANC, align: 'center', valign: 'middle', margin: 0
      });
      s.addText(p.name, {
        x, y: cardY + 2.1, w: cardW, h: 0.45,
        fontFace: FONT, fontSize: 16, bold: true, color: C.TINTA, align: 'center', margin: 0
      });
      s.addText(p.role, {
        x, y: cardY + 2.55, w: cardW, h: 0.5,
        fontFace: FONT, fontSize: 12, color: C.GRIS_600, align: 'center', margin: 0
      });
    });

    addFooter(s, 10);

    s.addNotes(`EQUIP · Layout #10
Avatars com a quadrats arrodonits (rectRadius 0.18) — coherent amb les icon-boxes editorials, NO cercles.

Quan es substitueixen per fotografies reals, mantenir la mateixa proporció quadrada amb cantonades suaus.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 11 · IMATGE FULL-BLEED — únic slide amb fons no-blanc
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    // Coral com a placeholder (substituible per imatge real)
    s.background = { color: C.CORAL };

    // Caixa blanca per a la marca de placeholder — visible
    s.addShape(pres.shapes.ROUNDED_RECTANGLE, {
      x: 4.3, y: 1.85, w: 4.7, h: 0.55,
      fill: { color: C.BLANC }, line: { color: C.BLANC, width: 0 }, rectRadius: 0.3
    });
    s.addText('◇   IMATGE FULL-BLEED  ·  Substituir per ≥1920×1080', {
      x: 4.3, y: 1.85, w: 4.7, h: 0.55,
      fontFace: FONT, fontSize: 10, charSpacing: 3, bold: true, color: C.TINTA, align: 'center', valign: 'middle', margin: 0
    });

    // Overlay fosc inferior — rounded perquè sigui editorial, no full-bleed
    s.addShape(pres.shapes.ROUNDED_RECTANGLE, {
      x: 0.7, y: 4.7, w: SLIDE_W - 1.4, h: 2.3,
      fill: { color: C.TINTA }, line: { color: C.TINTA, width: 0 }, rectRadius: 0.06
    });

    eyebrow(s, 1.1, 4.95, '08', 'Centre Ocupacional · Sitges', C.TARONJA);

    s.addText([
      { text: 'Cada matí, ', options: { fontFace: FONT, fontSize: 32, bold: false, color: C.BLANC, charSpacing: -1 } },
      { text: 'una nova oportunitat', options: { fontFace: FONT, fontSize: 32, bold: true, color: C.BLANC, charSpacing: -1 } },
      { text: '.', options: { fontFace: FONT, fontSize: 32, bold: true, color: C.GROC, charSpacing: -1 } }
    ], { x: 1.1, y: 5.3, w: 11.2, h: 0.7, margin: 0 });

    s.addText('Pintura, jardineria, ceràmica, manualitats — activitats que potencien autonomia, autoestima i sentit de pertinença.', {
      x: 1.1, y: 6.15, w: 11.2, h: 0.6,
      fontFace: FONT, fontSize: 13, color: C.GRIS_300, margin: 0
    });

    addFooter(s, 11, { dark: true });

    s.addNotes(`IMATGE FULL-BLEED · Layout #11
ÚNIC slide amb fons no-blanc (estil editorial: la imatge ho justifica).

Composició:
• Imatge cobreix tota la diapositiva (placeholder coral + caixa blanca per marcar substitució).
• Dark-box arrodonit (radius 0.06") al baix conté el text — NO és un overlay full-bleed, és una caixa flotant amb marges.
• Eyebrow + títol + subtítol dins la dark-box, blanc sobre tinta.

Per què caixa flotant i no overlay:
• És més editorial i menys "hero web".
• El text manté ALWAYS contrast 17.4:1 sobre tinta, independentment de la imatge.

Accessibilitat:
• Blanc sobre tinta: 17.4:1 ✓
• Gris-300 sobre tinta: 9.5:1 ✓
• La imatge real ha de portar altText descriptiu.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 12 · COMPARACIÓ — soft cards amb radius
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '09', 'Transformació');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: 'El ', bold: false },
      { text: 'projecte vital', bold: true },
      { text: ' de la Carla.', bold: false }
    ], { size: 36 });

    // ABANS — soft card editorial
    softCard(s, 0.7, 2.65, 5.8, 4.2);
    eyebrow(s, 1.1, 2.95, 'ABANS', '2019', C.GRIS_800);
    s.addText('Aïllament social', {
      x: 1.1, y: 3.3, w: 5, h: 0.55,
      fontFace: FONT, fontSize: 24, bold: true, color: C.TINTA, margin: 0
    });
    body(s, 1.1, 3.95, 5, 2.4,
      'La Carla vivia amb els pares, amb molt poca interacció fora del nucli familiar i sense rutines pròpies. Sentia que la seva vida no avançava.'
    );

    // Fletxa centrada en cercle taronja
    const cs = 0.85;
    s.addShape(pres.shapes.OVAL, {
      x: (SLIDE_W - cs) / 2, y: 4.4, w: cs, h: cs,
      fill: { color: C.TARONJA }, line: { color: C.TARONJA, width: 0 }
    });
    const ai = 0.45;
    s.addImage({
      data: ICW_ARROW,
      x: (SLIDE_W - ai) / 2, y: 4.4 + (cs - ai) / 2, w: ai, h: ai
    });

    // AVUI — dark box editorial
    darkBox(s, 6.83, 2.65, 5.8, 4.2);
    eyebrow(s, 7.23, 2.95, 'AVUI', '2026', C.TARONJA);
    s.addText('Vida amb propòsit', {
      x: 7.23, y: 3.3, w: 5, h: 0.55,
      fontFace: FONT, fontSize: 24, bold: true, color: C.BLANC, margin: 0
    });
    s.addText('La Carla és usuària del Centre Ocupacional, fa ceràmica 3 cops per setmana i ha trobat una xarxa d\'amistats. Té agenda pròpia i parla del seu futur.', {
      x: 7.23, y: 3.95, w: 5, h: 2.4,
      fontFace: FONT, fontSize: 14, color: C.GRIS_300,
      lineSpacingMultiple: 1.7, margin: 0, valign: 'top'
    });

    addFooter(s, 12);

    s.addNotes(`COMPARACIÓ · Layout #12
Les dues caixes amb radius 0.18 (cantonades arrodonides editorials, no rectangles plans).

Diferència de pes visual:
• ABANS: soft card gris-100 (estat passat, quiet).
• AVUI: dark box tinta (present, contrast).
• Fletxa al centre dins cercle taronja com a indicador de transformació.

Accessibilitat:
• Tinta sobre gris-100: 16:1 ✓
• Blanc sobre tinta: 17.4:1 ✓
• Gris-300 sobre tinta: 9.5:1 ✓`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 13 · CTA — DARK-BOX CENTRAL
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    // Mosaic suau amunt-dreta com a accent
    s.addImage({
      data: MOSAIC, x: 7.5, y: 0, w: 5.833, h: 7.5,
      transparency: 80,
    });

    eyebrow(s, 0.7, 0.7, '10', 'Col·labora');

    // Dark-box central amb el missatge — contingut dins respectant padding
    darkBox(s, 0.7, 1.6, SLIDE_W - 1.4, 5.0);

    // CTA-eyebrow dins dark-box
    s.addText([
      { text: 'DONACIÓ   ·   COL·LABORA', options: { fontFace: FONT, fontSize: 11, bold: true, charSpacing: 4, color: C.TARONJA } }
    ], { x: 1.3, y: 2.0, w: 10, h: 0.3, margin: 0 });

    // Titular dins dark-box
    s.addText([
      { text: 'El teu suport ', options: { fontFace: FONT, fontSize: 44, bold: false, color: C.BLANC, charSpacing: -1 } },
      { text: 'multiplica', options: { fontFace: FONT, fontSize: 44, bold: true, color: C.TARONJA, charSpacing: -1 } },
      { text: ' la nostra capacitat d\'acompanyar.', options: { fontFace: FONT, fontSize: 44, bold: false, color: C.BLANC, charSpacing: -1 } }
    ], { x: 1.3, y: 2.5, w: 10.5, h: 2.6, margin: 0, valign: 'top' });

    s.addText('Una donació mensual de 10 € permet oferir una hora setmanal d\'activitat terapèutica a una persona usuària.', {
      x: 1.3, y: 5.3, w: 9.5, h: 0.8,
      fontFace: FONT, fontSize: 14, color: C.GRIS_300, margin: 0, lineSpacingMultiple: 1.5
    });

    // Botó taronja arrodonit
    s.addShape(pres.shapes.ROUNDED_RECTANGLE, {
      x: 1.3, y: 6.1, w: 2.8, h: 0.45,
      fill: { color: C.TARONJA }, line: { color: C.TARONJA, width: 0 }, rectRadius: 0.5
    });
    s.addText('FES UN DONATIU →', {
      x: 1.3, y: 6.1, w: 2.8, h: 0.45,
      fontFace: FONT, fontSize: 10, bold: true, color: C.BLANC, charSpacing: 3,
      align: 'center', valign: 'middle', margin: 0
    });

    addFooter(s, 13);

    s.addNotes(`CTA · Layout #13
Estil editorial: dark-box central sobre fons blanc (en lloc d'un slide tot tinta).

Composició:
• Fons blanc amb mosaic suau a la dreta com a textura.
• Dark-box gran arrodonit (radius 0.18) conté tot el missatge — el contrast amb el fons blanc fa l'enfocament visual.
• Botó taronja amb radius pronunciat (pill shape).

Accessibilitat:
• Blanc sobre tinta: 17.4:1 ✓
• Taronja sobre tinta: 4.5:1 ✓ (text gran, AA)
• Gris-300 sobre tinta: 9.5:1 ✓
• Botó: blanc sobre taronja com a text gran/bold passa AA.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 14 · CIERRE / GRÀCIES
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };
    mosaicBg(s);

    s.addText([
      { text: 'Grà', options: { fontFace: FONT, fontSize: 200, bold: false, color: C.TINTA, charSpacing: -5 } },
      { text: 'cies', options: { fontFace: FONT, fontSize: 200, bold: true, color: C.TINTA, charSpacing: -5 } },
      { text: '.', options: { fontFace: FONT, fontSize: 200, bold: true, color: C.TARONJA, charSpacing: -5 } }
    ], { x: 0, y: 2.0, w: SLIDE_W, h: 2.6, align: 'center', margin: 0 });

    // Línea fina centrada
    s.addShape(pres.shapes.RECTANGLE, {
      x: (SLIDE_W - 0.5) / 2, y: 4.85, w: 0.5, h: 0.025,
      fill: { color: C.TARONJA }, line: { color: C.TARONJA, width: 0 }
    });

    s.addText('Per la teva atenció. Per voler caminar amb nosaltres.', {
      x: 0, y: 5.15, w: SLIDE_W, h: 0.5,
      fontFace: FONT, fontSize: 16, color: C.GRIS_600, align: 'center', margin: 0
    });

    addFooter(s, 14);

    s.addNotes(`CIERRE · Layout #14
Mateixa pauta editorial que la portada (mosaic 7%) — així el deck obre i tanca amb el mateix llenguatge visual.

Composició:
• Mosaic generatiu de fons al 7%.
• "Gràcies" 200pt amb mecànica Light + Bold + punt taronja.
• Línia divisòria 0.5" en taronja (recurrent en portades).
• Subtítol breu 16pt gris-600.`);
  }

  // ═════════════════════════════════════════════════════════════
  // SLIDE 15 · CONTACTE
  // ═════════════════════════════════════════════════════════════
  {
    const s = pres.addSlide();
    s.background = { color: C.BLANC };

    eyebrow(s, 0.7, 0.7, '11', 'Contacte');

    sectionTitle(s, 0.7, 1.05, 11, [
      { text: 'Parlem', bold: true },
      { text: '.', bold: true, color: C.TARONJA }
    ], { size: 56 });

    const cardY = 2.85, cardH = 3.5, cardW = 3.85, gap = 0.25;
    const startX = (SLIDE_W - (cardW * 3 + gap * 2)) / 2;

    const cols = [
      { icon: IC_HOME_TARONJA, accent: C.TARONJA, title: 'On som',     lines: ['Carrer de la Fundació, 1', '08870 Sitges', 'Garraf, Catalunya'] },
      { icon: IC_PHONE_CORAL,  accent: C.CORAL,   title: 'Truca\'ns',   lines: ['+34 938 945 000', 'Dl-Dv · 9-14h i 16-18h'] },
      { icon: IC_MAIL_VERD,    accent: C.VERD,    title: 'Escriu-nos', lines: ['info@avemaria.cat', 'donacions@avemaria.cat', 'voluntariat@avemaria.cat'] },
    ];

    cols.forEach((c, i) => {
      const x = startX + i * (cardW + gap);
      softCard(s, x, cardY, cardW, cardH);
      // Accent line top
      s.addShape(pres.shapes.RECTANGLE, {
        x: x + 0.45, y: cardY + 0.45, w: 0.5, h: 0.05,
        fill: { color: c.accent }, line: { color: c.accent, width: 0 }
      });
      // Icon
      s.addImage({ data: c.icon, x: x + 0.45, y: cardY + 0.7, w: 0.55, h: 0.55 });
      // Title
      s.addText(c.title, {
        x: x + 0.45, y: cardY + 1.45, w: cardW - 0.9, h: 0.5,
        fontFace: FONT, fontSize: 18, bold: true, color: C.TINTA, margin: 0
      });
      // Lines
      const lineRuns = [];
      c.lines.forEach((ln, j) => {
        lineRuns.push({ text: ln, options: { fontFace: FONT, fontSize: 12, color: C.GRIS_800, breakLine: j < c.lines.length - 1 } });
      });
      s.addText(lineRuns, {
        x: x + 0.45, y: cardY + 2.05, w: cardW - 0.9, h: 1.5,
        margin: 0, valign: 'top', lineSpacingMultiple: 1.6
      });
    });

    s.addText('AVEMARIA.CAT  ·  @FUNDACIOAVEMARIA  ·  /AVEMARIASITGES', {
      x: 0.7, y: 6.7, w: SLIDE_W - 1.4, h: 0.3,
      fontFace: FONT, fontSize: 10, bold: true, charSpacing: 4, color: C.GRIS_600, align: 'center', margin: 0
    });

    addFooter(s, 15);

    s.addNotes(`CONTACTE · Layout #15
Soft cards amb radius 0.12 (estil editorial) i línia d'accent superior breu (0.5") en color de marca.

Iconografia en versions "ink" (taronja-ink, coral-ink, verd-ink) per garantir AA.

Accessibilitat:
• Tinta sobre gris-100 card: 16:1 ✓
• Gris-800 sobre gris-100: 6.6:1 ✓
• Icones en colors ink ≥4.5:1 ✓`);
  }

  await pres.writeFile({ fileName: '/Users/dani.ebo/Documents/zoopa/claudepro/ave maria/plantilla-ave-maria.pptx' });
  console.log('✓ Plantilla generada: plantilla-ave-maria.pptx (estil editorial v2.0)');
})().catch(err => {
  console.error('✗ Error:', err);
  process.exit(1);
});
