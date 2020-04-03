<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-30
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Concerns;

/**
 * Trait Uri
 * @package Requester\Concerns
 */
trait Uri
{
    /**
     * Full URI address for request`s (URI = URL + URN)
     *
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $urn;

    /**
     * @var
     */
    private $url;

    /**
     * @param string $urn
     * @return $this
     */
    public function withEndpoint(string $urn)
    {
        $this->urn = $urn;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function withUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param string $uri
     * @return Uri
     */
    public function withUri(string $uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getUri()
    {
        $uri = '';

        if (!empty($this->uri)) {
            $uri = rtrim($this->uri, '/');
        } elseif (empty($this->uri) && empty($this->urn) && !empty($this->url)) {
            $uri = rtrim($this->url, '/');
        } elseif (!empty($this->urn) && !empty($this->url)) {
            $uri = rtrim($this->url, '/') . '/' . $this->urn;
        }

        if (empty($uri)) {
            throw new \Exception('Attempting to send a request before defining a URI endpoint.');
        }

        return $uri;
    }
}