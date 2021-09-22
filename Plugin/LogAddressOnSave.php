<?php

namespace MageWorx\CheckoutLogger\Plugin;

use Magento\Framework\Serialize\Serializer\Json;

class LogAddressOnSave
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
     * Log address data before save
     *
     * @param $subject
     */
    public function aroundSave($subject, callable $proceed)
    {
        /** @var \Magento\Quote\Model\Quote\Address $address */
        $address = $subject;
        $addressId = $address->getId();
        $data = [
            'id' => $addressId,
            'type' => $address->getAddressType(),
            'base_grand_total' => $address->getBaseGrandTotal(),
            'country' => $address->getCountry(),
            'country_id' => $address->getCountryId(),
            'customer_id' => $address->getCustomerId(),
            'firstname' => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'zip' => $address->getPostcode(),
            'created_at' => $address->getCreatedAt(),
            'updated_at' => $address->getUpdatedAt(),
            'payment_method' => $address->getPaymentMethod(),
            'quote_id' => $address->getQuoteId()
        ];
        $dataSerialized = $this->jsonSerializer->serialize($data);
        $this->logger->debug('Saving address with id: ' . $addressId);
        $this->logger->debug($dataSerialized);

        return $proceed();
    }
}
