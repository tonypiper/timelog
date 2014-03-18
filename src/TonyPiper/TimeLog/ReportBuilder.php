<?php
/**
 * Created by PhpStorm.
 * User: tpiper
 * Date: 14/03/2014
 * Time: 16:03
 */

namespace TonyPiper\TimeLog;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use TonyPiper\TimeLog\Model\ActivityCollection;
use TonyPiper\TimeLog\Model\GroupedActivityCollection;
use Twig_Environment;

/**
 * Class ReportBuilder
 * @package TonyPiper\TimeLog
 */
class ReportBuilder
{

    private $twig;

    /**
     *
     */
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/Report');
        $this->twig = new Twig_Environment($loader);
    }

    /**
     * @param  ActivityCollection $activities
     * @param                     $sortOrder
     * @param  bool               $grouped
     * @return string
     */
    public function generateReport(ActivityCollection $activities, $sortOrder = null, $grouped = false)
    {
        if ($grouped) {
            return $this->groupedReport($activities, $sortOrder);
        }

        return $this->basicReport($activities, $sortOrder);
    }

    /**
     * @param  ActivityCollection $activities
     * @param                     $sortOrder
     * @return string
     */
    public function basicReport(ActivityCollection $activities, $sortOrder = null)
    {
        return $this->twig->render(
            'basic.txt.twig',
            array('activities' => $this->sort($activities, $sortOrder, 'dateStart'))
        );
    }

    /**
     * @param  ActivityCollection $activities
     * @param                     $sortOrder
     * @return string
     */
    public function groupedReport(ActivityCollection $activities, $sortOrder = null)
    {
        $groupedActivities = GroupedActivityCollection::fromActivityCollection($activities);

        return $this->twig->render(
            'grouped.txt.twig',
            array('groupedActivities' => $this->sort($groupedActivities, $sortOrder, 'description'))
        );
    }

    /**
     * @param  ArrayCollection|ActivityCollection $activities
     * @param                                     $sortOrder
     * @param                                     string $defaultSortOrder
     * @return ArrayCollection
     */
    protected function sort(ArrayCollection $activities, $sortOrder, $defaultSortOrder)
    {
        if ($sortOrder == null) {
            $sortOrder = $defaultSortOrder;
        }
        if ($sortOrder == 'duration') {
            $sortOrder = 'durationInSeconds';
        }
        $criteria = Criteria::create()->orderBy(array($sortOrder => Criteria::ASC));

        return $activities->matching($criteria);

    }

    /**
     * @param $sortOrder
     * @return bool
     */
    public function validateSortOrder($sortOrder)
    {
        return $sortOrder ==null || in_array($sortOrder, $this->getValidSortOrder());
    }

    /**
     * @return string[]
     */
    public function getValidSortOrder()
    {
        return array('description', 'dateStart', 'dateEnd', 'duration');
    }

}
