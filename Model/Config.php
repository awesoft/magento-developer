<?php

namespace Awesoft\Developer\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;

class Config
{
    public const PATH_USE_WHOOPS = 'awesoft/developer/use_whoops';
    public const PATH_WHOOPS_EDITOR = 'awesoft/developer/whoops_editor';

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param State $state
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly State $state,
    ) {
    }

    /**
     * @return bool
     */
    public function useWhoops(): bool
    {
        return (bool)$this->getValue(self::PATH_USE_WHOOPS);
    }

    /**
     * @return string
     */
    public function getWhoopsEditor(): string
    {
        return (string)$this->getValue(self::PATH_WHOOPS_EDITOR);
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function getValue(string $key): mixed
    {
        if ($this->state->getMode() !== State::MODE_DEVELOPER) {
            return false;
        }

        return $this->scopeConfig->getValue($key);
    }
}