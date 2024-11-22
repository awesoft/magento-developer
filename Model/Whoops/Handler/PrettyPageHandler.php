<?php

namespace Awesoft\Developer\Model\Whoops\Handler;

use Whoops\Handler\PrettyPageHandler as WhoopsPrettyPageHandler;

class PrettyPageHandler extends WhoopsPrettyPageHandler
{
    /**
     * @return array
     */
    public function getEditors(): array
    {
        return array_keys($this->editors);
    }
}