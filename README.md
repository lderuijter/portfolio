# Portfolio Website

Dit is mijn persoonlijke portfolio, waarin ik mijn werk en projecten laat zien.  
Hierin vind je zowel de frontend (hoe de website eruitziet) als de backend (hoe hij werkt).

---

## Bestandstructuur

### 📂 Mappen
- **assets/** – Alle statische bestanden zoals afbeeldingen, iconen, stylesheets en scripts.
- **src/** – Backend code en functies die de website laten draaien.
- **views/** – HTML/PHP templates die de pagina’s tonen (homepage, projecten, contact, etc.).

### 🗂 Bestanden
- **index.php** – Startpunt van de website; laadt de juiste pagina.
- **page.php** – Bepaalt welke view geladen wordt op basis van de URL.
- **config.php** – Zorgt ervoor dat je variabelen uit de .env kan halen. 
- **autoload.php** – Zorgt dat PHP-klassen automatisch geladen worden.
- **.htaccess** – Apache-configuratie voor mooie URL’s en andere serverregels.
- **.gitignore** – Bestanden die Git niet moet volgen.
- **projects.json** – Werkt voor het bijhouden van de projecten voor de gehele website (staat in gitignore).

---

## Waarom deze structuur?

- **Werkt net als een moderne framework te werk zou gaan.** – De website is wel zelf gemaakt. 
- **Volgt het MVC-patroon.** – Het patroon is geschikt voor een webapplicatie.
- **Is eenvoudig te beheren.** – Deze structuur is makkelijk te onderhouden.