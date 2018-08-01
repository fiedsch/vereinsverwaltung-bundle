<?php

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\Model;
use Contao\PageModel;
use Contao\Config;
use Contao\Controller;

class MannschaftModel extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static $strTable = "tl_mannschaft";

    /**
     * @return string
     */
    public function getLinkedName()
    {
        $teampageId = Config::get('teampage');
        if ($teampageId) {
            $teampage = PageModel::findById($teampageId);
            if (Config::get('folderUrl')) {
                $url = Controller::generateFrontendUrl($teampage->row(), '/id/'.$this->id);
            } else {
                $url = Controller::generateFrontendUrl($teampage->row()) . '?id=' . $this->id;
            }
            $result = sprintf("<a href='%s'>%s</a>",
                $url,
                $this->name
            );
        } else {
            $result = $this->name;
        }
        return $result;
    }
}