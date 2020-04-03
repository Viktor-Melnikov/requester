<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-28
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Handlers;

use Illuminate\Support\Collection;

class JsonHandler extends Handler
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
     * @return Collection
     */
    public function parse($body): Collection
    {
        return app('JsonParser')
            ->parse((string)$body)
            ->toCollection();
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