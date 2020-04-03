<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-28
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Parsers;

use Illuminate\Support\Collection;
use Requester\Contracts\ParserInterface;

class JsonParser implements ParserInterface
{
    /**
     * @var Collection
     */
    private $data;

    /**
     * @param string $data
     * @param bool $object
     * @return mixed
     * @throws \Exception
     */
    public function parse(string $data)
    {
        if ($this->isValidJson($data)) {
            $this->data = collect(json_decode($data, true));

            return $this;
        }

        throw new \Exception('Getting string is not valid json');
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data->toArray();
    }

    /**
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return $this->data;
    }

    private function isValidJson($content)
    {
        json_decode($content);

        return (json_last_error() === JSON_ERROR_NONE);
    }
}