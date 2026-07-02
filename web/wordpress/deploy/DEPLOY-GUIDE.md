# 🚀 Guía de Deploy — Fundació Ave Maria (WordPress)

Este paquete contiene todo lo necesario para desplegar la web de la **Fundació Ave Maria** en un servidor con WordPress. Sigue los pasos en orden y en ~30 minutos estará online.

---

## 📦 Contenido del paquete

| Archivo | Qué es |
|---|---|
| `avemaria-theme.zip` (~65 MB) | Theme WordPress custom con todos los assets |
| `avemaria-database.sql` | Dump completo de la base de datos local (opcional, solo si quieres partir del contenido de dev) |
| `DEPLOY-GUIDE.md` | Este documento |

---

## ✅ Requisitos del hosting

- **WordPress** 6.0 o superior (última versión recomendada)
- **PHP** 8.0 o superior
- **MySQL** 5.7+ / MariaDB 10.3+
- **Memoria PHP** mínimo 256 MB (`memory_limit`)
- **Upload max** mínimo 100 MB (`upload_max_filesize` y `post_max_size`)
- **HTTPS** activo (obligatorio para producción)
- Acceso al panel WP admin

Cualquier hosting compatible con WP funciona: SiteGround, Raiola, WPEngine, DigitalOcean, hosting compartido tipo cPanel, etc.

---

## 🎯 Opción A — Deploy limpio (recomendado)

Empiezas con un WordPress vacío y añades solo el theme. El contenido lo introduce el cliente desde el panel.

### 1. Instalar WordPress en el servidor
Instala WordPress limpio con el asistente estándar de tu hosting. Configura:
- Dominio: `www.avemariafundacio.org` (o el que sea)
- Usuario admin, email, contraseña fuerte
- Idioma inicial: **Catalán**

### 2. Configurar enlaces permanentes
Ve a **Ajustes → Enlaces permanentes → Nombre de la entrada** (o `/%postname%/`).

### 3. Instalar el theme
1. Panel WP → **Aparença → Temes → Afegeix un tema nou → Penja el tema**.
2. Sube `avemaria-theme.zip`.
3. Clic en **Activa**.

### 4. Instalar los plugins requeridos
Panel WP → **Plugins → Afegeix un nou** y busca/instala/activa:

1. **Polylang** (autor: WP SYNTEX) — para bilingüe CA/ES.
2. **Advanced Custom Fields** (autor: WP Engine) — para los campos personalizados.

### 5. Configurar Polylang
- Al activar Polylang aparecerá un asistente.
- Idioma principal: **Català**.
- Añadir: **Español**.
- Sigue el asistente hasta el final.

### 6. Verificar
Abre la home del dominio y comprueba que carga la maqueta. Debería verse igual que la web pública de referencia:
https://zoopa-smart-agency.github.io/ave-maria/

---

## 🎯 Opción B — Deploy con contenido de dev

Si quieres partir del contenido de desarrollo (los CPTs, campos y páginas ya creados durante la fase de dev), importa el dump SQL.

### Pasos adicionales (después de la Opción A)

1. **Crear una base de datos vacía** en el hosting (por ejemplo `avemaria_prod` con usuario y contraseña propios).
2. **Editar `wp-config.php`** con los datos de la BD del hosting (`DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST`).
3. **Importar `avemaria-database.sql`** en la BD nueva:
   - Via phpMyAdmin: **Importar → Elegir archivo → avemaria-database.sql**.
   - O vía CLI: `mysql -u USER -p DB_NAME < avemaria-database.sql`.
4. **Reemplazar la URL de dev por la de producción** en la BD:
   - Vía phpMyAdmin SQL:
     ```sql
     UPDATE wp_options SET option_value='https://TU-DOMINIO.com' WHERE option_name IN ('siteurl','home');
     ```
   - O mucho mejor, con **WP-CLI** (evita romper serializaciones):
     ```bash
     wp search-replace 'http://localhost:8090' 'https://TU-DOMINIO.com' --all-tables --skip-columns=guid
     ```
   - O usa el plugin **Better Search Replace** (interfaz gráfica).
5. **Vaciar caché de permalinks**: Ajustes → Enlaces permanentes → Guardar cambios.

---

## 🔒 Seguridad — Pasos post-deploy imprescindibles

- [ ] Cambiar la contraseña del usuario `admin` por una fuerte.
- [ ] Cambiar el prefijo de tablas si venías del dump SQL: por defecto es `wp_`, cámbialo a algo como `avm_`.
- [ ] Instalar y configurar un plugin de seguridad: **Wordfence** o **Solid Security** (ex iThemes).
- [ ] Instalar plugin de backups: **UpdraftPlus**.
- [ ] Instalar plugin de caché: **WP Rocket** (recomendado) o **W3 Total Cache** (gratis).
- [ ] Configurar HTTPS y forzar redirección de `http://` a `https://`.
- [ ] Actualizar núcleo, plugins y theme a última versión.
- [ ] Ocultar la versión de WordPress (via plugin de seguridad).
- [ ] Deshabilitar el editor de archivos desde el panel: en `wp-config.php` añadir `define('DISALLOW_FILE_EDIT', true);`.

---

## 📁 Estructura del theme

Una vez instalado, el theme queda en:
```
/wp-content/themes/avemaria/
├── style.css               # Info del theme + reset CSS
├── functions.php           # Bootstrap del theme
├── header.php              # <head> común
├── footer.php              # Cierre común
├── front-page.php          # Home (sirve la maqueta SPA)
├── page.php + index.php    # Fallbacks
│
├── inc/
│   ├── theme-setup.php     # Supports, thumbnails, menús
│   ├── enqueue.php         # CSS y JS
│   ├── custom-post-types.php  # 8 CPTs Ave Maria
│   ├── acf-fields/         # Campos ACF definidos en PHP
│   ├── acf-fields.php      # Loader de los grupos ACF
│   ├── polylang.php        # Integración bilingüe
│   ├── helpers.php         # Utilidades
│   ├── admin-ui.php        # Personalización del panel
│   └── mockup-body.html    # HTML de la maqueta (se sirve tal cual desde front-page.php)
│
└── assets/
    ├── css/main.css        # CSS extraído de la maqueta
    ├── js/main.js          # JS extraído de la maqueta
    └── img/imatges/        # 26 fotos del proyecto
        BRANDBOOK_MARCA/    # Logos SVG
```

---

## 🌐 Bilingüe (Polylang)

Configuración recomendada:
- **Idioma principal:** Català
- **Idioma secundario:** Español (código `es`)
- **URL:** modo `directorio` → `/ca/...` y `/es/...`

Cada página, entrada y CPT tendrá su gemelo en el otro idioma. El selector CA/ES del header (ya integrado en la maqueta) cambia entre ellos.

---

## 📝 Custom Post Types disponibles

El theme registra 8 tipos de contenido en el panel:

| CPT | Uso | Cantidad esperada |
|---|---|---|
| **Serveis** | Los 6 servicios de la Fundació | 6 |
| **Testimonis** | Carrusel de "Veus" | 3-10 |
| **Patronat** | Miembros del órgano de gobierno | 4 |
| **Àrees Equip** | Áreas del equipo profesional | 4 |
| **Estadístiques** | Stats de "El nostre impacte" | 6 |
| **Valors** | Valores de la Fundació | 5 |
| **Fites** | Timeline de la Trajectòria | 8-15 |
| **Col·laboradors** | Logos de la marquesina | 10-20 |

---

## ⚠️ Nota importante sobre el frontend

**En la versión actual del theme**, `front-page.php` sirve la maqueta HTML tal cual (los textos están hardcodeados en `inc/mockup-body.html`).

Los CPTs y campos ACF están **registrados** en el panel — el editor puede crear/editar contenido — pero **aún no están conectados al frontend**. Esto requiere que un desarrollador WordPress:

1. Reemplace los textos hardcodeados de `inc/mockup-body.html` por llamadas dinámicas tipo:
   ```php
   <?php echo esc_html( get_field( 'hero_titol_' . pll_current_language() ) ); ?>
   ```
2. Convierta las secciones repetidas en loops sobre los CPTs correspondientes.
3. Cree templates individuales para cada Custom Post Type.

Este trabajo está estimado en **~150-200 horas** de desarrollo senior. Ver el brief completo:
📄 [`BRIEF_WORDPRESS.md`](../../BRIEF_WORDPRESS.md)

---

## 🔗 Enlaces útiles

- **Repositorio del proyecto:** https://github.com/ZOOPA-Smart-Agency/ave-maria
- **Web de referencia (maqueta estática):** https://zoopa-smart-agency.github.io/ave-maria/
- **Brief técnico completo:** [`BRIEF_WORDPRESS.md`](https://github.com/ZOOPA-Smart-Agency/ave-maria/blob/main/BRIEF_WORDPRESS.md)

---

## ❓ Soporte

Cualquier duda sobre este paquete, contactar con:
- **Zoopa** — Studio de diseño
- Cliente: **Fundació Ave Maria de Sitges** — 938 94 86 46

---

_Preparado por Zoopa el 2026-07-02_
