<?php

/**
 * This class returns a string with a image uri
 *
 * @package Mundipagg\Tmdb\HTTPClient\Image
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\HTTPClient\Image;

class ImageUri implements ImageUriInterface
{
    private $imageUri = null;

    /**
     * Image Uri construct
     *
     * @param string $imageUri
     */
    public function __construct(string $imageUri = null)
    {
        $this->imageUri = $imageUri;
    }

    /**
     * @param  string $imageUri
     * @return Mundipagg\Tmdb\HTTPClient\Image\ImageUriInterface $this
     */
    public function setImageUri(string $imageUri): ImageUriInterface
    {
        $this->imageUri = $imageUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUri(): string
    {
        return  $this->imageUri ?? ImageUriInterface::IMAGE_URI;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getImageUri();
    }
}