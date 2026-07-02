# BRIEF — Backoffice WordPress
## Fundació Ave Maria (Sitges)

> Documento de encargo técnico para implementación de un backoffice WordPress bilingüe (CA/ES) que permita editar todos los textos e imágenes de la web sin tocar código.
>
> **Cliente:** Fundació Ave Maria de Sitges
> **Producto:** Sitio web bilingüe con panel de administración completo
> **Referencia visual:** Maqueta HTML estática ya diseñada, aprobada y publicada
> **Fecha:** 2026-07-01

---

## 1. Resumen ejecutivo

### Qué se pide
Migrar la maqueta HTML actual a **WordPress con backoffice completo**, donde el equipo de la Fundació pueda:

- Editar **cualquier texto** en **catalán y castellano** desde el panel WP.
- Cambiar **cualquier imagen** subiendo un archivo o eligiendo de la biblioteca.
- Añadir, editar o borrar **noticias, servicios, testimonios y miembros del patronato**.
- Todo sin tocar código y sin conocimientos técnicos.

### Alcance
- **25 páginas SPA** ya diseñadas (ver listado en §4.1).
- **Bilingüe CA/ES completo** — cada texto debe existir en los dos idiomas.
- **~26 imágenes actuales** + posibilidad de subir muchas más.
- **7 Custom Post Types** para contenido gestionable como listas.

### Stack técnico obligatorio
- **WordPress 6.0+** / **PHP 8.0+**
- **Polylang** (gratis, para bilingüe CA/ES)
- **Advanced Custom Fields** (versión **gratuita**, no Pro)

### Deliverables esperados
1. `avemaria-theme-v2.zip` — theme completo listo para subir al WP.
2. `avemaria-content.xml` — export WXR con todo el contenido inicial migrado.
3. `wp-import-guide.md` — guía paso a paso para instalar theme + contenido.
4. **Vídeo Loom** (o documento) de 5-10 min mostrando el panel a la Fundació.

---

## 2. Referencias visuales y de diseño

### Maqueta actual (fuente de verdad del diseño)
- **Ver web publicada:** https://zoopa-smart-agency.github.io/ave-maria/
- **Código fuente:** https://github.com/ZOOPA-Smart-Agency/ave-maria/
- **Archivo HTML:** `web/maqueta-avemaria.html`

### Wireframe original (contenido base)
- **Archivo:** `web/wireframe-avemaria.html`
- Contiene la estructura de contenido aprobada por la Fundació.

### Brand Book
- **Carpeta:** `web/BRANDBOOK_MARCA/` — logos SVG (positivo/negativo)
- **PDF completo:** `brand-guidelines-ave-maria-fundacio.pdf`

### Tipografía
- **Montserrat** (Google Fonts) — pesos 200, 300, 500, 600, 700, 900.

### Paleta de colores (uso obligatorio, sin variaciones)

| Nombre | Hex | Uso |
|---|---|---|
| Ink | `#202020` | Texto principal |
| Ink soft | `#3a3a3a` | Texto secundario |
| Muted | `#646464` | Texto terciario |
| Paper | `#F9F9F9` | Fondo principal |
| Paper 2 | `#F1F1EF` | Fondo alternativo |
| Surface dark | `#161616` | Bandas oscuras |
| **Taronja** | `#E8863A` | Acento de marca |
| **Verd** | `#2D936C` | Acento de marca |
| **Blau** | `#5DADE2` | Acento de marca |
| **Groc** | `#F2C14E` | Acento de marca |
| **Rosa** | `#D4859A` | Acento de marca |
| **Coral** | `#E85D75` | Acento de marca |

### Regla del cliente (no negociable)
> **"El diseño puede cambiar libremente, pero todo el texto del wireframe se ha de conservar idéntico (CA y ES)."**

---

## 3. Arquitectura del backoffice

### 3.1 Estructura de contenido en el panel

```
WP Panel
│
├── Ajustes / Personalizador (Customizer)
│   ├── Identidad del sitio (logo, favicon)
│   ├── Contacto global (teléfono, email, dirección)
│   ├── Redes sociales (links)
│   ├── Header (mensaje del top bar si lo hay)
│   └── Footer (columnas, textos legales)
│
├── Páginas fijas
│   ├── Home
│   ├── Qui Som
│   ├── Història
│   ├── Missió i Valors
│   ├── Equip
│   ├── Transparència
│   ├── Serveis (índice)
│   ├── Col·labora (índice)
│   ├── Donar
│   ├── Voluntariat
│   ├── Empreses
│   ├── Llegats
│   ├── Art
│   ├── Botiga
│   └── Contacte
│
├── Custom Post Types
│   ├── Serveis (6 items)
│   ├── Notícies (post nativo, 6+ items)
│   ├── Testimonis (3+ items)
│   ├── Membres Patronat (4 items)
│   ├── Àrees Equip (4 items)
│   ├── Estadístiques Impacte (6 items)
│   ├── Valors (5 items)
│   ├── Fites Trajectòria (timeline, ~8 items)
│   └── Col·laboradors (marquesina, ~10 items)
│
└── Idiomas (Polylang)
    ├── Català (principal)
    └── Espanyol
```

### 3.2 Estrategia para bilingüe

- **Polylang** gestionará todo. Cada página / post / CPT tendrá su versión CA y ES.
- Los **menús** se duplican (uno CA, uno ES).
- Las **cadenas globales** (footer, botones, avisos) se traducen desde **Polylang → Traducciones de cadenas**.
- Selector CA/ES en el header — usar la función `pll_the_languages()` o similar.

### 3.3 Estrategia para el editor de contenido (ACF versión gratis)

Como **ACF Free no incluye Repeaters ni Options Pages**, se usa esta estrategia:

- Para listas repetidas → **Custom Post Types con menu_order** para ordenar.
- Para textos globales del sitio → **Customizer nativo de WordPress**.
- Para contenido de cada página → **Meta boxes ACF** vinculados a esa página específica.

**Alternativa aceptable:** si el desarrollador prefiere usar **Meta Box (plugin gratis)** que sí tiene repeaters gratuitos, es aceptable siempre que la experiencia del editor sea igual o mejor.

---

## 4. Páginas de la web

### 4.1 Listado completo (28 páginas)

| # | ID | Título CA | Título ES | Tipo WP |
|---|---|---|---|---|
| 1 | `home` | Inici | Inicio | Página estática (front-page) |
| 2 | `quisom` | Qui Som | Quiénes Somos | Página |
| 3 | `historia` | Història | Historia | Página |
| 4 | `missio` | Missió i Valors | Misión y Valores | Página |
| 5 | `equip` | Equip | Equipo | Página |
| 6 | `transparencia` | Transparència | Transparencia | Página |
| 7 | `serveis` | Serveis | Servicios | Página (índice) |
| 8 | `campus` | Campus Residencial | Campus Residencial | CPT `servei` |
| 9 | `llars` | Llars amb Suport | Hogares con Apoyo | CPT `servei` |
| 10 | `sad` | Atenció Domiciliària | Atención Domiciliaria | CPT `servei` |
| 11 | `centresdia` | Centres de Dia | Centros de Día | CPT `servei` |
| 12 | `families` | Suport a Famílies i Inclusió Laboral | Apoyo a Familias e Inclusión Laboral | CPT `servei` |
| 13 | `recerca` | Recerca i Innovació | Investigación e Innovación | CPT `servei` |
| 14 | `collabora` | Col·labora | Colabora | Página |
| 15 | `donar` | Donar | Donar | Página |
| 16 | `art` | Fons d'Art | Fondo de Arte | Página |
| 17 | `botiga` | Botiga Solidària | Tienda Solidaria | Página |
| 18 | `actualitat` | Actualitat | Actualidad | Página (índice de posts) |
| 19-24 | `noticia-1` a `noticia-6` | (títulos variados) | (títulos variados) | Post nativo |
| 25 | `contacte` | Contacte | Contacto | Página |

### 4.2 Estructura por página (secciones a reproducir)

#### Home
- Hero (título grande + descripción + botón "Nostres Serveis" + card flotante con CTA "Vull fer un donatiu" + imagen fachada)
- Ticker (frase larga en marquesina infinita)
- Impacte (6 stats con líneas de colores variados sobre fondo negro)
- Serveis (carrusel horizontal de 6 servicios con flechas)
- Història i trajectòria (3 fites destacadas)
- Manifest (bloque negro con "Ho creiem: cada persona té dret a viure amb dignitat.")
- CTA Donació (fondo verde con botón)
- Testimonis (carrusel infinito de 3+ testimonios con peek lateral)
- Notícies (grid de 3 últimas noticias + botón "Totes les notícies")
- Col·laboradors (marquesina de logos)

#### Qui Som (Presentació)
- Intro editorial ("Una fundació compromesa…")
- Datos clave (6 stats en banda negra)
- Cita destacada ("Som una fundació centenària…")
- La nostra història (2 párrafos sobre Rosalía Dalmau)
- 3 columnas: Missió / Visió / Valors
- Documentos descargables (3 PDFs con iconos)

#### Història
- Intro
- Origen (3 columnas: 01 La fundadora / 02 El llegat / 03 L'evolució)
- Cita destacada
- Timeline horizontal (fites por año: 1987, 1997, 2010, 2015, 2020, 2025)

#### Missió i Valors
- Intro editorial ("El que ens mou cada dia")
- 5 valores (cards con número, icono, título, texto)

#### Equip
- Intro con número grande "+65"
- Patronat (4 cards con foto placeholder "Pendent de foto" + nombre + cargo)
- Equip Professional (4 cards con áreas: Direcció, Atenció directa, Serveis mèdics, Cuidadors i educadors)

#### Transparència
- Intro
- Dades legals (tabla)
- Acreditacions (lista)
- Sidebar de documentos descargables

#### Serveis (índice)
- Header con eyebrow + título "Els nostres serveis"
- Descripción
- **Tabs sticky apilables** con los 6 servicios (01-06) — cada uno con imagen alternada izquierda/derecha, número, título, descripción y botón "Més informació"

#### Servei individual (Campus, Llars, SAD, Centres de Dia, Famílies+Laboral, Recerca)
Estructura común:
- Hero con imagen
- Intro editorial (eyebrow + h2 + lede + 1-2 párrafos)
- Cita destacada (banda negra)
- Bloque "Què oferim?" (6 cards numeradas con colores rotativos)
- Bloque "Per a qui?" (4 cards A/B/C/D)
- Stats "El servei en xifres" (banda negra)
- Botón CTA "Sol·licitar informació"

**Campus** tiene además: galería, tabla de detalles, FAQ, formulario. Es el patrón "Halston" más elaborado.

#### Col·labora
- Grid de 6 cards con colores (Donatiu, Voluntariat, Empreses, Llegats, Celebracions, Botiga)
- Bloque "Desgravació" (tabla explicativa)

#### Donar
- Columna izquierda: título + testimonio + descripción + qué se consigue con cada cantidad + "Otras formas"
- Columna derecha: formulario de donación (tipo, cantidad, datos, botón)

#### Actualitat (índice)
- Grid de noticias (imagen + fecha + título) — 3 por fila, todas las publicadas

#### Notícia individual
- Hero image
- Enlace "← Torna a Notícies"
- Meta (fecha · categoría · tiempo lectura)
- Título + raya de color
- Entradilla (lede)
- Cuerpo (párrafos, subtítulos h3 con barra vertical, cita destacada)
- Bloque "Notícies relacionades" (3 cards)

#### Contacte
- Formulario
- Mapa
- Datos de contacto (teléfono, email, dirección)

---

## 5. Campos editables (specification exhaustiva)

### 5.1 Campos globales (Customizer)

**Personalizador → Identidad del sitio**
- `logo` (imagen SVG)
- `logo_dark` (imagen SVG negativa)
- `favicon` (imagen)

**Personalizador → Contacte**
- `telefon` (text)
- `email` (email)
- `adreca_ca` (textarea)
- `adreca_es` (textarea)
- `horari_ca` (text)
- `horari_es` (text)

**Personalizador → Xarxes Socials**
- `facebook` (URL)
- `instagram` (URL)
- `linkedin` (URL)
- `youtube` (URL)

**Personalizador → Footer**
- `text_marca_ca` (textarea)
- `text_marca_es` (textarea)
- `copyright_ca` (text)
- `copyright_es` (text)
- `avis_legal_url` (URL)
- `privacitat_url` (URL)
- `cookies_url` (URL)

### 5.2 Campos por página (ACF Meta Box)

**Home**
- `hero_titol_ca` (text)
- `hero_titol_es` (text)
- `hero_subtitol_ca` (text)
- `hero_subtitol_es` (text)
- `hero_descripcio_ca` (wysiwyg)
- `hero_descripcio_es` (wysiwyg)
- `hero_imatge` (imagen)
- `hero_boto_serveis_ca` (text)
- `hero_boto_serveis_es` (text)
- `hero_boto_serveis_url` (URL)
- `hero_card_text_ca` (text)
- `hero_card_text_es` (text)
- `hero_card_boto_ca` (text)
- `hero_card_boto_es` (text)
- `hero_card_boto_url` (URL)
- `hero_bar_item_1_ca`, `hero_bar_item_1_es` (text) × 3 items
- `ticker_frase_ca` (textarea)
- `ticker_frase_es` (textarea)
- `impacte_eyebrow_ca`, `_es` (text)
- `impacte_titol_ca`, `_es` (text)
- `serveis_eyebrow_ca`, `_es` (text)
- `serveis_titol_ca`, `_es` (text)
- `serveis_descripcio_ca`, `_es` (wysiwyg)
- `historia_eyebrow_ca`, `_es` (text)
- `historia_titol_ca`, `_es` (text)
- `manifest_titol_ca`, `_es` (wysiwyg)
- `cta_donacio_titol_ca`, `_es` (text)
- `cta_donacio_text_ca`, `_es` (wysiwyg)
- `cta_donacio_boto_ca`, `_es` (text)
- `cta_donacio_url` (URL)
- `veus_eyebrow_ca`, `_es` (text)
- `veus_titol_ca`, `_es` (text)
- `actualitat_eyebrow_ca`, `_es` (text)
- `actualitat_titol_ca`, `_es` (text)
- `actualitat_descripcio_ca`, `_es` (text)
- `aliances_eyebrow_ca`, `_es` (text)
- `aliances_titol_ca`, `_es` (text)

**Qui Som**
- `intro_eyebrow_ca`, `_es` (text)
- `intro_titol_ca`, `_es` (text)
- `intro_lede_ca`, `_es` (textarea)
- `intro_text_ca`, `_es` (wysiwyg)
- `dades_titol_ca`, `_es` (text)
- `cita_ca`, `_es` (textarea)
- `historia_titol_ca`, `_es` (text)
- `historia_text_ca`, `_es` (wysiwyg)
- `mvv_titol_ca`, `_es` (text)
- `missio_text_ca`, `_es` (wysiwyg)
- `visio_text_ca`, `_es` (wysiwyg)
- `documents_titol_ca`, `_es` (text)
- `documents` (relación con CPT `document` o 3 campos de archivo)

_(...así para las 15 páginas fijas)_

### 5.3 Campos por Custom Post Type

**CPT `servei` (6 items)**
- `titol_ca`, `titol_es` — título nativo (con Polylang)
- `subtitol_ca`, `subtitol_es` (text)
- `slug` — slug de la URL
- `numero` (text) — "01", "02"...
- `color` (select: taronja, verd, blau, groc, rosa, coral)
- `imatge_hero` (imagen)
- `intro_eyebrow_ca`, `_es` (text)
- `intro_titol_ca`, `_es` (text)
- `intro_lede_ca`, `_es` (textarea)
- `intro_text_ca`, `_es` (wysiwyg)
- `cita_destacada_ca`, `_es` (textarea)
- `que_oferim_titol_ca`, `_es` (text)
- `que_oferim_cards` — relación con CPT `servei_card` filtrado por servei_padre
- `per_qui_titol_ca`, `_es` (text)
- `per_qui_cards` — igual
- `stats_titol_ca`, `_es` (text)
- `stat_1_numero`, `stat_1_label_ca`, `_es` × 3 items
- `cta_boto_ca`, `_es` (text)
- `cta_url` (URL)
- `descripcio_scroller_ca`, `_es` (textarea) — para la card en la home

**CPT `servei_card` (para "Què oferim" y "Per a qui")**
- Vincular al servei padre con custom taxonomy o meta field
- `numero` (text) — "01" o "A"
- `titol_ca`, `_es` (text)
- `text_ca`, `_es` (textarea)
- `color` (select)
- `tipus` (radio: `que_oferim` / `per_qui`)

**CPT `noticia` (usar `post` nativo)**
- Título (nativo) — con Polylang
- Contenido (nativo) — con Polylang
- Extracto (nativo)
- Imagen destacada (nativo)
- Categoría (nativo, con Polylang)
- Fecha (nativo)
- ACF adicionales:
  - `lede_ca`, `_es` (textarea) — entradilla
  - `cita_destacada_ca`, `_es` (textarea)
  - `cita_autor` (text)
  - `temps_lectura` (text) — "4 min"
  - `color` (select — color del acento)

**CPT `testimoni`**
- `text_ca`, `_es` (textarea)
- `autor` (text)
- `rol_ca`, `_es` (text)
- `color` (select)

**CPT `patronat_membre`**
- `nom` (text)
- `carrec_ca`, `_es` (text)
- `foto` (imagen — opcional; si vacío muestra placeholder)

**CPT `equip_area`**
- `titol_ca`, `_es` (text)
- `descripcio_ca`, `_es` (textarea)
- `rols` (textarea con un rol por línea)
- `color` (select)
- `numero` (text) — "01"

**CPT `estadistica`**
- `numero` (text) — "+39", "ISO", "+110.000"
- `label_ca`, `_es` (text)
- `color` (select)

**CPT `valor`**
- `numero` (text) — "01"
- `titol_ca`, `_es` (text)
- `descripcio_ca`, `_es` (textarea)
- `color` (select)

**CPT `fita` (timeline)**
- `any` (number)
- `entitat_ca`, `_es` (text)
- `titol_ca`, `_es` (text)
- `descripcio_ca`, `_es` (textarea)

**CPT `colaborador`**
- `nom` (text)
- `logo` (imagen)
- `url` (URL — opcional)

---

## 6. Templates PHP a crear

El desarrollador debe crear estos templates:

```
avemaria-theme-v2/
├── style.css                     # Info del theme + reset
├── functions.php                 # Setup, enqueue, CPTs, ACF fields, Polylang
├── header.php                    # Header + menú + selector idioma
├── footer.php                    # Footer completo
├── index.php                     # Fallback
├── front-page.php                # Home
├── page.php                      # Página genérica
├── single.php                    # Noticia individual
├── archive.php                   # Índice de noticias (actualitat)
├── search.php                    # Buscador
├── 404.php                       # Error
│
├── template-parts/
│   ├── hero-home.php
│   ├── ticker.php
│   ├── impacte.php
│   ├── serveis-scroller.php
│   ├── historia-preview.php
│   ├── manifest.php
│   ├── cta-donacio.php
│   ├── testimonis-carousel.php
│   ├── noticies-preview.php
│   └── colaboradors-marquee.php
│
├── page-templates/
│   ├── page-quisom.php
│   ├── page-historia.php
│   ├── page-missio.php
│   ├── page-equip.php
│   ├── page-transparencia.php
│   ├── page-serveis.php
│   ├── page-collabora.php
│   ├── page-donar.php
│   ├── page-voluntariat.php
│   ├── page-empreses.php
│   ├── page-llegats.php
│   ├── page-art.php
│   ├── page-botiga.php
│   └── page-contacte.php
│
├── single-servei.php             # Detalle servicio
├── archive-servei.php            # (opcional, no se usa)
│
├── inc/
│   ├── setup.php                 # Setup del theme
│   ├── enqueue.php               # CSS y JS
│   ├── cpt.php                   # Custom Post Types
│   ├── acf-fields.php            # Definición de campos ACF (con acf_add_local_field_group)
│   ├── polylang.php              # Registro strings + helpers
│   └── customizer.php            # Customizer options
│
└── assets/
    ├── css/
    │   └── style.css             # Copia adaptada del CSS actual
    ├── js/
    │   ├── main.js               # Menú, revealer, showPage
    │   ├── scroller-serveis.js   # Carrusel home
    │   ├── testimonis.js         # Carrusel testimonios
    │   └── timeline.js           # Timeline horizontal
    └── fonts/                    # Si se auto-hostean (opcional, mejor Google Fonts)
```

### Regla clave para las templates

**Copiar la estructura HTML del archivo `web/maqueta-avemaria.html`** sección por sección, y **sustituir cada texto/imagen por la llamada PHP a ACF/Polylang correspondiente**.

Ejemplo:
```php
<!-- Antes (maqueta) -->
<h2><span data-lang-ca>Una fundació compromesa…</span>
    <span data-lang-es>Una fundación comprometida…</span></h2>

<!-- Después (WP) -->
<h2><?php echo esc_html( get_field( 'intro_titol_' . pll_current_language() ) ); ?></h2>
```

---

## 7. Migración de contenido

### 7.1 Contenido a migrar de la maqueta actual

El desarrollador debe **crear todos los posts/páginas iniciales** con el contenido exacto de la maqueta HTML (tanto CA como ES) usando:

- **Opción A (recomendada):** exportar un `.xml` WXR con todo el contenido pre-cargado. Al importar el XML en el WP nuevo, todo aparece ya con textos e imágenes.
- **Opción B:** script PHP de seed (`inc/seed-content.php`) que se ejecute una vez al activar el theme.

### 7.2 Imágenes

Están en `web/imatges/`, en 5 carpetas:
- `fachada/` (5 fotos)
- `institucional/` (4)
- `salas/` (3)
- `terapies/` (7)
- `cava/` (2)
- 5 más sueltas

Total: **26 imágenes JPG**. Se suben a la Media Library de WordPress y se referencian desde los campos ACF.

Además: el logo (SVG) y los avatares vacíos (placeholders "Pendent de foto" para el Patronat).

---

## 8. Comportamiento del frontend

### 8.1 SPA vs. multipágina
La maqueta actual funciona como **SPA con un único HTML** y JS que muestra/oculta divs.
En WordPress, cada página será una **URL real** (`/quisom/`, `/serveis/campus/`, etc.) que carga un template PHP.

Se debe:
- Configurar **Ajustes → Enlaces permanentes** en modo `/%postname%/`.
- Registrar CPT `servei` con slug `serveis/%slug%` para que las URLs sean `/serveis/campus/`.

### 8.2 Efectos y animaciones a mantener

- **Reveal on scroll** (`data-reveal` con IntersectionObserver).
- **Parallax con GSAP + ScrollTrigger** en imágenes.
- **Menú del header** con submenús desplegables (hover).
- **Carrusel infinito de testimonios** con peek lateral.
- **Timeline horizontal** con drag + wheel.
- **Ticker infinito** con animación CSS.
- **Carrusel de servicios** en la home con flechas.
- **Tabs sticky apilables** en la página Serveis.

### 8.3 Bilingüe URL

Polylang permite dos configuraciones:
- **Directorio:** `/ca/quisom/` y `/es/quisom/` (recomendado, mejor SEO).
- **Parámetro:** `/quisom/?lang=es`.

Usar la de directorios.

---

## 9. Testing / QA checklist

### 9.1 Antes de entregar

- [ ] Instalación del theme desde .zip sin errores en un WP nuevo.
- [ ] Los 3 plugins requeridos (Polylang + ACF) están **listados como dependencias** con aviso si faltan.
- [ ] Al importar el XML de contenido, aparecen todas las páginas + posts + CPTs con imágenes.
- [ ] Selector CA/ES funciona en todas las páginas.
- [ ] Al cambiar un texto en el panel, se actualiza en la web.
- [ ] Al cambiar una imagen, se actualiza.
- [ ] Los 6 servicios renderizan bien.
- [ ] Las 6 noticias renderizan bien.
- [ ] Los formularios de Contacte y Donar envían (o al menos validan).
- [ ] El sitio pasa Lighthouse con Performance > 85, Accesibilidad > 90, SEO > 90.
- [ ] Responsive: OK en móvil (375px), tablet (768px), desktop (1400px).

### 9.2 Documentación entregable

- [ ] `README.md` del theme con instrucciones de instalación.
- [ ] `wp-import-guide.md` — cómo importar el contenido inicial.
- [ ] `editor-manual.md` — manual para la Fundació con capturas del panel: cómo editar textos, cambiar imágenes, añadir noticias.
- [ ] Vídeo Loom de 5-10 min mostrando el panel al cliente.

---

## 10. Cronograma sugerido

Para desarrollador full-time:

| Semana | Tarea |
|---|---|
| 1 | Setup theme base, Custom Post Types, ACF fields, Polylang config |
| 2 | Templates Home + Qui Som + Història + Missió + Equip + Transparència |
| 3 | Templates Serveis (índice + 6 detalles) |
| 4 | Templates Col·labora + subpáginas (Donar, Voluntariat, Empreses, Llegats, Art, Botiga) |
| 5 | Templates Actualitat + Notícies individuales + Contacte + refinamiento responsive |
| 6 | Migración de contenido (XML + imágenes) + QA + documentación + entrega |

**Total: ~6 semanas / ~150-200 horas** para un desarrollador senior con experiencia en ACF + Polylang.

---

## 11. Presupuesto de referencia

Este dossier es específico y detallado precisamente para que el desarrollador pueda **presupuestar con precisión sin sorpresas**.

Rangos orientativos (España, 2026):
- **Freelance senior:** 4.500 € - 7.500 €
- **Agencia pequeña:** 7.000 € - 12.000 €
- **Agencia grande:** 15.000 € - 25.000 €

---

## 12. Contactos y accesos

| Rol | Persona | Contacto |
|---|---|---|
| Cliente final | Fundació Ave Maria | Sitges — 938 94 86 46 |
| Diseño (Zoopa) | (a completar) | |
| Contenido / textos | (a completar) | |
| Hosting / dominio | (a completar) | |
| Cuenta GitHub del proyecto | ZOOPA-Smart-Agency | ave-maria |

---

## 13. Anexos

### Anexo A — Repositorio con toda la maqueta
- **GitHub:** https://github.com/ZOOPA-Smart-Agency/ave-maria
- **Web publicada:** https://zoopa-smart-agency.github.io/ave-maria/
- **Rama principal:** `main`

### Anexo B — Archivos de referencia dentro del repo
- `web/maqueta-avemaria.html` — HTML/CSS/JS completo aprobado (fuente de verdad)
- `web/wireframe-avemaria.html` — wireframe con contenido base
- `web/BRANDBOOK_MARCA/` — logos SVG
- `web/imatges/` — banco de imágenes (26 fotos)
- `brand-guidelines-ave-maria-fundacio.pdf` — brand book completo
- `avemaria-theme/` — theme WordPress **inicial** (desactualizado, sirve como referencia parcial)

### Anexo C — Plugins WordPress obligatorios

| Plugin | Versión mínima | Uso |
|---|---|---|
| Polylang | 3.5+ | Bilingüe CA/ES |
| Advanced Custom Fields | 6.0+ (gratis) | Campos personalizados |

### Anexo D — Plugins WordPress recomendados (opcional)

| Plugin | Uso |
|---|---|
| Contact Form 7 o WPForms | Formularios de Contacte y Donació |
| Yoast SEO | SEO on-page |
| WP Rocket / W3 Total Cache | Caché |
| Wordfence | Seguridad |
| UpdraftPlus | Backups |

---

## 14. Preguntas clave para el desarrollador antes de arrancar

1. ¿Prefieres ACF Free (como está especificado) o Meta Box gratis que sí tiene repeaters?
2. ¿Habrá alguna funcionalidad de pago (pasarela real en Donar) o solo formulario?
3. ¿Hosting de destino conocido? (afecta a caché y despliegue)
4. ¿Hay dominio ya reservado?
5. ¿Se quiere pasarela con Stripe / TPV bancario / Bizum?
6. ¿Newsletter integrada (Mailchimp / MailerLite) o no?
7. ¿Analítica: Google Analytics 4 / Matomo / cookies con banner?

---

**Documento generado por Zoopa · v1.0 · 2026-07-01**

_Este documento es el brief definitivo para el encargo. Cualquier variación debe ser acordada por escrito antes de empezar._
