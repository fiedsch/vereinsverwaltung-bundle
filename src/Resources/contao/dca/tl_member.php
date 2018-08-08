<?php
$GLOBALS['TL_DCA']['tl_member']['palettes']['default']
    = str_replace('gender;', 'gender,avatar;', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_member']['fields']['avatar'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['avatar'],
    'exclude'   => true,
    'search'    => false,
    'filter'    => false,
    'inputType' => 'fileTree',
    'eval'      => ['tl_class' => 'clr w50', 'fieldType' => 'radio', 'filesOnly' => true, 'extensions' => 'jpg,png', 'icon' => 'pickfile.svg'],
    'sql'       => "blob NULL",
];

/* new fields */

$GLOBALS['TL_DCA']['tl_member']['fields']['nickname'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['nickname'],
    'inputType' => 'text',
    'exclude'   => true,
    'search'    => true,
    'filter'    => false,
    'sorting'   => true,
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['monthOfBirth'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['monthOfBirth'],
    'sorting'   => true,
    'sql'       => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_member']['fields']['anonymize'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['anonymize'],
    'inputType' => 'checkbox',
    'filter'    => true,
    'eval'      => ['tl_class' => 'clr m12 w50'],
    'sql'       => "char(1) NOT NULL default ''",
];

// generate monthOfBirth from dateOfBirth
$GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['save_callback'][] = ['Fiedsch\VereinsverwaltungBundle\DcaHelper','generateMonthOfBirth'];

// modify palette add new fields

$GLOBALS['TL_DCA']['tl_member']['palettes']['default']
    = str_replace("lastname", 'lastname,anonymize,nickname', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);

// we don't want email to be mandatory
$GLOBALS['TL_DCA']['tl_member']['fields']['email']['eval']['mandatory'] = false;
