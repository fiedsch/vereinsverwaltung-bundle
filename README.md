# Vereinsverwaltung (Contao Bundle)

## Überblick 

* Verwaltung von Mannschaften/Spielern eines Vereins 
* Im Wesentlichen: Verwalten der Daten, die strukturiert im Frontend ausgegeben werden sollen 
* WIP: entsprechende Frontendmodule "kommen noch".


## Lokale Konfiguration (falls gewünscht)

Wenn bestimmte Felder der Mitgliederverwaltung nicht benötigt werden (z.B. "Firma", "Staat", "Land"), 
kann das über die Konfiguration der Anwendung erfolgen.

* Anlegen falls noch nicht existent: `app/Resources/contao/dca/tl_member.php`
* In der `tl_member.php` die gewünschten Änderungen vornehmen. Z.B.

```php
<?php

/* 
 * modify palette remove unused fields
 */

foreach (['company', 'state', 'country', 'fax', 'website', 'language', 'assignDir'] as $field) {
    $GLOBALS['TL_DCA']['tl_member']['palettes']['default']
        = str_replace(",$field", '', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);
    // also remove these fields from the search,sort,filter, panel
    foreach (['search', 'sorting', 'filter'] as $paletteOption) {
        $GLOBALS['TL_DCA']['tl_member']['fields'][$field][$paletteOption] = false;
    }
}

/*
 * Do not remove from palette, but disable search, sort, and filter 
 */
foreach (['search', 'sorting', 'filter'] as $paletteOption) {
  $GLOBALS['TL_DCA']['tl_member']['fields']['login'][$paletteOption] = false;
}
```
