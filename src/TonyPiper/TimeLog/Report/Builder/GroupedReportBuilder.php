<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 16:03
 */

namespace TonyPiper\TimeLog\Report\Builder;

use string;
use TonyPiper\TimeLog\Model\ActivityCollection;
use TonyPiper\TimeLog\Model\GroupedActivityCollection;

/**
 * Class ReportBuilder
 * @package TonyPiper\TimeLog
 */
class GroupedReportBuilder extends ReportBuilder
{

    /**
     * @param  ActivityCollection $activities
     * @param                     $sortOrder
     * @return string
     */
    public function doRender(ActivityCollection $activities, $sortOrder = null)
    {
        $groupedActivities = GroupedActivityCollection::fromActivityCollection($activities);

        return $this->getTwig()->render(
            'grouped.txt.twig',
            array('groupedActivities' => $this->sort($groupedActivities, $sortOrder, 'description'))
        );
    }

    /**
     * @return string[]
     */
    public function getValidSortOrder()
    {
        return array('description', 'duration');
    }

    /**
     * @return array
     */
    public function getValidFormats()
    {
        return array('text');
    }

}
