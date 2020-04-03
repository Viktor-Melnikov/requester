<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-30
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Concerns;

use Requester\Helpers\Mime;

/**
 * Trait Header
 * @package Requester\Helpers
 */
trait Header
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @return $this
     */
    public function withHeader()
    {
        $this->headers['headers'] = array_change_key_case($this->parseArguments(func_get_args()), CASE_LOWER);

        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function withoutHeader(string $key)
    {
        $key = mb_convert_case($key, MB_CASE_LOWER);

        if (isset($this->headers['headers'][$key])) {
            unset($this->headers['headers'][$key]);
        }

        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function withContentType(string $type)
    {
        $contentType = $type;

        if (Mime::supportsMimeType($type)) {
            $contentType = Mime::getFullMime($type);
        }

        return $this->withHeader('content-type', $contentType);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasHeader(string $key): bool
    {
        $key = mb_convert_case($key, MB_CASE_LOWER);

        return isset($this->headers['headers'][$key]);
    }

    /**
     * @param string $key
     * @return string
     */
    public function getHeader(string $key): string
    {
        $key = mb_convert_case($key, MB_CASE_LOWER);

        if(isset($this->headers['headers'][$key])) {
            return $this->headers['headers'][$key];
        }

        return '';
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}