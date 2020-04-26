<?php


namespace AZMicroAssets\Bootstrap;


use Psr\Log\LoggerInterface;

class LoggerService
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
