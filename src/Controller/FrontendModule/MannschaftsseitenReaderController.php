<?php

declare(strict_types=1);

namespace Fiedsch\VereinsverwaltungBundle\Controller\FrontendModule;

use Contao\ContentModel;
use Contao\Controller;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\Input;
use Contao\ModuleModel;
use Doctrine\DBAL\Connection;
use Fiedsch\VereinsverwaltungBundle\ContentMannschaftsseite;
use Fiedsch\VereinsverwaltungBundle\Model\MannschaftModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
#[AsFrontendModule(category: "vereinsverwaltung")]
class MannschaftsseitenReaderController extends AbstractFrontendModuleController
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }
    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $id = Input::get('id');

        if (empty($id)) {
            $template->mannschaft = null;
            return $template->getResponse();
        }
        $mannschaft = MannschaftModel::findById(Input::get('id'));
        if (!$mannschaft) {
            $template->mannschaft = null;
            return $template->getResponse();
        }

        $template->mannschaft = $mannschaft;

        $contentModel = new ContentModel();
        $contentModel->type = 'mannschaftsseite';
        $contentModel->mannschaft = $mannschaft->id;
        $template->mannschaftsseite = Controller::getContentElement($contentModel);

        return $template->getResponse();
    }

}