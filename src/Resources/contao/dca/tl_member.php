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
