<?php

declare(strict_types=1);

namespace Requester\Handlers;

/**
 * Class BlackHoleHandler
 *
 * @package Requester\Handlers
 */
class BlackHoleHandler extends Handler
{
    public function beforeExecute()
    {
        // TODO: Implement beforeExecute() method.
    }

    public function beforeExecuteReturn()
    {
        // TODO: Implement beforeExecuteReturn() method.
    }

    /**
     * @param $body
     *
     * @return $this|void
     */
    public function afterExecute($body)
    {
        // TODO: Implement afterExecute() method.
    }


    /**
     * @param $body
     */
    public function afterExecuteReturn($body)
    {
        // TODO: Implement afterExecuteReturn() method.
    }

    /**
     * @param       $message
     * @param array $context
     */
    public function error($message, array $context = [])
    {
        // TODO: Implement error() method.
    }

    /**
     * @param string $body
     *
     * @return mixed
     */
    public function parse($body)
    {
        return $body;
    }

    /**
     * @param mixed $payload
     *
     * @return string
     */
    public function serialize($payload)
    {
        return $payload;
    }
}