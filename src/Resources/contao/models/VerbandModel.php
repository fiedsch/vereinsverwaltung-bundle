<?php

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\Model;

/**
 * @property integer $id
 * @property string $name
 * @method static VerbandModel|null findById($id, array $arrOptions = [])
 */

class VerbandModel extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static $strTable = "tl_verband";
}