<?php

$GLOBALS['TL_DCA']['tl_verband'] = [
    'config' => [
        'dataContainer' => 'Table',
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
        'operations' => [

            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_verband']['edit'],
                'href'  => 'table=tl_liga',
                'icon'  => 'edit.svg',
            ],

            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_verband']['editheader'],
                'href'  => 'act=edit',
                'icon'  => 'header.svg',
            ],

            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_verband']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],

            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_verband']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_verband']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ], // operations
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
            'label'     => &$GLOBALS['TL_LANG']['tl_verband']['name'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'long', 'maxlength' => 128],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],

        'logo' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_verband']['logo'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'fileTree',
            'eval'      => ['tl_class' => 'clr w50', 'fieldType' => 'radio', 'filesOnly' => true, 'extensions' => 'jpg,png', 'icon' => 'pickfile.svg'],
            'sql'       => "blob NULL",
        ],

    ], // fields

];
