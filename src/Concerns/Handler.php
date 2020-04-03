<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-30
 * GitHub: viktor-melnikov
 */

namespace Requester\Concerns;

use Requester\Contracts\HandlerInterface;

/**
 * Trait Handler
 * @package Requester\Helpers
 */
trait Handler
{
    /**
     * @param $handler
     * @return Handler
     * @throws \Exception
     */
    public function withHandler($handler): self
    {
        if (!class_exists($handler)) {
            throw new \Exception('Handler not found');
        }

        if (!in_array(HandlerInterface::class, class_implements($handler))) {
            throw new \RuntimeException('Handler not initialized. Please use Handler class instanceof HandlerInterface.');
        }

        $this->handler = new $handler;

        return $this;
    }

    /**
     * @return mixed
     */
    public function runHandler()
    {
        $arguments    = func_get_args();
        $handleMethod = array_shift($arguments);

        return call_user_func_array([$this->handler->init($this), $handleMethod], $arguments);
    }
}