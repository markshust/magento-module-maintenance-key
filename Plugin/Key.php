<?php
namespace MarkShust\MaintenanceKey\Plugin;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\MaintenanceMode;

class Key
{
    /**
     * Hash file name.
     */
    const KEY_FILENAME = '.maintenance.key';

    /**
     * Path to store files.
     * @var Filesystem\Directory\WriteInterface
     */
    protected $flagDir;

    /**
     * Request object.
     * @var Http
     */
    protected $request;

    /**
     * Key constructor.
     * @param Filesystem $filesystem
     * @param Http $request
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(Filesystem $filesystem, Http $request)
    {
        $this->flagDir = $filesystem->getDirectoryWrite(MaintenanceMode::FLAG_DIR);
        $this->request = $request;
    }

    /**
     * Checks whether maintenance mode is on.
     * @param MaintenanceMode $subject
     * @param $result
     * @return bool
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function afterIsOn(MaintenanceMode $subject, $result)
    {
        if ($this->flagDir->isExist($subject::FLAG_FILENAME)
            && $info = $this->getKeyInfo()
        ) {
            $maintenanceKey = $this->request->getParam('MAINTENANCE_KEY');

            return !in_array($maintenanceKey, $info);
        }

        return $result;
    }

    /**
     * Get list of hash addresses effective for maintenance mode.
     * @return array
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getKeyInfo()
    {
        if ($this->flagDir->isExist(self::KEY_FILENAME)) {
            $temp = $this->flagDir->readFile(self::KEY_FILENAME);
            return explode(',', trim($temp));
        } else {
            return [];
        }
    }
}
