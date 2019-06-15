<?php

namespace Mundipagg\Tmdb\Test\Unit\WebService;

use Mundipagg\TMDB\Helper\Data;
use Mundipagg\Tmdb\WebService\TmdbWebService;
use \PHPUnit\Framework\TestCase;

/**
 * Class TmdbWebServiceTest
 */
class TmdbWebServiceTest extends TestCase
{
    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $zendClientFactoryMock;

    /**
     * @var \Magento\Framework\HTTP\ZendClient|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $zendClientMock;

    /**
     * @var \Mundipagg\Tmdb\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataHelperMock;

    /**
     * @var \Magento\Framework\Json\EncoderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $jsonEncoderMock;

    protected function setUp()
    {
        $this->zendClientFactoryMock = $this->getMockBuilder(\Magento\Framework\HTTP\ZendClientFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->zendClientMock = $this->getMockBuilder(\Magento\Framework\HTTP\ZendClient::class)
            ->setMethods(['request', 'setUri', 'setMethod', 'setHeaders', 'setOptions'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataHelperMock = $this->getMockBuilder(Data::class)
            ->setMethods(['getGeneralConfig'])
            ->disableOriginalConstructor()
            ->getMock();


    }

    /**
     * Tests client request with Ok status
     *
     * @return void
     */
    public function testSendRequest()
    {
        $statusOk = '200';
        $uri = 'https://example.com/listener';
        $method = ZendClient::GET;
        $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
        $options = [
            'adapter'   => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
            'maxredirects' => 0,
            'timeout' => 30
        ];
        $apiKey = '6e60d556d8ca594a46e2b7e0639ca777';
        $baseUri = 'https://api.themoviedb.org/3/';
        $apiKeyTag = 'api_key';
        $baseUriApi = 'base_uri_api';

        $this->zendClientMock->expects($this->once())->method('setUri')->with($uri)->willReturnSelf();
        $this->zendClientMock->expects($this->once())->method('setMethod')->with($method)->willReturnSelf();
        $this->zendClientMock->expects($this->once())->method('setHeaders')->with($headers)->willReturnSelf();
        $this->zendClientMock->expects($this->once())->method('setOptions')->with($headers)->willReturnSelf();

        $this->dataHelperMock->expects($this->once())
            ->method('getGeneralConfig')
            ->with($apiKeyTag)
            ->willReturn($apiKey);

        $this->dataHelperMock->expects($this->once())
            ->method('getGeneralConfig')
            ->with($baseUriApi)
            ->willReturn($baseUri);

    }


}
