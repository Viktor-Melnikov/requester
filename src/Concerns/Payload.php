<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-04-01
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Concerns;

use Requester\Helpers\Mime;

trait Payload
{
    /**
     * @var mixed
     */
    private $payload;

    /**
     * @var array
     */
    private $files = [];

    /**
     * @param $payload
     * @return $this
     */
    public function withPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return $this
     */
    public function withFile()
    {
        $files = $this->parseArguments(func_get_args());

        foreach ($files as $key => $path) {
            $this->files[] = [
                'name' => $key,
                'contents' => fopen($path, 'r')
            ];
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        if (!empty($this->files)) {
            $data = [];

            if (!is_null($this->payload) && is_array($this->payload)) {
                foreach ($this->payload as $key => $value) {
                    $data[] = [
                        'name' => $key,
                        'contents' => $value,
                    ];
                }
            }

            return ['multipart' => array_merge($this->files, $data)];
        }

        if($this->hasHeader('content-type') && $this->getHeader('content-type') === Mime::JSON) {
            return ['json' => $this->preparePayload];
        }

        if($this->method === 'GET') {
            return ['query' => $this->preparePayload];
        }

        if(is_array($this->preparePayload)) {
            return ['form_params' => $this->preparePayload];
        }

        return ['body' => $this->preparePayload];
    }
}