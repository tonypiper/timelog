<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 18/03/2014
 * Time: 19:27
 */

namespace TonyPiper\TimeLog;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Yaml\Yaml;

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

    /** @var  ContainerBuilder */
    private $container;

    public function boot()
    {
        $this->buildContainer();

        $this->application = new ConsoleApplication('timelog', '@package_version@');

        $this->addCommands();

    }

    public function run()
    {
        $this->application->run();
    }

    protected function addCommands()
    {
        $services = $this->container->findTaggedServiceIds('console.command');
        foreach (array_keys($services) as $serviceId) {
            /** @var $service Command */
            $service = $this->container->get($serviceId);
            $this->application->add($service);
        }
    }

    protected function buildContainer()
    {
        $root = __DIR__ . '/../../..';

        $config = Yaml::parse($root . '/app/config/config.yml');
        $parameters = new ParameterBag($config);

        $this->container = new ContainerBuilder($parameters);
        $this->container->setParameter('root', $root);
        $this->container->setParameter('user_home', getenv('HOME'));

        $loader = new YamlFileLoader($this->container, new FileLocator($root));
        $loader->load($root . '/app/config/services.yml');
    }

}
