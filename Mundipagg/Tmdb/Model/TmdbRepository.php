<?php

/**
 * This class a repository for TMDB
 *
 * @package Mundipagg\Tmdb\Model\TmdbRepository
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Model;

use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Mundipagg\Tmdb\Api\Data\TmdbInterface;
use Mundipagg\Tmdb\Api\TmdbRepositoryInterface;
use Mundipagg\Tmdb\HTTPClient\Image\ImageUriInterface;
use Mundipagg\Tmdb\Service\ImportImage;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\StateException;
use Magento\Catalog\Api\Data\ProductInterface;

class TmdbRepository implements TmdbRepositoryInterface
{
    /**
     * @var ProductInterfaceFactory
     */
    private $productFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ImportImage
     */
    private $importImage;

    /**
     * @var ImageUri
     */
    private $imageUri;

    /**
     * @var array
     */
    public $errors = [];

    /**
     * TmdbRepository constructor.
     *
     * @param \Magento\Catalog\Api\Data\ProductInterfaceFactory $productFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Mundipagg\Tmdb\Service\ImportImage $importImage
     * @param \Mundipagg\Tmdb\HTTPClient\Image\ImageUriInterface $imageUri
     */
    public function __construct(
        ProductInterfaceFactory $productFactory,
        ProductRepositoryInterface $productRepository,
        ImportImage $importImage,
        ImageUriInterface $imageUri
    )
    {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->importImage = $importImage;
        $this->imageUri = $imageUri;
    }

    /**
     * Save content.
     *
     * @param \Mundipagg\Tmdb\Api\Data\TmdbInterface $tmdb
     * @return bool
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function save(TmdbInterface $tmdb): bool
    {
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        $product = $this->productFactory->create();
        $product->setSku('MundipaggTmdb' . $tmdb->getMovieId()); // Set your sku here
        $product->setName($tmdb->getTitle()); // Name of Product
        $product->setPrice($tmdb->getPrice()); // price of product

        $product->setAttributeSetId(4); // Attribute set id
        $product->setStatus(1); // Status on product enabled/ disabled 1/0
        $product->setWeight(10); // weight of product
        $product->setVisibility(4); // visibilty of product (catalog / search / catalog, search / Not visible individually)
        $product->setTaxClassId(0); // Tax class id
        $product->setTypeId('simple'); // type of product (simple/virtual/downloadable/configurable)
        $product->setStockData(
            array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1,
                'qty' => 999999999
            )
        );

        try {
            // This is important - the version provided and the version returned will be different objects
            /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
            $product = $this->productRepository->save($product);
        } catch (InputException $inputException) {
            throw $inputException;
        } catch (\Exception $e) {
            throw new StateException(__("The product can't be saved."));
        }

        $this->importImage->execute(
            $product,
            $this->imageUri->setImageUri($tmdb->getImageUrl())->getImageUri(),
            true,
            [
                'image',
                'small_image',
                'thumbnail'
            ]
        );

        return true;
    }

    /**
     * Get product by sku
     *
     * @param string $sku
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProductBySku(string $sku): ProductInterface
    {
        return $this->productRepository->get($sku);
    }
}