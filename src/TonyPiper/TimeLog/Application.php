<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 18/03/2014
 * Time: 19:27
 */

namespace TonyPiper\TimeLog;

use Phar;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class Application
 * @package TonyPiper\TimeLog
 */
class Application
{

    /**
     * @var ConsoleApplication
     */
    private $application;

    public function boot()
    {
        $root = __DIR__ . '/../../..';

        $pharPath = Phar::running(false);
        if (!empty($pharPath)) {
            $root = dirname($pharPath);
        }

        $container = new ContainerBuilder();
        $container->setParameter('root', $root);
        $container->setParameter('user_home', getenv('HOME'));

        $loader = new YamlFileLoader($container, new FileLocator($root));
        $loader->load($root . '/app/config/services.yml');

        $this->application = new ConsoleApplication('timelog', '@package_version@');

        $services = $container->findTaggedServiceIds('console.command');
        foreach (array_keys($services) as $serviceId) {
            /** @var $service Command */
            $service = $container->get($serviceId);
            $this->application->add($service);
        }

    }

    public function run()
    {
        $this->application->run();
    }

}
