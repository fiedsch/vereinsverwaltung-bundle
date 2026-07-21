<?php

namespace Fiedsch\VereinsverwaltungBundle\EventListener\DataContainer;

use Contao\Date;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DC_Table;
use Doctrine\DBAL\Connection;

class MonthOfBirthListener
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    #[AsCallback(table: "tl_member", target: "fields.dateOfBirth.save")]
    public function onSave(int|string $value, DC_Table $dc)
    {
        $month = Date::parse("m", $value);

        $this->connection->executeQuery(
            "UPDATE tl_member SET monthOfBirth = ? WHERE id=?",
            [$month, $dc->id]
        );

        return $value;
    }

}