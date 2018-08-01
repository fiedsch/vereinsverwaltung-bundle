<?php

/**
 * @package Vereinsverwaltung
 * @link https://github.com/fiedsch/contao-vereinsverwaltung-bundle/
 * @license https://opensource.org/licenses/MIT
 */

namespace Fiedsch\VereinsverwaltungBundle;
/**
 * Content element "Liste aller Mannschaften einer Liga".
 *
 * @author Andreas Fieger <https://github.com/fiedsch>
 */

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\ContentElement;
use Contao\BackendTemplate;

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


            $liga = LigaModel::findById($this->liga);
            $suffix = 'Mannschaften';
            $subject = sprintf('%s %s',
                $liga->getRelated('pid')->name,
                $liga->name
            );
            $objTemplate->wildcard = "### " . $GLOBALS['TL_LANG']['CTE']['mannschaftsliste'][0] . " $subject ###";
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * Generate the content element
     */
    public function compile()
    {
        if ($this->liga == '') {
            return;
        }
        $mannschaften = MannschaftModel::findByPid($this->liga, ['order' => 'name ASC']);
        if ($mannschaften === null) {
            return;
        }

        $listitems = [];
        foreach ($mannschaften as $mannschaft) {
            $listitem = $mannschaft->getLinkedName();
            $listitems[] = $listitem;
        }

        $this->Template->listitems = $listitems;

    }

}