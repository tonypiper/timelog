<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 18/03/2014
 * Time: 19:59
 */

namespace TonyPiper\TimeLog\Console\Command;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 * @package TonyPiper\TimeLog\Console\Command
 */
class UpdateCommand extends Command
{

    const MANIFEST_FILE = 'http://tonypiper.github.io/timelog/manifest.json';

    protected function configure()
    {
        $this->setName('update')
            ->setDescription('Updates timelog.phar to the latest version');
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = new Manager(Manifest::loadFile(self::MANIFEST_FILE));
        $manager->update($this->getApplication()->getVersion(), true);
    }

}
