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
use Contao\FilesModel;
use Contao\StringUtil;
use function Symfony\Component\String\u;

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

    public function generate(): string
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->title = $this->headline;

            $subject = [];
            if ($this->verband) {
                foreach (StringUtil::deserialize($this->verband) as $verband) {
                    $verband = VerbandModel::findById($verband);
                    $subject[] = $verband->name;
                }
            }

            $objTemplate->wildcard = "### " . u($GLOBALS['TL_LANG']['CTE']['mannschaftsliste'][0])->upper() . ' ' . implode(',', $subject) . " ###";
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * Generate the content element
     */
    public function compile(): void
    {
        $this->Template->mannschaftsliste = [];

        // if ($this->verband == '') { return; } // 'verband' ist mandatory

        // Dreideimensionaler Array: [verband][liga][mannschaft]
        $mannschaftsliste = [];

        $verbandIds = StringUtil::deserialize($this->verband);
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
            ORDER BY l.spielstaerke, l.name, m.name
        ";

        $rows = $this->Database->prepare($query)->execute();

        if (!$rows) { return; }
        $verbandMapping = [];
        $ligaMapping = [];
        while ($rows->next()) {
            $verbandlogo = '';
            $verband = VerbandModel::findById($rows->vid);
            if ($verband) {
                $file = FilesModel::findByUuid($verband->logo);
                if ($file) {
                    $verbandlogo = $file->path;
                }
            }
            $mannschaftsliste[$rows->vid][$rows->lid][] = MannschaftModel::linkName($rows->mname, $rows->mid);
            $verbandMapping[$rows->vid] = [
                'name' => $rows->vname,
                'logo' => $verbandlogo
            ];
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