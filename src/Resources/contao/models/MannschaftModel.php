<?php

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\Model;
use Contao\PageModel;
use Contao\Config;

/**
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @property string $avatar;
 * @method static MannschaftModel|null findById($id, array $arrOptions = [])
 * @method static MannschaftModel|null findByPid($id, array $arrOptions = [])
 * @method  Model|null getRelated($strKey, array $arrOptions = [])
 */

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
            return sprintf('<a href="%s">%s</a>',
                $teampage->getFrontendUrl("/id/".$this->id),
                $this->name
            );
        }
        return $this->name;
    }
}