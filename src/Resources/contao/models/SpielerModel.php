<?php

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\Model;

/**
 * @property integer $id
 * @property integer $pid
 * @property integer $member_id
 * @property string $tc
 * @method static SpielerModel|null findById($id, array $arrOptions = [])
 * @method static SpielerModel|null findByPid($id, array $arrOptions = [])
 * @method  Model|null getRelated($strKey, array $arrOptions = [])
 */


class SpielerModel extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static $strTable = "tl_spieler";
}