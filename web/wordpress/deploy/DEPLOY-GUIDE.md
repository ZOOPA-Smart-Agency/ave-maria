# 🚀 Guía de Deploy — Fundació Ave Maria (WordPress)

Paquete listo para desplegar la web de la **Fundació Ave Maria** en un servidor WordPress. Sigue los pasos y en ~30 minutos estará online, con **panel visual de edición** para que la Fundació pueda cambiar textos, imágenes y bloques sin tocar código.

---

## 📦 Contenido del paquete

| Archivo | Qué es |
|---|---|
| `avemaria-theme.zip` (~65 MB) | Theme WordPress custom con el diseño completo, editor visual, gestor de bloques y todos los assets (imágenes, CSS, JS). |
| `avemaria-database.sql` (~900 KB) | Dump completo de la BD del entorno de desarrollo (opcional, si quieres partir con contenido ya poblado). |
| `DEPLOY-GUIDE.md` | Este documento. |
| `README.md` | Inicio rápido. |

---

## ✅ Requisitos del hosting

- **WordPress** 6.0+ (última recomendada)
- **PHP** 8.0+
- **MySQL** 5.7+ / MariaDB 10.3+
- **Memoria PHP**: 256 MB (`memory_limit`)
- **Upload max**: 100 MB (`upload_max_filesize` y `post_max_size`)
- **HTTPS** activo en producción
- Acceso al panel WP admin (usuario administrador)

Compatible con cualquier hosting WP: SiteGround, Raiola, WPEngine, DigitalOcean, hosting cPanel, etc.

---

## 🎯 Opción A — Deploy limpio (recomendado)

Empiezas con un WordPress vacío. El contenido lo pobla la Fundació desde el panel.

### 1. Instalar WordPress en el servidor
Instala WordPress con el asistente estándar de tu hosting. Configura:
- Dominio: `www.avemariafundacio.org` (o el que sea)
- Usuario admin, email, contraseña fuerte
- Idioma inicial: **Catalán**

### 2. Configurar enlaces permanentes
Panel WP → **Ajustes → Enlaces permanentes** → selecciona **Nombre de la entrada** (`/%postname%/`).

### 3. Instalar el theme
1. Panel WP → **Aparença → Temes → Afegeix un tema nou → Penja el tema**.
2. Sube `avemaria-theme.zip`.
3. Clic en **Activa**.

### 4. Instalar los plugins requeridos
Panel WP → **Plugins → Afegeix un nou** y busca/instala/activa:

1. **Polylang** (autor: WP SYNTEX) — bilingüe CA/ES.
2. **Advanced Custom Fields** (autor: WP Engine) — campos personalizados.

### 5. Configurar Polylang
Al activar Polylang aparece un asistente:
- Idioma principal: **Català**
- Añadir: **Español**
- Sigue hasta el final.

### 6. Verificar el frontend
Abre el dominio en el navegador. Debe verse igual que la web de referencia:
https://zoopa-smart-agency.github.io/ave-maria/

### 7. Presentar el panel a la Fundació
En `wp-admin`, menú lateral izquierdo: **Editor Ave Maria**. Los 6 submenús:

| Submenú | Qué permite |
|---|---|
| 👁️ **Editor Visual** | Vista de cada página con clic-para-editar directamente sobre textos e imágenes. |
| 📝 Textos bilingües | Todos los pares CA/ES agrupados por sección (265 textos). |
| 🌍 Traduccions ES | Textos monolingües con traducción opcional al castellano (747 textos). |
| 🖼️ Imatges | Todas las imágenes de la web (81) con preview y botón "Canviar" que abre la Media Library. |
| 📦 Blocs dinàmics | Añadir/eliminar/reordenar serveis, notícies y testimonis. |
| ↩️ Restaurar tot | Botón de emergencia para volver al estado original de la maqueta. |

---

## 🎯 Opción B — Deploy con contenido de dev

Si quieres partir del contenido ya poblado durante el desarrollo:

### Pasos adicionales (después de la Opción A)

1. Crea una BD vacía en el hosting (ej. `avemaria_prod` con su usuario y contraseña).
2. Edita `wp-config.php` con los datos de la BD del hosting (`DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST`).
3. Importa `avemaria-database.sql`:
   - Via phpMyAdmin: **Importar → Elegir archivo → avemaria-database.sql**.
   - O CLI: `mysql -u USER -p DB_NAME < avemaria-database.sql`.
4. Reemplaza la URL de dev por la de producción:
   - **WP-CLI (recomendado, no rompe serializaciones):**
     ```bash
     wp search-replace 'http://localhost:8090' 'https://TU-DOMINIO.com' --all-tables --skip-columns=guid
     ```
   - **Plugin Better Search Replace** (interfaz gráfica).
   - **phpMyAdmin SQL** (solo para siteurl/home):
     ```sql
     UPDATE wp_options SET option_value='https://TU-DOMINIO.com' WHERE option_name IN ('siteurl','home');
     ```
5. Vacía caché de permalinks: **Ajustes → Enlaces permanentes → Guardar cambios**.

---

## 👁️ Panel Editor Visual — cómo funciona

Este es el corazón del backoffice. Al entrar en `Editor Ave Maria → 👁️ Editor Visual`:

- **Sidebar oscuro a la izquierda** con:
  - Selector de idioma vista (CA / ES)
  - Lista de las 26 páginas: Inici, Qui Som, Història, Missió, Equip, Transparència, Serveis, cada uno de los 6 servicios, Col·labora, Donar, Art, Botiga, Actualitat, las 6 notícies y Contacte.
- **Iframe con la página real** donde el editor ve exactamente cómo se verá el usuario final.

### Cómo editar textos
1. Pasa el ratón sobre un texto → sale un contorno naranja discontinuo.
2. Clica → se vuelve editable (fondo amarillo, borde azul).
3. Escribe.
4. Enter o clic fuera → se guarda automáticamente (toast verde "✅ Guardat").

### Cómo editar imágenes
1. Pasa el ratón sobre una imagen → aparece banner naranja "📷 Clic per canviar imatge".
2. Clic → abre la Media Library de WordPress.
3. Sube/elige otra imagen y confirma.
4. La imagen se cambia y el iframe se refresca automáticamente.

### Cómo cambiar de idioma
- Selector "🏴 CA / 🇪🇸 ES" en la parte alta del sidebar → cambia lo que muestra el iframe.
- Editar en modo CA guarda el texto catalán, en modo ES guarda el castellano.

---

## 📦 Panel Blocs dinàmics

Permite estructura, no solo textos. En `Editor Ave Maria → 📦 Blocs dinàmics`:

- **Serveis (home):** los 6 servicios del carrusel de portada. Añadir/eliminar/reordenar. Cada uno tiene número, título, descripción, imagen y página destino.
- **Notícies (home):** las 3 noticias destacadas. Añadir/eliminar/reordenar.
- **Testimonis:** el carrusel de "Veus". Cada testimonio con texto, autor, rol y color de marca.

Todos los bloques se guardan en la BD (opciones `avemaria_blocks_*`) y se renderizan dinámicamente en el frontend.

---

## 🔒 Seguridad — Pasos post-deploy imprescindibles

- [ ] Cambiar la contraseña del usuario `admin` por una fuerte.
- [ ] Cambiar el prefijo de tablas si vienes del dump SQL: por defecto `wp_`, cámbialo a algo como `avm_`.
- [ ] Instalar y configurar un plugin de seguridad: **Wordfence** o **Solid Security**.
- [ ] Instalar plugin de backups: **UpdraftPlus**.
- [ ] Instalar plugin de caché: **WP Rocket** o **W3 Total Cache**.
- [ ] Configurar HTTPS y forzar redirección `http://` → `https://`.
- [ ] Actualizar núcleo, plugins y theme a última versión.
- [ ] Ocultar la versión de WordPress (via plugin de seguridad).
- [ ] Deshabilitar el editor de archivos: en `wp-config.php` añadir `define('DISALLOW_FILE_EDIT', true);`.
- [ ] Si vas a producción, cambia el email admin a uno real y verificado.

---

## 📁 Estructura del theme

```
/wp-content/themes/avemaria/
├── style.css                    # Cabecera del theme + reset CSS
├── functions.php                # Bootstrap
├── header.php                   # <head> común
├── footer.php                   # Cierre común
├── front-page.php               # Home (sirve maqueta + editores)
├── page.php, index.php          # Fallbacks
│
├── inc/
│   ├── theme-setup.php          # Supports, thumbnails, menús
│   ├── enqueue.php              # CSS y JS
│   ├── custom-post-types.php    # 8 CPTs (serveis, testimoni, patronat…)
│   ├── acf-fields/              # Grupos de campos ACF
│   ├── polylang.php             # Bilingüe CA/ES
│   ├── helpers.php              # Utilidades
│   ├── text-editor.php          # 🔥 Editor de textos (bilingües + monolingües + reset)
│   ├── image-editor.php         # 🔥 Editor de imágenes
│   ├── blocks-editor.php        # 🔥 Gestor de bloques dinámicos
│   ├── visual-editor.php        # 🔥 Editor Visual (iframe + edición inline)
│   ├── mockup-body.html         # HTML de la maqueta (con placeholders)
│   ├── texts-defaults.json      # 265 pares CA/ES por defecto
│   ├── texts-mono-defaults.json # 747 textos monolingües
│   ├── images-defaults.json     # 81 imágenes por defecto
│   └── blocks-defaults.json     # Serveis / notícies / testimonis por defecto
│
└── assets/
    ├── css/main.css             # CSS extraído de la maqueta
    ├── js/main.js               # JS extraído (menú, revealer, carruseles, GSAP)
    ├── img/imatges/             # 26 fotos del proyecto (fachada, salas, terapies…)
    └── img/BRANDBOOK_MARCA/     # Logos SVG
```

---

## 🌐 Bilingüe (Polylang)

Configuración recomendada:
- **Idioma principal:** Català
- **Idioma secundario:** Español (código `es`)
- **URL:** modo `directorio` → `/ca/...` y `/es/...`

El selector CA/ES del header (integrado en la maqueta) cambia el idioma sin recargar. Los textos editables desde el panel se aplican al idioma correspondiente.

---

## 🔗 Enlaces útiles

- **Repositorio del proyecto:** https://github.com/ZOOPA-Smart-Agency/ave-maria
- **Web de referencia (maqueta estática):** https://zoopa-smart-agency.github.io/ave-maria/
- **Brief técnico completo:** [`BRIEF_WORDPRESS.md`](https://github.com/ZOOPA-Smart-Agency/ave-maria/blob/main/BRIEF_WORDPRESS.md)

---

## ❓ Soporte

- **Zoopa Smart Agency** — https://zoopa.es
- **Cliente:** Fundació Ave Maria de Sitges — 938 94 86 46

---

_Actualizado 2026-07-02 — Incluye Editor Visual + Gestor de Bloques dinámicos._
