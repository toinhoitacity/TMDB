<?php

/**
 * Interface for import image
 *
 * @package Mundipagg\Tmdb\Service\ImportImageService
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Service;

use Magento\Catalog\Model\Product;

interface ImportImageInterface
{
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
    public function execute(Product $product, string $imageUrl, $visible = false, array $imageType = []): bool;

    /**
     * Media directory name for the temporary file storage
     * pub/media/tmp
     *
     * @return string
     */
    public function getMediaDirTmpDir();
}