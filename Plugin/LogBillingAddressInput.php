<?php

namespace MageWorx\CheckoutLogger\Plugin;

use Magento\Framework\Serialize\Serializer\Json;

class LogBillingAddressInput
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var Json
     */
    private $jsonSerializer;

    /**
     * @param Json $jsonSerializer
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\Serialize\Serializer\Json $jsonSerializer,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->logger = $logger;
    }

    /**
     * Log billing address data and payment method data
     *
     * @param $subject
     * @param $result
     * @return mixed
     */
    public function afterGetInputData($subject, $result)
    {
        if (isset($result['billingAddress'])) {
            $data = $this->jsonSerializer->serialize($result);
            $this->logger->debug($data);
        }

        return $result;
    }
}
