<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 15:49
 */

namespace TonyPiper\TimeLog\Repository;

use TonyPiper\TimeLog\Model\Activity;
use TonyPiper\TimeLog\Storage\Storage;

/**
 * Class ActivityRepository
 * @package TonyPiper\TimeLog\Repository
 */
class ActivityRepository
{
    /**
     * @var \TonyPiper\TimeLog\Storage\Storage
     */
    private $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param  null|string|\DateTime                       $asAt
     * @return \TonyPiper\TimeLog\Model\ActivityCollection
     */
    public function findActivities($asAt = null)
    {
        return $this->storage->getActivities($this->getAsat($asAt));
    }

    /**
     * @param  Activity $activity
     * @return mixed
     */
    public function save(Activity $activity)
    {
        return $this->storage->saveActivity($activity);
    }

    /**
     * @param  \DateTime|string|null $asAt
     * @return \DateTime
     */
    protected function getAsat($asAt = null)
    {
        if ($asAt === null) {
            return new \DateTime();
        }

        if ($asAt instanceof \DateTime) {
            return $asAt;
        }

        return new \DateTime($asAt);
    }

}
