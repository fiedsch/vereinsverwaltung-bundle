<?php

declare(strict_types=1);

namespace Fiedsch\VereinsverwaltungBundle\Command;

use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Contao\Date;
use Contao\FilesModel;
use Contao\MemberGroupModel;
use Contao\MemberModel;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function array_merge;
use function implode;
use function sprintf;
use function str_repeat;

class SpielerAbzugCommand  extends Command implements FrameworkAwareInterface
{
    use FrameworkAwareTrait;

    protected array $memberGroupsData = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
        $this->getMemberGroupsData();
    }

    protected function getMemberGroupsData(): void
    {
        $memberGroups = MemberGroupModel::findAll();
        foreach ($memberGroups as $memberGroup) {
            $this->memberGroupsData[$memberGroup->id] = $memberGroup->name;
        }
    }

    protected function configure(): void
    {
        $this
            ->setName('fiedsch:vereinsverwaltung:mitgliederliste')
            ->setDescription('Datenabzug Mitgliederliste.')
            //->addArgument('saison', InputArgument::REQUIRED, 'Saison')
             ;
    }

     /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Contao "booten"
        $this->framework->initialize();

        // Kopfzeile
        $tableRow = [
            'Name', 'Vorname', 'hinzugefügt', 'ID',
            'Bild',
            'Geschlecht',
            'Mitgliedergruppen',
            'E-Mail', 'Mobil', 'Telefon', 'Straße', 'Plz', 'Ort',
            'Login',
        ];
        $formatstring = str_repeat("%s\t", count($tableRow));
        $output->writeln(sprintf($formatstring, ...$tableRow));


        $members = MemberModel::findAll(['order' => 'lastname ASC, firstname ASC']);
        foreach ($members as $member) {
            // Name
            $tableRow = [
                $member->lastname,
                $member->firstname,
                Date::parse('Y-m-d', $member->dateAdded),
                $member->id,
            ];
            $formatstring = "%s\t%s\t%s\t%s";

            // Bild zum Mitglied
            if (!$member->avatar) {
                $tableRow[] = "Kein Bild zugeordnet";
            } else {
                $memberImage = FilesModel::findByUuid($member->avatar);
                if (!$memberImage) {
                    $tableRow[] = "Bild existiert nicht mehr!";
                }
                $tableRow[] = $memberImage->path;
            }
            $formatstring .= "\t%s";

            // Geschlecht
            $tableRow[] = match ($member->gender) { 'male' => 'männlich', 'female' => 'weiblich', 'other' => 'divers', default => $member->gender == '' ? 'nicht gesetzt' : $member->gender };
            $formatstring .= "\t%s";

            // Mitgliedergruppen
            $assignedGroups = [];
            foreach (StringUtil::deserialize($member->groups) ?? [] as $group) {
                $assignedGroups[] = $this->memberGroupsData[$group];
            }
            $tableRow[] = implode('|', $assignedGroups);
            $formatstring .= "\t%s";

            // Kontaktdaten
            $contactInfo = [
                $member->email,
                $member->mobile,
                $member->phone,
                $member->street,
                $member->postal,
                $member->city,
            ];
            foreach ($contactInfo as $contact) {
                $tableRow[] = $contact;
            }
            //$tableRow = array_merge($tableRow, $contactInfo);
            $formatstring .= str_repeat("\t%s", count($contactInfo));

            // Login erlauben?
            $tableRow[] = $member->login ? ('ja, als '.$member->username) : 'nein';
            $formatstring .= "\t%s";

            // Ausgabe der Daten zum Mitglied
            /** @noinspection PhpFormatFunctionParametersMismatchInspection */
            $output->writeln(sprintf("<info>$formatstring</info>", ...$tableRow));
        }

        return Command::SUCCESS;
    }

}
