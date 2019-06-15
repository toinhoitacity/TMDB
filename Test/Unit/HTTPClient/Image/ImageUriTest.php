<?php

namespace Mundipagg\Tmdb\Test\Unit\HTTPClient\Image;

use \PHPUnit\Framework\TestCase;
use Mundipagg\Tmdb\HTTPClient\Image\ImageUri;

/**
 * Class ImageUriTest
 */
class ImageUriTest extends TestCase
{
    const IMAGE_URI = 'https://dummyimage.com/300x300/ffff00/000000&text=No+Image+Available';

    /**
     * @test
     */
    public function testShouldAddImageUri()
    {
        $objImageUri = new ImageUri(self::IMAGE_URI);
        $this->assertEquals(self::IMAGE_URI, $objImageUri);
    }

    /**
     * @test
     */
    public function testGetImageUri()
    {
        $objImageUri = new ImageUri(self::IMAGE_URI);
        $this->assertEquals(self::IMAGE_URI, $objImageUri->getImageUri());
    }

    /**
     * @test
     * @depends testShouldAddImageUri
     */
    public function testSetImageUri()
    {
        $objImageUri = new ImageUri('https://www.google.com');
        $objImageUri->setImageUri(self::IMAGE_URI);
        $this->assertEquals(self::IMAGE_URI, $objImageUri);
    }
}
