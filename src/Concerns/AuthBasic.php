<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-30
 * GitHub: viktor-melnikov
 */

namespace Requester\Concerns;

/**
 * Trait AuthBasic
 * @package Requester\Helpers
 */
trait AuthBasic
{
    /**
     * @return $this
     */
    public function withAuthBasic()
    {
        [$username, $password] = array_values($this->config->get('auth')['basic']);

        if (!empty($args = func_get_args())) {
            [$username, $password] = $args;
        }

        return $this->withOption('auth', [$username, $password]);
    }

    /**
     * @return $this
     */
    public function withoutAuthBasic()
    {
        return $this->withoutOption('auth');
    }
}