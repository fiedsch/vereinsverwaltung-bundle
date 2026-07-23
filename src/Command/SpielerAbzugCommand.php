<?php

namespace Fiedsch\VereinsverwaltungBundle\Command;

use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Contao\Date;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Contao\MemberModel;
use Fiedsch\VereinsverwaltungBundle\Model\ZahlungModel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class SpielerAbzugCommand  extends Command implements FrameworkAwareInterface
{
    use FrameworkAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
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

        $members = MemberModel::findAll(['limit' => 5, 'order' => 'lastname DESC']);
        foreach ($members as $member) {
            dump($member->lastname);
            $zahlungen = ZahlungModel::findByMemberId($member->id, ['order' => 'date ASC']);
            foreach ($zahlungen ?? [] as $zahlung) {
                dump([$zahlung->subject, $zahlung->amount, Date::parse('Y-m-d', $zahlung->date)]);
            }
        }

        return Command::SUCCESS;
    }

}