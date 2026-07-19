<?php

declare(strict_types=1);

namespace Fiedsch\VereinsverwaltungBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Template;
use Contao\ContentModel;
use Contao\CoreBundle\Routing\ScopeMatcher;
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

        // TODO: business logic

        return $template->getResponse();
    }

}