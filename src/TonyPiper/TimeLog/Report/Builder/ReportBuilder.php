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
use TonyPiper\TimeLog\Model\ActivityCollection;
use Twig_Environment;
use Twig_Extension;

/**
 * Class ReportBuilder
 * @package TonyPiper\TimeLog
 */
abstract class ReportBuilder
{

    private $twig;

    /**
     *
     */
    public function __construct(Twig_Extension $extension)
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../templates');
        $this->twig = new Twig_Environment($loader);
        $this->twig->addExtension($extension);
    }

    /**
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @param  ActivityCollection $activities
     * @param  string|null        $sortOrder
     * @return string
     */
    final public function render(ActivityCollection $activities, $sortOrder = null)
    {
        $this->validateSortOrder($sortOrder);

        return $this->doRender($activities, $sortOrder);
    }

    /**
     * @param  ActivityCollection $activities
     * @param  string|null        $sortOrder
     * @return string
     * @throws \Exception
     */
    abstract protected function doRender(ActivityCollection $activities, $sortOrder = null);

    /**
     * @param  ArrayCollection|ActivityCollection $activities
     * @param  string                             $sortOrder
     * @param  string                             $defaultSortOrder
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
     * @param  string                    $sortOrder
     * @throws \InvalidArgumentException
     */
    public function validateSortOrder($sortOrder)
    {
        if (!$this->isValidSortOrder($sortOrder)) {
            throw new \InvalidArgumentException(sprintf('Invalid Sort Order %s - choose one of %s', $sortOrder, join(
                ", ",
                $this->getValidSortOrder()
            )));
        }
    }

    /**
     * @param  string $sortOrder
     * @return bool
     */
    public function isValidSortOrder($sortOrder)
    {
        return $sortOrder === null || in_array($sortOrder, $this->getValidSortOrder());
    }

    /**
     * @return array
     */
    abstract public function getValidSortOrder();

}
