<?php

namespace Mundipagg\Tmdb\Test\Unit\Helper;

use \PHPUnit\Framework\TestCase;
use Mundipagg\Tmdb\Helper\Data;
//use \Magento\Framework\App\ObjectManager;
use \Magento\TestFramework\ObjectManager;

/**
 * Class ApiTokenTest
 */
class DataTest extends TestCase
{
    const BASE_URI_API = "https://api.themoviedb.org/3/movie/550";
    const API_KEY = "6e60d556d8ca594a46e2b7e0639ca777";

    /**
     * @test
     */
    public function testGetConfigValue()
    {
//        $dataHelper = new Data();
//        $objectManager = ObjectManager::getInstance();
//        $dataHelper = $objectManager->get('Mundipagg\Tmdb\Helper\Data');
        $objectManager = new ObjectManager($this);

        $dataHelper = $objectManager->getObject(Data::class);

        $this->assertEquals(self::BASE_URI_API, $dataHelper->getConfigValue("tmdb/general/base_uri_api"));
        $this->assertEquals(self::API_KEY, $dataHelper->getConfigValue("tmdb/general/api_key"));
    }

    /**
     * @test
     */
    public function testGetGeneralConfig()
    {
//        $dataHelper = new Data();
        $objectManager = ObjectManager::getInstance();
        $dataHelper = $objectManager->get('Mundipagg\Tmdb\Helper\Data');
        $this->assertEquals(self::BASE_URI_API, $dataHelper->getGeneralConfig("base_uri_api"));
        $this->assertEquals(self::API_KEY, $dataHelper->getGeneralConfig("api_key"));
    }
}
