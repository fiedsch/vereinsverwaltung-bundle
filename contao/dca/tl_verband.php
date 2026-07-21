<?php

use Contao\DC_Table;

\Contao\System::loadLanguageFile('default');

$GLOBALS['TL_DCA']['tl_verband'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'ctable' => ['tl_liga'],
        'sql' => [
            'keys' => [
                'id'  => 'primary',
                'name' => 'unique',
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            'mode' => 2,
            'fields' => ['name'],
            'flag' => 1, // 1 == Sort by initial letter ascending
            'panelLayout' => 'sort,filter;search,limit',
            'headerFields' => ['name'],
        ],
        'label' => [
            'fields' => ['name'],
            'format' => '%s',
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"',
            ]
        ],
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},name,logo',
    ], // palettes

    'fields' => [

        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],

        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'name' => [
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'long', 'maxlength' => 128],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],

        'logo' => [
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'fileTree',
            'eval'      => ['tl_class' => 'clr w50', 'fieldType' => 'radio', 'filesOnly' => true, 'extensions' => 'svg,jpg,png', 'icon' => 'pickfile.svg'],
            'sql'       => "blob NULL",
        ],

    ], // fields

];
