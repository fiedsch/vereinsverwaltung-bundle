<?php

declare(strict_types=1);

namespace Fiedsch\VereinsverwaltungBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\FilesModel;
use Contao\StringUtil;
use Contao\Template;
use Contao\ContentModel;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Fiedsch\VereinsverwaltungBundle\Model\MannschaftModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: MannschaftsseiteController::TYPE, category: 'vereinsverwaltung')]
class MannschaftsseiteController extends AbstractContentElementController
{
    protected const string TYPE = 'mannschaftsseite';

    public function __construct(
        private readonly ScopeMatcher $scopeMatcher
    ) {
    }

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        // Scope bestimmen, um im Backend einen Platzhalter anzuzeigen, denn sonst
        // bekommen wir (mangels auto_item bzw. Zugriff darauf) eine PageNotFound Exception!
        if ($this->scopeMatcher->isBackendRequest($request)) {
            $backendTemplate = new BackendTemplate('be_wildcard');
            /** @noinspection PhpUndefinedFieldInspection */
            $backendTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['CTE']['mannschaftsseite'][0] . ' ###';

            return new Response($backendTemplate->parse());
        }

        $this->setData($template, $model);

        return $template->getResponse();
    }

    protected function setData(Template $template, ContentModel $model): void
    {

        $mannschaftModel = MannschaftModel::findById($model->mannschaft);

        // $this->addDescriptionToTlHead("Alles zur Mannschaft " . $mannschaftModel->name);

        $template->mannschaft_name = $mannschaftModel->name;
        $template->verbandsseite = $mannschaftModel->website;

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
        $template->mannschaft_bilder = $mannschaft_bilder;

        // Spielerliste
        $contentModel = new ContentModel();
        $contentModel->type = 'spielerliste';
        $contentModel->mannschaft = $model->mannschaft;
        $contentModel->showdetails = '1';
        $contentModel->headline = [
            'value' => 'Spieler',
            'unit' => 'h2',
        ];

        $template->spielerliste = Controller::getContentElement($contentModel);
    }

}