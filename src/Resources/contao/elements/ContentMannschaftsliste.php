<?php

/**
 * @package Fiedsch\VereinsverwaltungBundle
 * @link https://github.com/fiedsch/contao-vereinsverwaltung-bundle/
 * @license https://opensource.org/licenses/MIT
 *
 * Content element "Liste aller Mannschaften einer Liga".
 * @author Andreas Fieger <https://github.com/fiedsch>
 */

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\ContentElement;
use Contao\BackendTemplate;

/**
 * Class ContentMannschaftsliste
 *
 * @property string $verband
 */
class ContentMannschaftsliste extends ContentElement
{
    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'ce_mannschaftsliste';

    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->title = $this->headline;

            $subject = [];
            if ($this->verband) {
                foreach (deserialize($this->verband) as $verband) {
                    $verband = VerbandModel::findById($verband);
                    $subject[] = $verband->name;
                }
            }

            $objTemplate->wildcard = "### " . $GLOBALS['TL_LANG']['CTE']['mannschaftsliste'][0] . ' ' . implode(',', $subject) . " ###";
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * Generate the content element
     */
    public function compile()
    {
        $this->Template->mannschaftsliste = [];

        // if ($this->verband == '') { return; } // 'verband' ist mandatory

        // Dreideimensionaler Array: [verband][liga][mannschaft]
        $mannschaftsliste = [];

        $verbandIds = deserialize($this->verband);
        // if (!$verbandIds) { return; } // 'verband' ist mandatory
        $verbandIdListe = join(',', $verbandIds);

        $query = "
            SELECT 
              m.id as mid, m.name as mname,
              l.id as lid, l.name as lname,
              v.id as vid, v.name as vname
            FROM tl_mannschaft m
            LEFT JOIN tl_liga l ON (m.pid=l.id)
            LEFT JOIN tl_verband v ON (l.pid=v.id)
            WHERE v.id IN ($verbandIdListe)
            ORDER BY l.spielstaerke, m.name
        ";

        $rows = $this->Database->prepare($query)->execute();

        if (!$rows) { return; }
        $verbandMapping = [];
        $ligaMapping = [];
        while ($rows->next()) {
            $mannschaftsliste[$rows->vid][$rows->lid][] = MannschaftModel::linkName($rows->mname, $rows->mid);
            $verbandMapping[$rows->vid] = $rows->vname;
            $ligaMapping[$rows->lid] = $rows->lname;
        }

        // Mannschaftsliste nach der Reihenfolge in $this->verband sortieren,
        // die im Backend vorgegeben werden kann (checkboxWizard).

        uksort($mannschaftsliste, function($a, $b) use ($verbandIds) {
            return array_search($a, $verbandIds) <=> array_search($b, $verbandIds);
        });

        $this->Template->mannschaftsliste = $mannschaftsliste;
        $this->Template->verbaende = $verbandMapping;
        $this->Template->ligen = $ligaMapping;
    }

}