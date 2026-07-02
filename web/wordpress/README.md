# Fundació Ave Maria — Web (WordPress)

Web bilingüe (CA/ES) de la Fundació Ave Maria de Sitges.

Tema WordPress custom (`avemaria`) que reproduce la maqueta HTML aprobada, con backoffice completo para editar textos e imágenes en catalán y castellano sin tocar código.

---

## 🛠️ Stack técnico

- **WordPress** (latest) vía Docker
- **MySQL 8** (base de datos)
- **phpMyAdmin** (acceso a la BD en local)
- **OrbStack** o **Docker Desktop** (motor de contenedores)
- Tema custom en `wp-content/themes/avemaria/`
- **Polylang** (bilingüe CA/ES)
- **ACF** — Advanced Custom Fields versión gratuita

Sin build tools ni node_modules — CSS y JS vainilla.

---

## 🚀 Arranque en local

### Prerrequisitos

- [OrbStack](https://orbstack.dev/) (recomendado en macOS) o Docker Desktop
- `git` y un editor (VS Code / Cursor)

### Pasos

```bash
# 1. Situarse en la carpeta wordpress
cd "web/wordpress"

# 2. Arrancar los servicios Docker
docker compose up -d

# 3. Esperar ~30s a que MySQL inicialice la primera vez

# 4. Abrir en el navegador
open http://localhost:8090
```

### Primera vez: configurar WordPress

Si es la primera vez que arrancas el stack (BD vacía), WordPress te pedirá el asistente de instalación. Para configurarlo automáticamente:

```bash
# Instalar WordPress con credenciales admin/admin
docker compose exec wordpress bash -c "
wp core install \
  --url=http://localhost:8090 \
  --title='Fundació Ave Maria – Local' \
  --admin_user=admin \
  --admin_password=admin \
  --admin_email=admin@avemaria.local \
  --skip-email \
  --allow-root
"

# Activar el tema Ave Maria
docker compose exec wordpress wp theme activate avemaria --allow-root

# Permalinks amigables
docker compose exec wordpress wp rewrite structure '/%postname%/' --allow-root
docker compose exec wordpress wp rewrite flush --allow-root

# Instalar y activar plugins requeridos
docker compose exec wordpress wp plugin install polylang --activate --allow-root
docker compose exec wordpress wp plugin install advanced-custom-fields --activate --allow-root
```

### URLs locales

| Servicio | URL | Credenciales |
|---|---|---|
| **Front** | http://localhost:8090 | — |
| **Admin** | http://localhost:8090/wp-admin | `admin` / `admin` |
| **phpMyAdmin** | http://localhost:8091 | `avemariauser` / `avemariapass` |
| **MySQL** | `localhost:3308` | `avemariauser` / `avemariapass` · BD `avemaria` |

### Parar / reiniciar

```bash
docker compose stop        # parar sin eliminar
docker compose start       # arrancar de nuevo
docker compose down        # parar y eliminar contenedores
docker compose down -v     # ⚠️ además borra la BD (volumen db_data)
```

---

## 📁 Estructura del theme

```
wp-content/themes/avemaria/
├── style.css                 # Cabecera del theme + reset
├── functions.php             # Bootstrap
├── header.php                # <head> común
├── footer.php                # cierre
├── front-page.php            # Home (sirve la maqueta SPA)
├── page.php                  # Fallback
├── index.php                 # Fallback
│
├── inc/
│   ├── theme-setup.php       # supports, thumbnails, menús
│   ├── enqueue.php           # CSS y JS
│   ├── custom-post-types.php # CPTs Ave Maria
│   ├── acf-fields.php        # Campos ACF de todos los CPTs
│   ├── polylang.php          # Registro de strings + helpers
│   ├── helpers.php           # Utilidades comunes
│   ├── import-content.php    # Seed inicial
│   └── mockup-body.html      # Body de la maqueta HTML (base)
│
├── assets/
│   ├── css/main.css          # CSS extraído de la maqueta
│   ├── js/main.js            # JS extraído de la maqueta
│   ├── img/imatges/          # 26 fotos B/N del proyecto
│   └── img/BRANDBOOK_MARCA/  # Logos SVG
│
└── template-parts/           # Fragmentos (se irán rellenando)
```

---

## 🌐 Bilingüe (Polylang)

Al activar Polylang aparece un wizard: elige **Català** como idioma principal y añade **Español** como segundo.

Configuración recomendada:
- URL: `/ca/quisom/` y `/es/quisom/` (directorio por idioma)
- Selector CA/ES en el header (ya renderizado por la maqueta)

---

## 📝 Editar contenido

Desde el panel `wp-admin` puedes editar:

- **Páginas** — Qui Som, Història, Missió, Equip, Transparència, Contacte…
- **Serveis** (CPT) — los 6 servicios de la Fundació.
- **Testimonis** (CPT) — carrusel de "Veus".
- **Patronat** (CPT) — 4 miembros del órgano de govern.
- **Notícies** (posts nativos) — apartado Actualitat.
- **Estadístiques**, **Valors**, **Fites**, **Col·laboradors** — bloques repetibles.
- **Ajustes → Personalizador** — logo, contactos, footer, textos globales.

Todo doblado en catalán y castellano gracias a Polylang.

---

## 🎨 Referencia de diseño

- **Maqueta HTML aprobada:** [`../maqueta-avemaria.html`](../maqueta-avemaria.html)
- **Web pública (GitHub Pages):** https://zoopa-smart-agency.github.io/ave-maria/
- **Brand book PDF:** [`../../brand-guidelines-ave-maria-fundacio.pdf`](../../brand-guidelines-ave-maria-fundacio.pdf)

La paleta de marca (Taronja, Verd, Blau, Groc, Rosa, Coral) está definida en `assets/css/main.css` como variables CSS.

---

## 📦 Deploy

Al finalizar el desarrollo, el theme se empaqueta como `.zip`:

```bash
cd wp-content/themes
zip -r avemaria-theme.zip avemaria -x "*.DS_Store" "*/acf-json/*.tmp"
```

Y se sube al WordPress del cliente via **Aparença → Temes → Afegeix un tema nou → Penja**.

---

_Tema desarrollado por Zoopa para la Fundació Ave Maria de Sitges._
