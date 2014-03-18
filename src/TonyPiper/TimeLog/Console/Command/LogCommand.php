<?php
namespace TonyPiper\TimeLog\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TonyPiper\TimeLog\Model\Activity;
use TonyPiper\TimeLog\Repository\ActivityRepository;

/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 08:45
 */
class LogCommand extends Command
{
    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    /**
     * @param ActivityRepository $activityRepository
     */
    public function __construct(ActivityRepository $activityRepository)
    {
        parent::__construct();
        $this->activityRepository = $activityRepository;
    }

    public function configure()
    {
        $this->setName('log')
            ->setDescription('log an activity')
            ->addArgument('description', InputArgument::REQUIRED, 'The activity to Log. Remember to use quotes!');
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $description = $input->getArgument('description');
        $activity = new Activity(new \DateTime(), $description);
        $this->activityRepository->save($activity);

        $output->writeln(sprintf('Logged "%s" successfully', $description));
    }
}
