<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 15/03/2014
 * Time: 13:11
 */
namespace TonyPiper\TimeLog\Storage;

use TonyPiper\TimeLog\Model\Activity;

/**
 * Class FileStorage
 * @package TonyPiper\TimeLog\Storage
 */
interface Storage
{
    /**
     * @param  \DateTime                                   $asAt
     * @return \TonyPiper\TimeLog\Model\ActivityCollection
     */
    public function getActivities(\DateTime $asAt);

    /**
     * @param Activity $activity
     * @return void
     */
    public function saveActivity(Activity $activity);

    /**
     * @param  \DateTime $asAt
     * @return string
     */
    public function getLocationReference(\DateTime $asAt);
}
