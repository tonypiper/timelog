<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 19/03/2014
 * Time: 22:37
 */
namespace TonyPiper\TimeLog\Report\Builder;

use string;
use TonyPiper\TimeLog\Model\ActivityCollection;


/**
 * Class ReportBuilder
 * @package TonyPiper\TimeLog
 */
interface ReportBuilderInterface
{
    /**
     * @param  ActivityCollection $activities
     * @param                     $sortOrder
     * @return string
     */
    public function doRender(ActivityCollection $activities, $sortOrder = null);

    /**
     * @return string[]
     */
    public function getValidSortOrder();

    /**
     * @return array
     */
    public function getValidFormats();
}