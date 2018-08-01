<?php

/**
 * Backendmodule
 */
array_insert($GLOBALS['BE_MOD'], 2, [
    'verein' => [
        'liga.verband' => [
            'tables' => ['tl_verband', 'tl_liga', 'tl_mannschaft', 'tl_spieler'],
        ]
    ],
]);

/**
 * Contentelemente
 */
$GLOBALS['TL_CTE']['vereinsverwaltung']['mannschaftsliste'] = '\Fiedsch\VereinsverwaltungBundle\ContentMannschaftsliste';
$GLOBALS['TL_CTE']['vereinsverwaltung']['spielerliste'] = '\Fiedsch\VereinsverwaltungBundle\ContentSpielerliste';
$GLOBALS['TL_CTE']['vereinsverwaltung']['mannschaftsseite'] = '\Fiedsch\VereinsverwaltungBundle\ContentMannschaftsseite';


/**
 * Module
 */
$GLOBALS['FE_MOD']['vereinsverwaltung']['mannschaftsseitenreader'] = '\Fiedsch\VereinsverwaltungBundle\ModuleMannschaftsseitenReader';

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_verband'] = 'Fiedsch\VereinsverwaltungBundle\VerbandModel';
$GLOBALS['TL_MODELS']['tl_liga'] = 'Fiedsch\VereinsverwaltungBundle\LigaModel';
$GLOBALS['TL_MODELS']['tl_mannschaft'] = 'Fiedsch\VereinsverwaltungBundle\MannschaftModel';
$GLOBALS['TL_MODELS']['tl_spieler'] = 'Fiedsch\VereinsverwaltungBundle\SpielerModel';

/* Add to Backend CSS */
if (TL_MODE === 'BE') {
    $GLOBALS['TL_CSS'][] = 'bundles/fiedschvereinsverwaltung/backend.css';
}
