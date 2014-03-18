<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 15/03/2014
 * Time: 10:07
 */

namespace TonyPiper\TimeLog\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class GroupedActivityCollection
 * @package TonyPiper\TimeLog
 */
class GroupedActivityCollection extends ArrayCollection
{

    /**
     * @param  ActivityCollection        $activities
     * @param  bool                      $toLowerCase
     * @return GroupedActivityCollection
     */
    public static function fromActivityCollection(ActivityCollection $activities, $toLowerCase = true)
    {
        $groupedActivities = new self;
        /** @var $activity Activity */
        foreach ($activities as $activity) {
            $groupedActivities->addActivity($activity, $toLowerCase);
        }

        return $groupedActivities;

    }

    /**
     * @param Activity $activity
     * @param bool     $toLowerCase
     */
    public function addActivity(Activity $activity, $toLowerCase = true)
    {

        $description = $activity->getDescription();
        if ($toLowerCase) {
            $description = strtolower($description);
        }

        $groupedActivity = $this->get($description);

        if (!$groupedActivity) {
            $groupedActivity = new GroupedActivity($description);
        }

        $groupedActivity->addActivity($activity);
        $this->set($description, $groupedActivity);

    }

    /**
     * @return \DateInterval
     */
    public function getTotalDuration()
    {
        $activities = new ActivityCollection();
        /** @var $groupedActivity GroupedActivity */
        foreach ($this->getIterator() as $groupedActivity) {
            $activities->addActivityCollection($groupedActivity->getActivities());
        }

        return $activities->getTotalDuration();
    }
}
