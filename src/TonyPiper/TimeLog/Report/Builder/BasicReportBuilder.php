<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 16:03
 */

namespace TonyPiper\TimeLog\Report\Builder;

use TonyPiper\TimeLog\Model\ActivityCollection;

/**
 * Class ReportBuilder
 * @package TonyPiper\TimeLog
 */
class BasicReportBuilder extends ReportBuilder implements ReportBuilderInterface
{

    /**
     * @param  ActivityCollection $activities
     * @param  string|null        $sortOrder
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
     * @return string[]
     */
    public function getValidFormats()
    {
        return array('text');
    }

}
