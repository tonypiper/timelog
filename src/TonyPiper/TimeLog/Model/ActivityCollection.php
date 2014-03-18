<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 08:55
 */

namespace TonyPiper\TimeLog\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ActivityCollection
 * @package TonyPiper\TimeLog
 */
class ActivityCollection extends ArrayCollection
{

    /**
     * @param Activity $activity
     */
    public function addActivity(Activity $activity)
    {
        $this->add($activity);
    }

    /**
     * @return Activity
     */
    public function getFirst()
    {
        return $this->first();
    }

    /**
     * @return Activity
     */
    public function getLast()
    {
        return $this->last();
    }

    /**
     * @return \DateInterval
     */
    public function getTotalDuration()
    {
        $startDate = new \DateTime('00:00');
        $endDate = clone $startDate;

        /** @var $activity Activity */
        foreach ($this->getIterator() as $activity) {
            $duration = $activity->getDuration();
            if ($duration != null) {
                $endDate->add($activity->getDuration());
            }
        }

        return $endDate->diff($startDate);
    }

    /**
     * @param ActivityCollection $activityCollection
     */
    public function addActivityCollection(ActivityCollection $activityCollection)
    {
        foreach ($activityCollection as $activity) {
            $this->addActivity($activity);
        }
    }

}
