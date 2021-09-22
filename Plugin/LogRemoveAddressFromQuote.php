<?php

namespace MageWorx\CheckoutLogger\Plugin;

class LogRemoveAddressFromQuote
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Log address removing
     *
     * @param $subject
     * @param $addressId
     * @return mixed
     */
    public function beforeRemoveAddress($subject, $addressId)
    {
        $this->logger->debug('Removing address with id: ' . $addressId);

        return [$addressId];
    }
}
