# Eliashof Theme

Individuelles WordPress-Full-Site-Editing-Theme für die Grundschule im Eliashof. Das Theme bündelt Layout, Block-Patterns, redaktionelle Editor-Erweiterungen und die Frontend-Interaktionen der Website.

## Voraussetzungen

- WordPress 6.4 oder neuer
- PHP 7.4 oder neuer
- Plugin `fm-admin-tweaks` ab Version 1.6.3 für die dynamischen SPB-Angebote

## Zentrale Bestandteile

- `theme.json`: globale Farben, Typografie, Abstände und Block-Vorgaben
- `style.css`: Theme- und Komponentenstile einschließlich responsiver Varianten
- `functions.php`: Asset-Registrierung, Customizer, REST-Endpunkte, Drawer-Integration, Block-Stile und Pattern-Kategorien
- `patterns/`: modulare Gutenberg-Patterns, nach Seitenbereichen kategorisiert
- `assets/js/`: Navigation, Karussells, SPB-Filter/Tabs, Drawer und Editor-Erweiterungen
- `assets/images/`: Illustrationen, Masken und dekorative Formen

## Redaktion im Block-Editor

Die eigenen Patterns erscheinen in den Kategorien Startseite, Unsere Schule, Eltern, Förderverein, SPB/Hort, Aktuelles und Global. Abschnitts-Patterns besitzen einen eindeutigen HTML-Anker; Layouts mit `templateLock: contentOnly` erlauben Inhaltsänderungen, schützen aber die Struktur.

Die Editor-Erweiterung `assets/js/editor-section-colors.js` ergänzt:

- vordefinierte Eliashof-Theme-Farben für unterstützte Blöcke,
- eine separate Formfarbsteuerung für die SPB-Werteformen,
- Textbreite und Ausrichtung für Einleitungstexte im SPB-Header,
- stabile CSS-Klassen für redaktionelle SPB-Tagesablauf- und Anmeldegruppen.

Für Montserrat stehen die Block-Stile `Montserrat Light`, `Montserrat Regular` und `Montserrat Semibold` bereit.

## SPB/Hort

Die SPB-Seite besteht aus modularen Patterns für Hero, Vorstellung, Tagesablauf, Anmeldung, Angebote, Werte und Höhepunkte. Die Angebotsübersicht wird durch den dynamischen Block `fm/spb-offers` aus dem Plugin `fm-admin-tweaks` erzeugt.

Ausführliche Hinweise zu Datenmodell, Bedienung, Drawer, Patterns und Erweiterung stehen in [docs/spb-implementation.md](docs/spb-implementation.md).

## Interaktive Komponenten

- Burger-Navigation mit tastaturbedienbaren, auf- und zuklappbaren Untermenüs
- SPB-Angebotsfilter für Alle, AG und IG
- mobile Wochentags-Tabs mit Pfeiltastensteuerung und begrenztem horizontalem Scrollen
- interner Slide-out-Drawer für SPB-Angebote, Beiträge der Kategorie `intern` und Beiträge mit aktivierter Drawer-Option
- REST-basierter Drawer-Inhalt mit normalem Permalink als Fallback
- Customizer-Farbpalette und Live-Vorschau für den Drawer

## Wartung und Prüfung

Nach Änderungen sollten mindestens folgende Prüfungen laufen:

```bash
php -l functions.php
node --check assets/js/editor-section-colors.js
node --check assets/js/intern-drawer.js
node --check assets/js/navigation.js
node --check assets/js/spb-angebote.js
```

Zusätzlich im Browser prüfen:

1. Desktop-, Tablet- und Mobile-Layout.
2. Tastaturbedienung von Navigation, Filtern, Tabs und Drawer.
3. Öffnen und Schließen des Drawers per Link, Escape, Hintergrund und Zurück-Navigation.
4. Block-Editor ohne Validierungswarnungen.
5. Customizer-Live-Vorschau für Papierhintergrund und Drawer-Farbe.

## Weitere Dokumentation

- [Theme-Entwicklungsprotokoll](wp-gutenberg-fse-theme-implementation-guide.md)
- [Gutenberg-Validierungsleitfaden](wordpress-gutenberg-validation-fixes.md)
- [SPB-Implementierung](docs/spb-implementation.md)
