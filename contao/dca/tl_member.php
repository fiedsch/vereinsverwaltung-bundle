<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_member']['config']['ctable'] = ['tl_zahlung'];

// TODO: neue Felder:
//   * Mitglied seit,
//   * Nationalität (?),
//   * Aktives/Passives/Fördermitglied (Mitgliedsart),
//   * Zahlungsart (halbjährlich, jährlich)
//   * Felder für den Typ des Mitglieds wie z.B.: Vorstandsmitglied, Bürgergeldempfänger, Schwerbehindert,
//   * Freitextfeld für Notizen
//   Bei allen Feldern: ist der Zeitverlauf relevant oder nur der aktuelle Status

PaletteManipulator::create()
    // Bereiche (legends)
    ->addLegend('verein_legend', 'personal_legend', PaletteManipulator::POSITION_AFTER)
    ->addLegend('zahlung_legend', 'verein_legend', PaletteManipulator::POSITION_AFTER)
    // Felder (fields)
    ->addField('avatar', 'gender', PaletteManipulator::POSITION_AFTER)
    ->addField('member_type', 'zahlung_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('payment_type', 'zahlung_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('payment_discount', 'zahlung_legend', PaletteManipulator::POSITION_APPEND)
    // ->addField('saldo', 'zahlung_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('member_since', 'verein_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('member_until', 'verein_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('anonymize', 'lastname', PaletteManipulator::POSITION_AFTER)
    ->addField('nickname', 'anonymize', PaletteManipulator::POSITION_AFTER)
    // anwenden
    ->applyToPalette('default', 'tl_member')
;
// dd($GLOBALS['TL_DCA']['tl_member']);


$GLOBALS['TL_DCA']['tl_member']['fields']['avatar'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['avatar'],
    'exclude'   => true,
    'search'    => false,
    'filter'    => false,
    'inputType' => 'fileTree',
    'eval'      => ['tl_class' => 'clr w50', 'fieldType' => 'radio', 'filesOnly' => true, 'extensions' => 'jpg,jpeg,png', 'icon' => 'pickfile.svg'],
    'sql'       => "blob NULL",
];

/* new fields */

$GLOBALS['TL_DCA']['tl_member']['fields']['nickname'] = [
    'inputType' => 'text',
    'exclude'   => true,
    'search'    => true,
    'filter'    => false,
    'sorting'   => true,
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['monthOfBirth'] = [
    'sorting'   => true,
    'sql'       => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['anonymize'] = [
    'inputType' => 'checkbox',
    'filter'    => true,
    'eval'      => ['tl_class' => 'clr m12 w50'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['member_since'] = [
    'inputType' => 'text',
    'eval'      => ['tl_class' => 'w50 wizard', 'rgxp' => 'date', 'datepicker' => true],
    'sql'       => "varchar(10) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['member_until'] = [
    'inputType' => 'text',
    'eval'      => ['tl_class' => 'w50 wizard', 'rgxp' => 'date', 'datepicker' => true],
    'sql'       => "varchar(10) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['member_type'] = [
    'inputType' => 'select',
    'options'   => ['aktiv', 'passiv', 'foerderer'],
    'reference' => &$GLOBALS['TL_LANG']['member_type_options'],
    'eval'      => ['tl_class' => 'w50', 'includeBlankOption' => false],
    'sql'       => "varchar(32) NOT NULL default 'aktiv'",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['payment_type'] = [
    'inputType' => 'select',
    'options'   => ['monatlich', 'halbjaehrlich', 'jaehrlich'],
    'reference' => &$GLOBALS['TL_LANG']['tl_member']['payment_type_options'],
    'eval'      => ['tl_class' => 'w50', 'includeBlankOption' => true, 'mandatory' => true],
    'sql'       => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['payment_discount'] = [
    'inputType' => 'select',
    'options'   => ['voll', 'vorstand', 'sozialhilfe', 'behindert'],
    'reference' => &$GLOBALS['TL_LANG']['payment_discount_options'],
    'eval'      => ['tl_class' => 'w50', 'includeBlankOption' => false],
    'sql'       => "varchar(32) NOT NULL default 'voll'",
];


// // Virtuelles Feld Saldo
// $GLOBALS['TL_DCA']['tl_member']['fields']['saldo'] = [
//     'label'     => &$GLOBALS['TL_LANG']['tl_member']['saldo'],
//     'inputType' => 'text',
//     'sorting'   => true,
//     'eval'      => ['tl_class' => 'w50', 'includeBlankOption' => false],
//     'sql'       => "int(10) NOT NULL default 0", // wir speichern in den Daten immer eine 0 (der wiekliche wert wird dynamisch berechnet)
// ];


// $GLOBALS['TL_DCA']['tl_member']['list']['label']['label_callback'] = function(array $row, string $label, DataContainer $dc, array $args)
// {
//     $memberClass = new \tl_member();
//     $originalCallbackResult = $memberClass->addIcon($row, $label, $dc, $args);
//
//     // dd(func_get_args());
//
//     return  $originalCallbackResult;
// };

// generate monthOfBirth from dateOfBirth see MonthOfBirthListener

// we don't want email to be mandatory
$GLOBALS['TL_DCA']['tl_member']['fields']['email']['eval']['mandatory'] = false;

// Finetuning Optik
$GLOBALS['TL_DCA']['tl_member']['fields']['postal']['eval']['tl_class'] .= ' clr';