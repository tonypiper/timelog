<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 08:56
 */

namespace TonyPiper\TimeLog\Model;

/**
 * Class Activity
 * @package TonyPiper\TimeLog
 */
class Activity
{

    /** @var \DateTime */
    private $dateStart;

    /** @var \DateTime */
    private $dateEnd;
    private $description;

    /**
     * @param \DateTime $dateStart
     * @param           $description
     */
    public function __construct(\DateTime $dateStart, $description)
    {
        $this->dateStart = $dateStart;
        $this->description = $description;
        $this->dateEnd = null;
    }

    /**
     * @param \DateTime $dateEnd
     */
    public function setDateEnd(\DateTime $dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \DateInterval
     */
    public function getDuration()
    {
        if ($this->dateStart == null || $this->dateEnd == null) {
            return null;
        }

        return $this->dateEnd->diff($this->dateStart);
    }

    /**
     * @return integer
     */
    public function getDurationInSeconds()
    {
        if (!$this->getDuration()) {
            return 0;
        }

        return $this->dateEnd->getTimestamp() - $this->getDateStart()->getTimestamp();
    }
}
