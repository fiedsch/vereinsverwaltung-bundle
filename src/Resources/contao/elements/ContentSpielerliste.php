<?php

/**
 * @package Vereinsverwaltung
 * @link https://github.com/fiedsch/contao-vereinsverwaltung-bundle/
 * @license https://opensource.org/licenses/MIT
 *
 * Content element "Liste aller Spieler einer Mannaschft".
 *
 * @author Andreas Fieger <https://github.com/fiedsch>
 */

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\ContentElement;
use \Contao\FilesModel;

/**
 * Class ContentSpielerliste
 *
 * @property integer $mannschaft
 * @property boolean $showdetails
 */

class ContentSpielerliste extends ContentElement
{
    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'ce_spielerliste';

    /**
     * Generate the content element
     */
    public function compile()
    {
            $allespieler = SpielerModel::findAll([
                'column' => ['pid=?'],
                'value'  => [$this->mannschaft],
                'order'  => 'tc DESC, lastname ASC, firstname ASC',
            ]);

        if ($allespieler === null) {
            return;
        }

        $listitems = [];
        foreach ($allespieler as $spieler) {
            $member = $spieler->getRelated('member_id');
            $file = FilesModel::findByUuid($member->avatar);
            $extra['avatar_path'] = $file->path;
            $listitems[] = ['member' => $member, 'spieler' => $spieler, 'extra' => $extra];
        }

        $this->Template->listitems   = $listitems;
        $this->Template->showdetails = $this->showdetails;

    }

}