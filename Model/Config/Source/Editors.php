<?php

namespace Awesoft\Developer\Model\Config\Source;

use Awesoft\Developer\Model\Whoops\Handler\PrettyPageHandler;
use Magento\Framework\Data\OptionSourceInterface;

class Editors implements OptionSourceInterface
{
    /**
     * @param PrettyPageHandler $prettyPageHandler
     */
    public function __construct(
        private readonly PrettyPageHandler $prettyPageHandler,
    ) {
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [['value' => '', 'label' => '']];
        foreach ($this->prettyPageHandler->getEditors() as $editor) {
            $options[] = ['value' => $editor, 'label' => $editor];
        }

        return $options;
    }
}