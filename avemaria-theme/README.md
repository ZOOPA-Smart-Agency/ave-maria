# Tema WordPress — Fundació Ave Maria

Tema a mida amb el disseny minimalista (blanc + escala de grisos) de la web de la Fundació Ave Maria.
El contingut de la portada s'edita des del panell de WordPress, sense tocar codi.

---

## 1. Requisits

- WordPress 6.0 o superior.
- PHP 7.4 o superior.
- Permís d'administrador al WordPress.

---

## 2. Instal·lació (5 minuts)

> Si tens la carpeta `avemaria-theme`, primer comprimeix-la en un fitxer **.zip**
> (clic dret sobre la carpeta → *Comprimir*). WordPress instal·la temes en format .zip.
> *(Si ja t'han passat `avemaria-theme.zip`, salta aquest pas.)*

1. Entra al panell de WordPress: `elteudomini.com/wp-admin`
2. Ves a **Aparença → Temes → Afegeix un tema nou → Penja el tema**.
3. Tria el fitxer `avemaria-theme.zip` i fes clic a **Instal·la ara**.
4. Quan acabi, fes clic a **Activa**.

---

## 3. Configuració inicial (recomanada)

### 3.1. Posar la portada de disseny com a pàgina d'inici
1. Ves a **Pàgines → Afegeix una pàgina nova**, posa-li de títol **Inici** i publica-la (buida, sense contingut).
2. Crea una altra pàgina anomenada **Actualitat** (també buida) — servirà per llistar les notícies.
3. Ves a **Configuració → Lectura**:
   - *La teva pàgina d'inici mostra* → **Una pàgina estàtica**.
   - *Pàgina d'inici* → **Inici**
   - *Pàgina d'entrades* → **Actualitat**
   - Desa els canvis.

> El tema detecta la pàgina d'inici i hi pinta automàticament tot el disseny de la portada.

### 3.2. Logo i nom
- **Aparença → Personalitza → Identitat del lloc**: puja el logo i posa el nom.
- Si no puges cap logo, surt el logotip de marca per defecte.

### 3.3. Menús
- **Aparença → Menús**: crea un menú, afegeix-hi les pàgines i assigna'l a la ubicació **Menú principal (capçalera)**.
- També pots assignar menús a les columnes del peu (*Serveis*, *Col·labora*) i als *Enllaços legals*.

---

## 4. Editar el contingut de la portada

Tot es fa des de **Aparença → Personalitza → "Inici · Ave Maria"**.
Hi trobaràs una secció per a cada bloc de la portada:

| Secció del Personalitza | Què controla |
|---|---|
| **Capçalera** | El botó verd de dalt (text i enllaç) |
| **Hero** | Etiqueta, títol gran, paràgraf, 2 botons, imatge principal i les 4 dades |
| **Impacte** | Títol i les 6 xifres amb el seu text |
| **Serveis** | Títol i els 6 serveis (número, títol, text, enllaç i foto) |
| **Història i trajectòria** | Les 3 fites (any, entitat, títol i text) |
| **Cita** | La frase, el nom, el càrrec i la foto |
| **Crida a donar** | Títol, text, botó i nota |
| **Testimonis** | Els 3 testimonis |
| **Notícies** | Títol, descripció i quantes notícies es mostren |
| **Peu de pàgina** | Text de marca, títols de columnes, contacte i copyright |

A mesura que edites, ho veus en directe a la dreta. Quan estiguis, fes clic a **Publica**.

> **Consell sobre xifres:** escriu-les tal qual, per exemple `+39`, `+110.000` o `ISO`.
> Si comencen amb `+`, el signe surt en color verd automàticament.

---

## 5. Les notícies (Actualitat)

Les notícies són **entrades normals** de WordPress:

1. **Entrades → Afegeix una entrada nova**.
2. Escriu el títol i el contingut.
3. A la dreta, posa una **Imatge destacada** (serà la foto de la targeta).
4. Publica.

Les últimes notícies apareixen soles a la portada i al llistat d'Actualitat.

---

## 6. Les fotos

- Mentre no posis una imatge, surt un **rectangle gris** amb una etiqueta (és normal, marca on anirà la foto).
- Quan puges una imatge (al hero, als serveis, a la cita o com a imatge destacada d'una notícia), substitueix el gris automàticament.
- Mida recomanada de les fotos: **1200 px d'ample** o més.

---

## 7. Notes

- El selector d'idioma CA/ES de la capçalera és visual. Per a un web bilingüe de veritat caldria un connector com **Polylang** o **WPML** (t'ho podem muntar a part).
- Les pàgines internes (Qui Som, Serveis, Donar, Contacte…) es creen com a pàgines normals i fan servir la plantilla neta del tema. Si les vols amb seccions de disseny com la portada, es poden afegir plantilles a mida.

---

*Tema creat per Zoopa per a la Fundació Ave Maria · v1.0.0*
