<?php
namespace TonyPiper\TimeLog\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TonyPiper\TimeLog\Storage\Storage;

/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 08:45
 */
class EditCommand extends Command
{
    /**
     * @var \TonyPiper\TimeLog\Storage\Storage
     */
    private $storage;

    /**
     * @param \TonyPiper\TimeLog\Storage\Storage $storage
     */
    public function __construct(Storage $storage)
    {
        parent::__construct();
        $this->storage = $storage;
    }

    public function configure()
    {
        $this->setName('edit')
            ->setDescription('Opens the log file for editing')
            ->addOption(
                'date',
                null,
                InputOption::VALUE_OPTIONAL,
                "which day's log to open (e.g. 'yesterday', '2014-01-01')"
            );

    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $this->storage->getLocationReference(new \DateTime($input->getOption('date')));
        $command = $this->getCommand($fileName);
        exec($command);

    }

    /**
     * @param  string $fileName
     * @return string
     */
    protected function getCommand($fileName)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return sprintf("start %s", $fileName);
        }

        if (PHP_OS == 'Darwin') {
            return sprintf("open %s", $fileName);
        }

        return sprintf("vi %s", $fileName);
    }
}
