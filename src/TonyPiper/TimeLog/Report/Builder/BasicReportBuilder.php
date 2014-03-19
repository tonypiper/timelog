<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 16:03
 */

namespace TonyPiper\TimeLog\Report\Builder;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use string;
use TonyPiper\TimeLog\Model\ActivityCollection;
use TonyPiper\TimeLog\Model\GroupedActivityCollection;
use Twig_Environment;
use Twig_Extension;

/**
 * Class ReportBuilder
 * @package TonyPiper\TimeLog
 */
class BasicReportBuilder extends ReportBuilder implements ReportBuilderInterface
{

    /**
     * @param  ActivityCollection $activities
     * @param                     $sortOrder
     * @return string
     */
    public function doRender(ActivityCollection $activities, $sortOrder = null)
    {
        return $this->getTwig()->render(
            'basic.txt.twig',
            array('activities' => $this->sort($activities, $sortOrder, 'dateStart'))
        );
    }

    /**
     * @return string[]
     */
    public function getValidSortOrder()
    {
        return array('description', 'dateStart', 'dateEnd', 'duration');
    }

    /**
     * @return array
     */
    public function getValidFormats()
    {
        return array('text');
    }

}
