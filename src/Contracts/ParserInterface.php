<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-04-01
 * GitHub: viktor-melnikov
 */

namespace Requester\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface ParserInterface
 * @package Requester\Contracts
 */
interface ParserInterface
{
    /**
     * @param string $data
     * @return mixed
     */
    public function parse(string $data);

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return Collection
     */
    public function toCollection(): Collection;
}