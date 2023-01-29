<?php

\Contao\System::loadLanguageFile('default');

$GLOBALS['TL_DCA']['tl_spieler'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'ptable' => 'tl_mannschaft',
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid,member_id' => 'unique'
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            'mode' => 4, // 4 Displays the child records of a parent record
            'fields' => ['pid','tc=""'],
            'format' => '%s %s',
            'flag' => 12, // 12 == Sort descending
            'disableGrouping' => true,
            'panelLayout' => 'filter;search,limit',
            'headerFields' => ['name'],
            'child_record_callback' => function($row) {
                // return json_encode($row);
                // Für den Aufruf "als child records"
                $member = \Contao\MemberModel::findById($row['member_id']);
                return sprintf("%s, %s %s",
                    $member->lastname,
                    $member->firstname,
                    $row['tc'] ? '(TC)' : ''
                );
            }
        ],
        'label' => [
            'fields' => ['member_id'],
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
                'label' => &$GLOBALS['TL_LANG']['tl_spieler']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
            ],

            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_spieler']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],

            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_spieler']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_spieler']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ], // operations
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},member_id,tc',
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

        'member_id' => [
            'label'      => &$GLOBALS['TL_LANG']['tl_spieler']['member_id'],
            'exclude'    => true,
            'search'     => false,
            'filter'     => true,
            'inputType'  => 'select',
            'eval'       => ['doNotCopy'=>true,'tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true],
            'foreignKey' => 'tl_member.CONCAT(firstname, " ", lastname)',
            'options_callback' => function(DataContainer $dc) {
                $result = [];
                $query =
                'SELECT * FROM tl_member ORDER BY tl_member.firstname, tl_member.lastname';
                $member = \Contao\Database::getInstance()->prepare($query)->execute();
                while ($member->next()) {
                    $result[$member->id] = sprintf("%s, %s", $member->lastname, $member->firstname);
                }
                return $result;
            },
            'relation'   => ['type' => 'hasOne', 'table' => 'tl_member', 'load' => 'eager'],
            'sql'        => "int(10) NOT NULL default '0'",
        ],

        'tc' => [
            'label'      => &$GLOBALS['TL_LANG']['tl_spieler']['tc'],
            'exclude'    => true,
            'search'     => false,
            'filter'     => false,
            'inputType'  => 'checkbox',
            'eval'       => ['tl_class' => 'w50 m12'],
            'sql'        => "char(1) NOT NULL default ''",
        ],

    ], // fields

];
