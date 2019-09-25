<?php

$GLOBALS['TL_DCA']['tl_mannschaft'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'ptable' => 'tl_liga',
        'ctable' => ['tl_spieler'],
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid,name' => 'unique'
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            'mode' => 4, // 4 Displays the child records of a parent record
            'fields' => ['pid'],
            'format' => '%s',
            'flag' => 11, // 11 == Sort ascending
            'disableGrouping' => true,
            'panelLayout' => 'limit',
            'headerFields' => ['name'],
            'child_record_callback' => function($row) {
                // Für den Aufruf "als child records"
                //return json_encode($row);
                return $row['name'];
            }
        ],
        'label' => [
            'fields' => ['name'],
            'format' => '%s',
            /*
            'group_callback' => function($group, $mode, $field, $row) {
                return json_encode($row);
            },
            */
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
                'label' => &$GLOBALS['TL_LANG']['tl_mannschaft']['edit'],
                'href'  => 'table=tl_spieler',
                'icon'  => 'edit.svg',
            ],
            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mannschaft']['editheader'],
                'href'  => 'act=edit',
                'icon'  => 'header.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mannschaft']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],
            'cut' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mannschaft']['cut'],
                'href'  => 'act=paste&amp;mode=cut',
                'icon'  => 'cut.svg',
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_mannschaft']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mannschaft']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ], // operations
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},name,avatar,website',
    ], // palettes

    'fields' => [

        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],

        'pid' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'name' => [
            'label'      => &$GLOBALS['TL_LANG']['tl_mannschaft']['name'],
            'exclude'    => true,
            'search'     => false,
            'filter'     => false,
            'inputType'  => 'text',
            'eval'       => ['doNotCopy'=>true,'tl_class' => 'w50','maxlength'=>128],
            'sql'        => "varchar(128) NOT NULL default ''",
        ],

        'avatar' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_mannschaft']['avatar'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'fileTree',
            'eval'      => ['tl_class' => 'clr w50', 'fieldType' => 'checkbox', 'multiple' => true, 'orderField' => 'order_avatar', 'filesOnly' => true, 'extensions' => 'jpg,png', 'icon' => 'pickfile.svg'],
            'sql'       => "blob NULL",
        ],

        'order_avatar' => [
            'label' =>  &$GLOBALS['TL_LANG']['tl_mannschaft']['order_avatar'],
            'sql' => 'blob NULL',
        ],

        'website' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_mannschaft']['website'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'url', 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],

    ], // fields

];
