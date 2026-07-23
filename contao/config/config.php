<?php


use Contao\ArrayUtil;
/**
 * Backendmodule
 */
ArrayUtil::arrayInsert($GLOBALS['BE_MOD'], 3, [
    'vereinsverwaltung' => [
        'verband' => [
            'tables' => ['tl_verband', 'tl_liga', 'tl_mannschaft', 'tl_spieler'],
        ]
    ]
]);

$GLOBALS['BE_MOD']['accounts']['member']['tables'][] = 'tl_zahlung';

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_verband'] = 'Fiedsch\VereinsverwaltungBundle\Model\VerbandModel';
$GLOBALS['TL_MODELS']['tl_liga'] = 'Fiedsch\VereinsverwaltungBundle\Model\LigaModel';
$GLOBALS['TL_MODELS']['tl_mannschaft'] = 'Fiedsch\VereinsverwaltungBundle\Model\MannschaftModel';
$GLOBALS['TL_MODELS']['tl_spieler'] = 'Fiedsch\VereinsverwaltungBundle\Model\SpielerModel';
$GLOBALS['TL_MODELS']['tl_zahlung'] = 'Fiedsch\VereinsverwaltungBundle\Model\ZahlungModel';

