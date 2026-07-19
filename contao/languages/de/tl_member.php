<?php

$GLOBALS['TL_LANG']['tl_member']['zahlung_legend'] = 'Beitragszahlung';
$GLOBALS['TL_LANG']['tl_member']['verein_legend'] = 'Verein';

$GLOBALS['TL_LANG']['tl_member']['avatar'] = [
    'Bild',
    'Bild des Spielers.'
];

$GLOBALS['TL_LANG']['tl_member']['nickname'] = [
    'Nickname',
    'Nickname des Mitglieds. ',
];
$GLOBALS['TL_LANG']['tl_member']['monthOfBirth'] = [
    'Geburtsmonat',
    'Virtuelles Feld, das automatisch via save_callback gesetzt wird. Verwendung in der Mitgliederliste.',
];

$GLOBALS['TL_LANG']['tl_member']['anonymize'] = [
    'Anonymisieren',
    'Das Mitglied bei Frontendausgaben anonymisieren, d.h. den Namen nicht ausgeben.'
];

$GLOBALS['TL_LANG']['tl_member']['member_type'] = [
    'Mitgliedsart',
    'Art der Mitgliedschaft (aktueller Status).'
];

$GLOBALS['TL_LANG']['tl_member']['member_since'] = [
    'Mitglied seit',
    'Beginn der Mitgliedschaft.'
];

$GLOBALS['TL_LANG']['tl_member']['member_until'] = [
    'Mitglied bis',
    'Ende der Mitgliedschaft.'
];

$GLOBALS['TL_LANG']['tl_member']['payment_discount'] = [
    'Mitgliedsbeitrag Nachlass',
    'Höhe des Mitgliedsbeitrags. Manche Mitglieder zahlen einen verringerten Mitgliedsbeitrag.'
];

$GLOBALS['TL_LANG']['tl_member']['payment_type'] = [
    'Zahlungsintervall Mitgliedsbeitrag',
    'Wie wird der Mitgliedsbeitrag bezahlt (aktueller Status -- Soll).'
];

// Virtuelles Feld
$GLOBALS['TL_LANG']['tl_member']['saldo'] = [
    'Zahlungssaldo',
    '...'
];


$GLOBALS['TL_LANG']['member_type_options'] = [
    'aktiv' => 'Aktives Mitglied',
    'passiv' => 'Passives Mitglied',
    'foerderer' => 'Fördermitglied'
];

$GLOBALS['TL_LANG']['tl_member']['payment_type_options'] = [
    'monatlich' => 'Monatlich',
    'halbjaehrlich' => 'Halbjährlich',
    'jaehrlich' => 'Jährlich (ein Monat frei)',
];
$GLOBALS['TL_LANG']['payment_discount_options'] =
    [
        'voll' => 'Voller Beitrag',
        'vorstand' => 'Vorstandsmitglieder zahlen halben Beitrag',
        'sozialhilfe' => 'Grundsicherungsempfänger zahlen halben Beitrag',
        'behindert' => 'Schwerbehinderte zahlen halben Beitrag'
];