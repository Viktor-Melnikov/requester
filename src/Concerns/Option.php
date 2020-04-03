<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-30
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Concerns;

/**
 * Trait Option
 * @package Requester\Helpers
 */
trait Option
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return $this
     */
    public function withOption()
    {
        $this->options += $this->parseArguments(func_get_args());

        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function withoutOption(string $key)
    {
        if(isset($this->options[$key])) {
            unset($this->options[$key]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}