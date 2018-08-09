<?php

/**
 * @package Vereinsverwaltung
 * @link https://github.com/fiedsch/contao-vereinsverwaltung-bundle/
 * @license https://opensource.org/licenses/MIT
 */

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\ContentModel;
use Patchwork\Utf8;
use \Contao\FilesModel;

/**
 * Class ContentMannschaftsseite
 *
 * @property integer $id
 * @property integer $mannschaft
 */

class ContentMannschaftsseite extends ContentElement
{
    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'ce_mannschaftsseite';

    /**
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');

            $headline = $this->headline;
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['CTE']['mannschaftsseite'][0]) . ' ###';
            $objTemplate->id = $this->id;
            $objTemplate->link = $headline;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * @param string $content
     */
    protected function addDescriptionToTlHead($content)
    {
        if ($GLOBALS['TL_HEAD']) {
            foreach ($GLOBALS['TL_HEAD'] as $i => $entry) {
                if (preg_match("/description/", $entry)) {
                    unset($GLOBALS['TL_HEAD'][$i]);
                }
            }
        }
        $GLOBALS['TL_HEAD'][] = sprintf('<meta name="description" content="%s">', $content);
    }

    public function compile()
    {
        $mannschaftModel = MannschaftModel::findById($this->mannschaft);

        $this->addDescriptionToTlHead("Alles zur Mannschaft " . $mannschaftModel->name);

        $this->Template->mannschaft_name = $mannschaftModel->name;
        if ($mannschaftModel->avatar) {
            $this->Template->mannschaft_bild = FilesModel::findByUuid($mannschaftModel->avatar)->path;
        }

        // Spielerliste
        $contentModel = new ContentModel();
        $contentModel->type = 'spielerliste';
        $contentModel->mannschaft = $this->mannschaft;
        $contentModel->showdetails = '1';
        $contentModel->headline = [
            'value' => 'Spieler',
            'unit'  => 'h2',
        ];
        $contentElement = new ContentSpielerliste($contentModel);
        $this->Template->spielerliste = $contentElement->generate();

   }

}