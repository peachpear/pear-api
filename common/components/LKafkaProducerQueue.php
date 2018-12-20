<?php
namespace common\components;

use common\misc\LUtil;
use Kafka\Producer;
use Kafka\ProducerConfig;
use yii\base\Component;

/**
 * Created by PhpStorm.
 * User: iBaiYang
 * Date: 2018/3/30
 * Time: 上午11:37
 */

class LKafkaProducerQueue extends Component
{

    public $requireAck = 0;
    public $isAsyn = true;
    public $produceInterval = 5;
    public $metadata;
    public static $defaultMetadata = array(
        "brokerVersion" =>  "1.0.0",
        "requestTimeoutMs"  =>  "6000",
        "refreshIntervalMs" =>  "60000",
        "maxAgeMs"          =>  "10000",
    );
    public $timeout = 3000;
    private $clientId;
    public $messageMaxBytes = 10240;//10kb
    public $config;
    

    public function setClientId()
    {
        if (!$this->clientId) {
            if (LUtil::isCli())
            {
                $this->clientId = LUtil::getRandChar(8).":php-api:cli";
            }
            else
            {
                $this->clientId = $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].":php-api";
            }

        }
    }

    public function getClientId()
    {
        if (!$this->clientId) {
            $this->setClientId();
        }
        return $this->clientId;
    }


    public function initConfig($force = false)
    {
        if (!$this->config || !$this->config instanceof ProducerConfig || $force) {
            $config = ProducerConfig::getInstance();
            if (isset($this->metadata["brokerList"])) {
                $config->setMetadataBrokerList($this->metadata["brokerList"]);
            }
            else {
                $config->setMetadataBrokerList("192.168.40.122:9092");
            }
            if (isset($this->metadata['brokerVersion'])) {
                $config->setBrokerVersion($this->metadata['brokerVersion']);
            }
            else {
                $config->setBrokerVersion(self::$defaultMetadata['brokerVersion']);
            }
            if (isset($this->metadata['requestTimeoutMs'])) {
                $config->setBrokerVersion($this->metadata['requestTimeoutMs']);
            }
            else {
                $config->setBrokerVersion(self::$defaultMetadata['requestTimeoutMs']);
            }
            if (isset($this->metadata['refreshIntervalMs'])) {
                $config->setBrokerVersion($this->metadata['refreshIntervalMs']);
            }
            else {
                $config->setBrokerVersion(self::$defaultMetadata['brokerVersion']);
            }
            if (isset($this->metadata['maxAgeMs'])) {
                $config->setBrokerVersion($this->metadata['maxAgeMs']);
            }
            else {
                $config->setBrokerVersion(self::$defaultMetadata['maxAgeMs']);
            }
            $config->setRequiredAck($this->requireAck);
            $config->setIsAsyn($this->isAsyn);
            $config->setProduceInterval($this->produceInterval);
            $config->setTimeout($this->timeout);
            $config->setClientId($this->getClientId());
            $config->setMessageMaxBytes($this->messageMaxBytes);
            $this->config = $config;
        }
    }

    public function init() {
        parent::init();
        if (!$this->config || !$this->config instanceof ProducerConfig) {
            $this->initConfig();
        }
    }

    public function send($message)
    {
        if (!$this->config || !$this->config instanceof ProducerConfig) {
            $this->initConfig();
        }
        $producer = new Producer();
        return $producer->send($message);
    }

}



