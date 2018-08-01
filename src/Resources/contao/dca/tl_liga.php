<?php

$GLOBALS['TL_DCA']['tl_liga'] = [
    'config' => [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'ptable' => 'tl_verband',
        'ctable' => ['tl_mannschaft'],
        'sql' => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index',
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            'mode' => 4, // 4 Displays the child records of a parent record
            'fields' => ['name'],
            'flag' => 1, // 1 == Sort by initial letter ascending
            'panelLayout' => 'filter;search,limit',
            'headerFields' => ['name'],
            'disableGrouping' => true,
            'child_record_callback' => function($row) {
                // return json_encode($row);
                return $row['name'];
            }
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
                'label' => &$GLOBALS['TL_LANG']['tl_liga']['edit'],
                'href'  => 'table=tl_mannschaft',
                'icon'  => 'edit.svg',
            ],

            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_liga']['editheader'],
                'href'  => 'act=edit',
                'icon'  => 'header.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_liga']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],

            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_liga']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_liga']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ], // operations
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},name',
    ], // palettes

    'fields' => [

        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],

        'pid' => [
            'foreignKey' => 'tl_verband.name',
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],

        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'name' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_liga']['name'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50', 'maxlength' => 128],
            'flag'      => 1, // Sort by initial letter ascending,
            'sql'       => "varchar(128) NOT NULL default ''",
        ],
    ], // fields

];
