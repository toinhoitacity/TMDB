<?php

/**
 * This class returns datas from xml config file
 *
 * @package Mundipagg\Tmdb\Helper
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data  extends AbstractHelper
{
    const XML_PATH_TMDB = 'tmdb/';
    const XML_PATH_GENERAL = 'general/';

    /**
     * @param  string $field
     * @param  int $storeId
     * @return string
     */
    public function getConfigValue(string $field, int $storeId = null): string
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @param  string $code
     * @param  int $storeId
     * @return string
     */
    public function getGeneralConfig(string $code, int $storeId = null): string
    {
        return $this->getConfigValue(self::XML_PATH_TMDB . self::XML_PATH_GENERAL. $code, $storeId);
    }
}