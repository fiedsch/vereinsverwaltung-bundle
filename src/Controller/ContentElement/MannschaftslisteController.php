<?php

declare(strict_types=1);

namespace Fiedsch\VereinsverwaltungBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\FilesModel;
use Contao\StringUtil;
use Contao\Template;
use Contao\ContentModel;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Fiedsch\VereinsverwaltungBundle\Model\MannschaftModel;
USE Fiedsch\VereinsverwaltungBundle\Model\VerbandModel;
#[AsContentElement(type: MannschaftslisteController::TYPE, category: 'vereinsverwaltung')]
class MannschaftslisteController extends AbstractContentElementController
{
    protected const string TYPE = 'mannschaftsliste';

    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
        private readonly Connection $connection,
    ) {
    }

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        // Scope bestimmen, um im Backend einen Platzhalter anzuzeigen, denn sonst
        // bekommen wir (mangels auto_item bzw. Zugriff darauf) eine PageNotFound Exception!
        if ($this->scopeMatcher->isBackendRequest($request)) {
            $backendTemplate = new BackendTemplate('be_wildcard');
            /** @noinspection PhpUndefinedFieldInspection */
            $backendTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['CTE']['mannschaftsliste'][0] . ' ###';

            return new Response($backendTemplate->parse());
        }

        // TODO: business logic
        $this->setData($template, $model);


        return $template->getResponse();
    }

    protected function setData(Template $template, ContentModel $model): void
    {
        $template->mannschaftsliste = [];

        // Dreideimensionaler Array: [verband][liga][mannschaft]
        $mannschaftsliste = [];

        $verbandIds = StringUtil::deserialize($model->verband);
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

        $statement = $this->connection->prepare($query);
        $result = $statement->executeQuery();
        $rows = $result->fetchAllAssociative();

        if (!$rows) { return; }

        $verbandMapping = [];
        $ligaMapping = [];
        foreach ($rows as $row) {
            $verbandlogo = '';
            $verband = VerbandModel::findById($row['vid']);
            if ($verband) {
                $file = FilesModel::findByUuid($verband->logo);
                if ($file) {
                    $verbandlogo = $file->path;
                }
            }
            $mannschaftsliste[$row['vid']][$row['lid']][] = MannschaftModel::linkName($row['mname'], $row['mid']);
            $verbandMapping[$row['vid']] = [
                'name' => $row['vname'],
                'logo' => $verbandlogo
            ];
            $ligaMapping[$row['lid']] = $row['lname'];
        }

        // Mannschaftsliste nach der Reihenfolge in $this->verband sortieren,
        // die im Backend vorgegeben werden kann (checkboxWizard).

        uksort($mannschaftsliste, function($a, $b) use ($verbandIds) {
            return array_search($a, $verbandIds) <=> array_search($b, $verbandIds);
        });

        $template->mannschaftsliste = $mannschaftsliste;
        $template->verbaende = $verbandMapping;
        $template->ligenmapping = $ligaMapping;
    }
}