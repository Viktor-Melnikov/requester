<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-30
 * GitHub: viktor-melnikov
 */

namespace Requester\Concerns;

/**
 * Trait HashRequest
 * @package Requester\Helpers
 */
trait HashRequest
{
    /**
     * @var string|null
     */
    private $alias = null;

    /**
     * @var string
     */
    private $hash;

    /**
     * @param string $alias
     * @return $this
     */
    public function withAlias(string $alias)
    {
        $this->alias = $alias;

        return $this;
    }

    private function generateHash()
    {
        $this->hash = md5($this->uri . serialize($this->headers) . serialize($this->payload));
    }
}