<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 19/03/2014
 * Time: 08:47
 */

namespace TonyPiper\TimeLog\Twig\Extension;


class ReportFilterExtension extends \Twig_Extension
{

    /**
     * @var array
     */
    private $parameters;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'reportFilter';
    }

    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('filter', array($this, "reportFilter")));
    }

    public function reportFilter($text)
    {
        foreach ($this->parameters as $filter) {
            $text = preg_replace($filter[0], $filter[1], $text);
        }

        return $text;
    }
}