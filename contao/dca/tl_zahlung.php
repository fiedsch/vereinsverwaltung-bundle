<?php

// TODO
//     * Subject u.U. nicht unique, damit Teilzahlungen (monatlich, halbjährlich) abegebildet werden können
//     * Negative Zahlung (Soll) -- werden jedes Jahr mittels eines Commands für alle Mitglieder befüllt

use Contao\DC_Table;
use Contao\DataContainer;

\Contao\System::loadLanguageFile('default');

$GLOBALS['TL_DCA']['tl_zahlung'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'ptable' => 'tl_member',
        'sql' => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index',
                //'pid,subject' => 'unique'
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_PARENT,
            'fields' => ['subject','amount'],
            'flag' => 1, // 1 == Sort by initial letter ascending
            'panelLayout' => 'filter;search,limit',
            'headerFields' => ['lastname', 'firstname'],
            'header_callback' => function(array $labels, DataContainer $dc): array {
    //dd($dc);
                $labels['Achtung'] = 'Das folgende ist nur ein Dummy und noch nicht funktional';
                $labels['Saldo 2025'] = '-';
                $labels['Saldo 2026'] = '32 €';
                $labels['Saldo 2027'] = '-';

                return $labels;
            },
            'disableGrouping' => true,
            'child_record_callback' => function($row) {
                // return json_encode($row);
                return sprintf('<span class="tl_gray">%s</span> <span class="%s">%s</span> € für </span><span>„%s“</span>',
                    \Contao\Date::parse('Y-m-d', $row['date']),
                    $row['amount'] < 0 ? 'tl_red' : 'tl_green',
                    $row['amount'] < 0 ? '−'.abs($row['amount']) : '+'.$row['amount'],
                    $row['subject'],
                );
            }
        ],
        'label' => [
            'fields' => ['subject','amount'],
            'format' => '%s %s',
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
                'label' => &$GLOBALS['TL_LANG']['tl_zahlung']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_zahlung']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],

            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_zahlung']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_zahlung']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ], // operations
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},subject,amount,date,startmonth,months,zahlungsart',
    ], // palettes

    'fields' => [

        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],

        'pid' => [
            'foreignKey' => 'tl_member.id',
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],

        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'subject' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_zahlung']['subject'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50', 'maxlength' => 128],
            'flag'      => 1, // Sort by initial letter ascending,
            'sql'       => "varchar(128) NOT NULL default ''",
        ],

        'startmonth' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_zahlung']['startmonth'],
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50 wizard', 'rgxp' => 'date', 'datepicker' => true],
            'sql'       => "varchar(10) NOT NULL default ''",
        ],

        'months' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_zahlung']['months'],
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50 wizard' ],
            'sql'       => "varchar(10) NOT NULL default ''",
        ],

        'amount' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_zahlung']['amount'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => false,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50', 'rgxp' => 'digit', 'maxlength' => 8, 'mandatory' => true],
            'sql'       => "int(10) NOT NULL default '0'",
        ],

        'date' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_zahlung']['date'],
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50 wizard', 'rgxp' => 'date', 'datepicker' => true],
            'sql'       => "varchar(10) NOT NULL default ''",
        ],

        'zahlungsart' => [
             'label'     => &$GLOBALS['TL_LANG']['tl_zahlung']['zahlungsart'],
            'inputType' => 'select',
            'options'   => ['bar', 'ueberweisung'],
            //'reference' => &$GLOBALS['TL_LANG']['payment_discount_options'],
            'eval'      => ['tl_class' => 'w50', 'includeBlankOption' => false],
            'sql'       => "varchar(32) NOT NULL default 'ueberweisung'",
        ]



    ], // fields

];
