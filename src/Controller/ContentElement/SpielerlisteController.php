<?php

declare(strict_types=1);

namespace Fiedsch\VereinsverwaltungBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\FilesModel;
use Contao\Template;
use Contao\ContentModel;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Fiedsch\VereinsverwaltungBundle\Model\SpielerModel;

#[AsContentElement(type: SpielerlisteController::TYPE, category: 'vereinsverwaltung')]
class SpielerlisteController extends AbstractContentElementController
{
    protected const string TYPE = 'spielerliste';

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
            $backendTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['CTE']['spielerliste'][0] . ' ###';

            return new Response($backendTemplate->parse());
        }

        $this->setData($template, $model);

        return $template->getResponse();
    }

    protected function setData(Template $template, ContentModel $model): void
    {
        $allespieler = SpielerModel::findAll([
            'column' => ['pid=?'],
            'value'  => [$model->mannschaft],
            'order'  => 'tc DESC, lastname ASC, firstname ASC',
        ]);

        if ($allespieler === null) {
            return;
        }

        $listitems = [];
        foreach ($allespieler as $spieler) {
            $member = $spieler->getRelated('member_id');
            if ($member) {
                $file = FilesModel::findByUuid($member->avatar);
                $listitems[] = [
                    'member'  => $member,
                    'spieler' => $spieler,
                    'extra'   => [
                         'avatar_path' => $file?->path
                    ]
                ];
            }
        }

        $template->listitems   = $listitems;
        $template->showdetails = $model->showdetails;
    }

}