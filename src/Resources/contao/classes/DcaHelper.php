<?php

namespace Fiedsch\VereinsverwaltungBundle;

use Contao\DataContainer;
use Contao\Database;
use Contao\Date;

class DcaHelper
{

    public static function generateMonthOfBirth($varValue, DataContainer $dc)
    {
        $month = Date::parse("m", $varValue);
        Database::getInstance()
            ->prepare("UPDATE tl_member SET monthOfBirth =? WHERE id=?")
            ->execute($month, $dc->id);
        return $varValue;
    }

}