<?php

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\Model;

/**
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @method static LigaModel|null findById($id, array $arrOptions = [])
 * @method static LigaModel|null findByPid($id, array $arrOptions = [])
 * @method  VerbandModel|null getRelated($strKey, array $arrOptions = [])
 */

class LigaModel extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static $strTable = "tl_liga";
}