<?php

namespace Fiedsch\VereinsverwaltungBundle\Model;

use Contao\Model;
use Contao\Model\Collection;

/**
 * @property integer $id
 * @property integer $pid
 */

class ZahlungModel extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static $strTable = "tl_zahlung";

    public static function findByMemberId(int $id, array $options = []): null|ZahlungModel|Collection
    {
        return self::findBy('pid', $id, $options);
    }
}