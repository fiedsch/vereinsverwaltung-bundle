# Vereinsverwaltung (Contao Bundle)

## Überblick 

* Verwaltung von Mannschaften/Spielern eines Vereins 
* Im Wesentlichen: Verwalten der Daten, die strukturiert im Frontend ausgegeben werden sollen


## Lokale Konfiguration (falls gewünscht)

Wenn bestimmte Felder der Mitgliederverwaltung nicht benötigt werden (z.B. "Firma", "Staat", "Land"), 
kann das über die Konfiguration der Anwendung erfolgen.

* Anlegen falls noch nicht existent: `contao/dca/tl_member.php`
* In der `tl_member.php` die gewünschten Änderungen vornehmen. Z.B.

```php
<?php
use Contao\CoreBundle\DataContainer\PaletteManipulator;

/* 
 * modify palette remove unused fields
 */
PaletteManipulator::create()
  ->removeField('company')
  ->removeField('state')
  ->removeField('country') 
  ->removeField('fax') 
  ->removeField('website')
  ->removeField('language')
  ->removeField('assignDir')
  ->applyToPalette('default', 'tl_member')
;  

/*
 * Do not remove from palette, but disable search, sort, and filter 
 */
foreach (['search', 'sorting', 'filter'] as $paletteOption) {
  $GLOBALS['TL_DCA']['tl_member']['fields']['login'][$paletteOption] = false;
}
```
