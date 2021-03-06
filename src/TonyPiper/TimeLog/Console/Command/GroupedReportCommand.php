<?php
namespace TonyPiper\TimeLog\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 08:45
 */
class GroupedReportCommand extends ReportCommand
{
    public function configure()
    {
        $this->setName('report:grouped')
            ->setDescription('Generate a report');

        $this->addDateOption();
        $this->addSortOrderOption();
    }

    /**
     * @param  InputInterface            $input
     * @param  OutputInterface           $output
     * @throws \InvalidArgumentException
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $activities = $this->getActivityRepository()->findActivities(
            $input->getOption('date')
        );

        $report = $this->getReportBuilder()->render(
            $activities,
            $input->getOption('sortOrder')
        );

        $output->writeln($report);
    }
}
