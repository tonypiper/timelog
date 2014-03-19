<?php
namespace TonyPiper\TimeLog\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use TonyPiper\TimeLog\Report\Builder\ReportBuilder;
use TonyPiper\TimeLog\Report\Builder\ReportBuilderInterface;
use TonyPiper\TimeLog\Repository\ActivityRepository;

/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 08:45
 */
abstract class ReportCommand extends Command
{
    /**
     * @var ActivityRepository
     */
    private $activityRepository;
    /**
     * @var \TonyPiper\TimeLog\Report\Builder\ReportBuilder
     */
    private $reportBuilder;

    /**
     * @param ActivityRepository     $activityRepository
     * @param ReportBuilderInterface $reportBuilder
     */
    public function __construct(ActivityRepository $activityRepository, ReportBuilderInterface $reportBuilder)
    {
        parent::__construct();
        $this->activityRepository = $activityRepository;
        $this->reportBuilder = $reportBuilder;
    }

    protected function addDateOption()
    {
        $this->addOption(
            'date',
            null,
            InputOption::VALUE_OPTIONAL,
            'the date for the report - must be string that can be understood by strtotime'
        );
    }

    protected function addSortOrderOption()
    {
        $this->addOption('sortOrder', null, InputOption::VALUE_OPTIONAL, 'how to sort', null);
    }

    /**
     * @return ActivityRepository
     */
    public function getActivityRepository()
    {
        return $this->activityRepository;
    }

    /**
     * @return ReportBuilderInterface
     */
    public function getReportBuilder()
    {
        return $this->reportBuilder;
    }

}
