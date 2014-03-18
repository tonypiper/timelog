<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 15/03/2014
 * Time: 10:20
 */

namespace TonyPiper\TimeLog\Model;

/**
 * Class GroupedActivity
 * @package TonyPiper\TimeLog
 */
class GroupedActivity
{

    private $description;

    /** @var ActivityCollection */
    private $activities;

    /**
     * @param string $description
     */
    public function __construct($description)
    {
        $this->description = $description;
        $this->activities = new ActivityCollection();
    }

    /**
     * @param Activity $activity
     */
    public function addActivity(Activity $activity)
    {
        $this->activities->addActivity($activity);
    }

    /**
     * @return ActivityCollection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \DateInterval
     */
    public function getDuration()
    {
        return $this->activities->getTotalDuration();
    }

    /**
     * @return null|integer
     */
    public function getDurationInSeconds()
    {
        if (!$this->getDuration()) {
            return null;
        }

        $seconds = 0;
        /** @var $activity Activity */
        foreach ($this->activities as $activity) {
            $seconds += $activity->getDurationInSeconds();
        }

        return $seconds;

    }

}
