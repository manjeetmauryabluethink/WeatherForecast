<?php
declare(strict_types=1);

namespace Bluethinkinc\WeatherForecast\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template\Context;
use Bluethinkinc\WeatherForecast\Service\ApiClient;

class WeatherForecast extends Template implements BlockInterface
{

    protected $_template = "widget/weather_forecast.phtml";

    /**
     * @var ApiClient
     */
    private $apiClient;

    public function __construct(
        Context $context,
        ApiClient $apiClient,
        array $data = []
    ) {
        $this->apiClient = $apiClient;
        parent::__construct($context, $data);
    }

    public function getRequestData()
    {
        $this->apiClient->execute();
    }

}

