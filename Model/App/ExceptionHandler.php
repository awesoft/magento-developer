<?php

namespace Awesoft\Developer\Model\App;

use Awesoft\Developer\Model\Config;
use Awesoft\Developer\Model\Whoops\Handler\PrettyPageHandler;
use Exception;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\ExceptionHandler as AppExceptionHandler;
use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\App\Response\Http as Response;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;
use Whoops\Run;

class ExceptionHandler extends AppExceptionHandler
{
    /**
     * @param PrettyPageHandler $prettyPageHandler
     * @param Config $config
     * @param EncryptorInterface $encryptor
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly PrettyPageHandler $prettyPageHandler,
        private readonly Config $config,
        EncryptorInterface $encryptor,
        Filesystem $filesystem,
        LoggerInterface $logger,
    ) {
        parent::__construct($encryptor, $filesystem, $logger);
    }

    /**
     * @param Bootstrap $bootstrap
     * @param Exception $exception
     * @param Response $response
     * @param Request $request
     * @return bool
     */
    public function handle(Bootstrap $bootstrap, Exception $exception, Response $response, Request $request): bool
    {
        if ($this->config->useWhoops()) {
            $editor = $this->config->getWhoopsEditor();
            if ($editor) {
                $this->prettyPageHandler->setEditor($editor);
            }

            $whoops = new Run();
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            $whoops->pushHandler($this->prettyPageHandler);

            $response->setHttpResponseCode($exception->getCode() ?: 500);
            $response->setBody($whoops->handleException($exception));
            $response->sendResponse();

            return true;
        }

        return parent::handle($bootstrap, $exception, $response, $request);
    }
}