<?php
namespace TonyPiper\TimeLog\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TonyPiper\TimeLog\ReportBuilder;
use TonyPiper\TimeLog\Repository\ActivityRepository;

/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 08:45
 */
class ReportCommand extends Command
{
    /**
     * @var ActivityRepository
     */
    private $activityRepository;
    /**
     * @var \TonyPiper\TimeLog\ReportBuilder
     */
    private $reportBuilder;

    /**
     * @param ActivityRepository $activityRepository
     * @param ReportBuilder      $reportBuilder
     */
    public function __construct(ActivityRepository $activityRepository, ReportBuilder $reportBuilder)
    {
        parent::__construct();
        $this->activityRepository = $activityRepository;
        $this->reportBuilder = $reportBuilder;
    }

    public function configure()
    {
        $this->setName('report')
            ->setDescription('Generate a report');

        $this->addOption(
            'date',
            null,
            InputOption::VALUE_OPTIONAL,
            'the date for the report - must be string that can be understood by strtotime'
        );

        $this->addOption('grouped', null, InputOption::VALUE_NONE, 'whether to sort and group the output');

        $this->addOption('sortOrder', null, InputOption::VALUE_OPTIONAL, 'how to sort', null);
    }

    /**
     * @param  InputInterface            $input
     * @param  OutputInterface           $output
     * @throws \InvalidArgumentException
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->reportBuilder->validateSortOrder($input->getOption('sortOrder'))) {
            throw new \InvalidArgumentException('Invalid Sort Order');
        }

        $activities = $this->activityRepository->findActivities(
            $input->getOption('date')
        );

        $report = $this->reportBuilder->generateReport(
            $activities,
            $input->getOption('sortOrder'),
            $input->getOption('grouped')
        );

        $output->writeln($report);
    }
}
