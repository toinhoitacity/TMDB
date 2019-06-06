<?php

/**
 * This class import image to a product
 *
 * @package Mundipagg\Tmdb\Service\ImportImageService
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Service;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Mundipagg\Tmdb\HTTPClient\Image\ImageUriInterface;

class ImportImage implements ImportImageInterface
{
    /**
     * Directory List
     *
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * File interface
     *
     * @var File
     */
    protected $file;

    /**
     * ImportImageService constructor
     *
     * @param DirectoryList $directoryList
     * @param File $file
     */
    public function __construct(DirectoryList $directoryList, File $file) {
        $this->directoryList = $directoryList;
        $this->file = $file;
    }

    /**
     * Main service executor
     *
     * @param Product $product
     * @param string $imageUrl
     * @param array $imageType
     * @param bool $visible
     *
     * @return bool
     */
    public function execute(Product $product, string $imageUrl, $visible = false, array $imageType = []): bool
    {
        /** @var string $tmpDir */
        $tmpDir = $this->getMediaDirTmpDir();

        $this->file->checkAndCreateFolder($tmpDir);

        /** @var string $newFileName */
        $newFileName = $tmpDir . baseName($imageUrl);

        /** @var bool|string $result */
        $result = $this->file->read($imageUrl, $newFileName);
        if ($result) {
            $product->addImageToMediaGallery($newFileName, $imageType, true, $visible);
        }
        return $result;
    }

    /**
     * Media directory name for the temporary file storage
     * pub/media/tmp
     *
     * @return string
     */
    public function getMediaDirTmpDir(): string
    {
        return $this->directoryList->getPath(DirectoryList::MEDIA) . DIRECTORY_SEPARATOR . ImageUriInterface::IMAGE_PATH;
    }
}