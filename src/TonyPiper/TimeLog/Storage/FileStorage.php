<?php
/**
 * Created by PhpStorm.
 * User: tonypiper
 * Date: 15/03/2014
 * Time: 13:04
 */

namespace TonyPiper\TimeLog\Storage;

use Symfony\Component\Filesystem\Filesystem;
use TonyPiper\TimeLog\Model\Activity;
use TonyPiper\TimeLog\Model\ActivityCollection;

/**
 * Class FileStorage
 * @package TonyPiper\TimeLog\Storage
 */
class FileStorage implements Storage
{

    private $basePath;
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fileSystem;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $fileSystem
     * @param                                          $basePath
     */
    public function __construct(FileSystem $fileSystem, $basePath)
    {
        $this->basePath = $basePath;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @param  \DateTime          $asAt
     * @return ActivityCollection
     */
    public function getActivities(\DateTime $asAt)
    {
        $activities = new ActivityCollection();

        try {
            $lines = $this->readFile($asAt);
        } catch (\InvalidArgumentException $exception) {
            return $activities;
        }

        /** @var $previousActivity Activity */
        $previousActivity = null;

        foreach ($lines as $line) {
            $activity = $this->fromLine($line);
            $activities->addActivity($activity);

            if ($previousActivity) {
                $previousActivity->setDateEnd($activity->getDateStart());
            }

            $previousActivity = $activity;
        }

        return $activities;

    }

    /**
     * @param Activity $activity
     */
    public function saveActivity(Activity $activity)
    {
        $fileName = $this->getLocationReference($activity->getDateStart());
        $dirName = dirname($fileName);
        if (!is_dir($dirName)) {
            $this->fileSystem->mkdir($dirName, 0777);
        }
        file_put_contents(
            $fileName,
            $activity->getDateStart()->format('Y-m-d H:i:s') . ' | ' . $activity->getDescription() . PHP_EOL,
            FILE_APPEND
        );

    }

    /**
     * @param  string   $line
     * @return Activity
     */
    public function fromLine($line)
    {
        list($dateStart, $description) = explode('|', $line);

        return new Activity(new \DateTime(trim($dateStart)), trim($description));
    }

    /**
     * @param $asAt
     * @throws \InvalidArgumentException
     * @internal param string $fileName
     * @return array
     */
    protected function readFile(\DateTime $asAt)
    {
        $fileName=$this->getLocationReference($asAt);

        if (!$this->fileSystem->exists($fileName)) {
            throw new \InvalidArgumentException('Cannot open file ' . $fileName . ' for reading');
        }

        return file($fileName);
    }

    /**
     * @param  \DateTime $asAt
     * @return string
     */
    public function getLocationReference(\DateTime $asAt)
    {
        return join(
            DIRECTORY_SEPARATOR,
            array($this->basePath, $asAt->format('Y'), $asAt->format('m'), $asAt->format('Y-m-d'))
        ) . '.txt';
    }
}
