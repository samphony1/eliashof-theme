# SPB/Hort – Implementierungs- und Redaktionsdokumentation

## Architektur

Die Funktion ist zwischen Plugin und Theme getrennt:

- `fm-admin-tweaks` (aktuell Version 1.9.2) verwaltet den Inhaltstyp `spb_angebot`, strukturierte Metadaten, Editor-Felder und den dynamischen Block `fm/spb-offers`.
- `eliashof-theme` stellt Patterns, Darstellung, Filter/Tabs, Drawer, REST-Ausgabe und responsive Styles bereit.

Damit bleiben Angebotsdaten unabhängig vom Theme erhalten, während das Theme ihre Darstellung steuert.

## Angebote redaktionell pflegen

Im WordPress-Backend steht der Menüpunkt **SPB-Angebote** zur Verfügung. Ein Angebot verwendet:

- Titel: Name des Angebots
- Inhalt: ausführliche Beschreibung und optionale Medien
- Beitragsbild: Bild für Einzelansicht und Drawer
- Angebotsart: `AG` oder `IG`
- Wochentag: Montag bis Freitag
- Ansprechpartner/in
- Raum
- Sortierreihenfolge: kleinere Zahlen erscheinen innerhalb eines Tages zuerst

Alle Felder sind über die REST-API im Gutenberg-Editor verfügbar und revisionsfähig. Beim ersten Start legt die Migration nur dann Beispieldaten an, wenn noch kein SPB-Angebot existiert.

## Dynamischer Angebotsblock

Der Block **SPB-Angebotsübersicht** (`fm/spb-offers`) speichert keine Angebotskopien im Seiteninhalt. Er lädt veröffentlichte Angebote serverseitig, gruppiert sie nach Wochentag und sortiert sie nach Sortiernummer und anschließend nach Titel.

Im Frontend bietet er:

- Filter für Alle, AG und IG,
- Desktop-Raster nach Wochentagen,
- mobile, ARIA-konforme Tabs,
- eindeutige Tab- und Panel-IDs bei mehreren Blockinstanzen,
- reguläre Permalinks als Fallback,
- Öffnen im Drawer, wenn das Theme aktiv ist.

Die Editor-Vorschau ist bewusst nicht interaktiv. Drawer und Filter werden auf der veröffentlichten Seite geprüft.

## Drawer

Der globale Drawer wird einmal im Footer ausgegeben. Er öffnet Inhalte für:

- Beiträge vom Typ `spb_angebot`,
- normale Beiträge der Kategorie `intern`,
- normale Beiträge mit aktivierter Option **Im Slide-out-Drawer öffnen**.

Links erhalten passende `data-intern-post-*`-Attribute. Der Inhalt wird über einen öffentlichen REST-Endpunkt geladen; unveröffentlichte Inhalte werden nicht ausgegeben. Für SPB-Angebote werden Angebotsart, Tag, Ansprechpartner/in und Raum oberhalb des Inhalts ergänzt.

Der Drawer unterstützt Fokusmanagement, Escape-Taste, Hintergrundklick, mobile Wischgeste und Browser-Historie. Ohne JavaScript führt der Link zur normalen Einzelansicht.

Die Hintergrundfarbe wird unter **Design > Customizer > Eliashof Darstellung** gewählt. Die Palette erlaubt eine direkte Vorschau mit Beispielinhalt.

## Verfügbare Patterns

| Pattern | Slug | Zweck |
| --- | --- | --- |
| Hero SPB | `eliashof/hero-spb` | Hero mit Beitragsbild, Illustration und Theme-Farbe |
| Über unseren SPB | `eliashof/section-ueber-unseren-spb` | kompakte Text-Bild-Einführung |
| SPB Angebote | `eliashof/section-spb-angebote` | Standard-Angebotsübersicht |
| SPB Angebote – Variante 2 | `eliashof/section-spb-angebote-v2` | 1080-Pixel-Variante |
| Unsere Angebote | `eliashof/section-spb-angebote-v3` | großzügige Sektion mit größerer Typografie |
| Was uns wichtig ist | `eliashof/section-spb-werte` | organische Werteformen |
| Werte – Karten | `eliashof/section-spb-werte-cards` | nummerierte Kartenvariante |
| Werte – Farbkarten | `eliashof/section-spb-werte-color-cards` | vollflächige Wortkarten |
| Höhepunkte | `eliashof/section-spb-hoehepunkte` | Beitragskarussell mit organischer Bildmaske |
| Höhepunkte – Bildrahmen | `eliashof/section-spb-hoehepunkte-rahmen` | Beitragskarussell mit klassischem Rahmen |

Die Höhepunkte-Patterns lesen veröffentlichte Beiträge aus der Kategorie `highlight`.

## Erweiterungspunkte

- `fm_at_spb_offer_days`: Filter zum Anpassen der angebotenen Wochentage.
- CSS-Variablen `--color-spb-ag`, `--color-spb-ag-text` und `--color-spb-ig`: SPB-Farbgebung.
- Theme-Mod `eliashof_drawer_background`: Hintergrundfarbe des Drawers.
- Blockattribute `eliashofThemeBg`, `eliashofTextWidth` und `eliashofTextPosition`: redaktionelle Darstellung im Editor.

Bei Änderungen am Metaschema müssen Plugin-Modulversion, Plugin-Version, `Stable tag` und Changelog gemeinsam aktualisiert werden. Nach Plugin-Änderungen ist außerdem ein versioniertes Distributions-ZIP zu erzeugen.
