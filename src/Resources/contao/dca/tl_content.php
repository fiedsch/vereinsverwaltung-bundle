<?php

/**
 * @package Vereinsverwaltung
 * @link https://github.com/fiedsch/contao-vereinsverwaltung-bundle/
 * @license https://opensource.org/licenses/MIT
 */

use Fiedsch\VereinsverwaltungBundle\VerbandModel;

/* Mannschaftsliste */
$GLOBALS['TL_DCA']['tl_content']['palettes']['mannschaftsliste'] = '{type_legend},type,headline;{verband_legend},verband;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['verband'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['verband'],
    'exclude'          => true,
    'foreignKey'       => '',
    'inputType'        => 'checkboxWizard',
    'eval'             => ['mandatory' => true, 'multiple' => true, 'tl_class' => 'w50'],
    'options_callback' => function() {
        $result = [];
        $verbaende = VerbandModel::findAll();
        if ($verbaende) {
            foreach ($verbaende as $verband) {
                $result[$verband->id] = $verband->name;
            }
        }
        return $result;
    },
    'sql'              => "blob NULL",
];

/* Spielerliste */
$GLOBALS['TL_DCA']['tl_content']['palettes']['spielerliste'] = '{type_legend},type,headline;{mannschaft_legend},mannschaft,showdetails;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['mannschaft'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['mannschaft'],
    'exclude'          => true,
    'foreignKey'       => '',
    'inputType'        => 'select',
    'eval'             => ['mandatory' => true, 'tl_class' => 'w50', 'chosen' => true, 'includeBlankOption' => true],
    // 'options_callback' => ['\Fiedsch\LigaverwaltungBundle\DCAHelper', 'getAlleMannschaftenForSelect'],
    'sql'              => "int(10) unsigned NOT NULL default '0'",
];
$GLOBALS['TL_DCA']['tl_content']['fields']['showdetails'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['showdetails'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['tl_class' => 'w50'],
    'sql'       => "char(1) NOT NULL default ''",
];

/* Mannschaftsseite */
$GLOBALS['TL_DCA']  ['tl_content']['palettes']['mannschaftsseite'] = '{type_legend},type,headline;{config_legend},type,mannschaft';
// TODO
// $GLOBALS['TL_DCA']['tl_content']['fields']['mannschaft'] = [ /* ... */ ];

