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
use Contao\FilesModel;
use Contao\StringUtil;
use function Symfony\Component\String\u;

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
    public function generate(): string
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');

            $headline = $this->headline;
            $objTemplate->wildcard = '### ' . u($GLOBALS['TL_LANG']['CTE']['mannschaftsseite'][0])->upper() . ' ###';
            $objTemplate->id = $this->id;
            $objTemplate->link = $headline;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * @param string $content
     */
    protected function addDescriptionToTlHead(string $content): void
    {
        if ($GLOBALS['TL_HEAD']) {
            foreach ($GLOBALS['TL_HEAD'] as $i => $entry) {
                if (str_contains($entry, "description")) {
                    unset($GLOBALS['TL_HEAD'][$i]);
                }
            }
        }
        $GLOBALS['TL_HEAD'][] = sprintf('<meta name="description" content="%s">', $content);
    }

    public function compile(): void
    {
        $mannschaftModel = MannschaftModel::findById($this->mannschaft);

        $this->addDescriptionToTlHead("Alles zur Mannschaft " . $mannschaftModel->name);

        $this->Template->mannschaft_name = $mannschaftModel->name;
        $this->Template->verbandsseite = $mannschaftModel->website;

        $mannschaft_bilder = null;
        if ($mannschaftModel->avatar) {
            $mannschaft_bilder = [];
            foreach (StringUtil::deserialize($mannschaftModel->avatar) as $uuid) {
                $mannschaft_bilder[] = FilesModel::findByUuid($uuid)->path;
                /* // TODO(?)
                 * $imageObj = new Image(new File('example.jpg'));
                 * $src = $imageObj->setTargetWidth(640)
                 *                 ->setTargetHeight(480)
                 *                 ->setResizeMode('center_center')
                 *                 ->executeResize()
                 *                 ->getResizedPath();
                 */
            }
        }
        $this->Template->mannschaft_bilder = $mannschaft_bilder;

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