<?php

/**
 * @package Vereinsverwaltung
 * @link https://github.com/fiedsch/contao-vereinsverwaltung-bundle/
 * @license https://opensource.org/licenses/MIT
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{vereinsverwaltung_legend},teampage';

$GLOBALS['TL_DCA']['tl_settings']['fields']['teampage'] = [
    'label'      => &$GLOBALS['TL_LANG']['tl_settings']['teampage'],
    'inputType'  => 'pageTree',
    'exclude'    => true,
    'search'     => false,
    'filter'     => false,
    'sorting'    => false,
    'eval'       => ['mandatory' => false, 'multiple'=>false, 'fieldType'=>'radio', 'tl_class'=>'clr w50'],
    //'sql'        => "blob NULL",
];
