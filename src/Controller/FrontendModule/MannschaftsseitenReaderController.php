<?php

declare(strict_types=1);

namespace Fiedsch\VereinsverwaltungBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\Input;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
#[AsFrontendModule]
class MannschaftsseitenReaderController extends AbstractFrontendModuleController
{

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $id = Input::get('id');

        return new Response('FIXME für id '.$id);
    }

}