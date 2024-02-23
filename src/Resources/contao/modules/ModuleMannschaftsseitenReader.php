<?php

/**
 * @package Vereinsverwaltung
 * @link https://github.com/fiedsch/contao-vereinsverwaltung-bundle/
 * @license https://opensource.org/licenses/MIT
 */

/**
 * Front end module "Manschaftsseiten reader".
 *
 * @author Andreas Fieger <https://github.com/fiedsch>
 */

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\Module;
use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\Input;
use function Symfony\Component\String\u;

class ModuleMannschaftsseitenReader extends Module
{

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'mod_mannschaftsseitenreader';


    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
    public function generate(): string
    {
        if (TL_MODE == 'BE') {
            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . u($GLOBALS['TL_LANG']['FMD']['mannschaftsseitenreader'][0])->upper() . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile(): void
    {
        // Falls wir einen Back-Link einbauen wollen:
        // $this->Template->referer = 'javascript:history.go(-1)';
        // $this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];

        $id = Input::get('id');
        if (empty($id)) {
            $this->Template->mannschaft = null;
            return;
        }
        $mannschaft = MannschaftModel::findById(Input::get('id'));
        if (!$mannschaft) {
            $this->Template->mannschaft = null;
            return;
        }

        $this->Template->mannschaft = $mannschaft;

        $contentModel = new ContentModel();
        $contentModel->type = 'mannschaftsseite';
        $contentModel->mannschaft = $mannschaft->id;
        $contentElement = new ContentMannschaftsseite($contentModel);
        $this->Template->mannschaftsseite = $contentElement->generate();

    }
}
