<?php

declare(strict_types=1);

namespace Requester;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Requester\Concerns\AuthBasic;
use Requester\Concerns\Handler;
use Requester\Concerns\HashRequest;
use Requester\Concerns\Header;
use Requester\Concerns\Option;
use Requester\Concerns\Payload;
use Requester\Concerns\Uri;
use Requester\Contracts\HandlerInterface;
use Requester\Handlers\BlackHoleHandler;

/**
 * Class Request
 */
class Request
{
    use Option, Header, AuthBasic, Handler, HashRequest, Uri, Payload;

    /**
     * @var HandlerInterface
     */
    private $handler;

    /**
     * @var Collection
     */
    protected $config;

    /**
     * @var array
     */
    private $files = [];

    /**
     * @var null
     */
    public $preparePayload = null;

    /**
     * @var string
     */
    private $method = 'GET';

    /**
     * Request constructor.
     *
     * @param array $config
     * @param bool $availableDefault
     * @throws \Exception
     */
    public function __construct(array $config = [], $availableDefault = true)
    {
        $this
            ->withConfig($config)
            ->withHandler($this->config->get('handler', BlackHoleHandler::class));

        !$availableDefault || $this->configureDefaults();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function withConfig(array $data)
    {
        $this->config = collect($data);

        return $this;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function withMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param array $file
     * @return $this
     */
    public function setFile(array $file)
    {
        $this->files = $file;

        return $this;
    }

    /**
     * @param string $path
     * @param string|null $password
     * @return Request
     */
    public function certificate(string $path, ?string $password = null)
    {
        return $this->withOption('cert', [$path, $password]);
    }

    /**
     * @param string $path
     * @return Request
     */
    public function ssl(string $path)
    {
        return $this->withOption('ssl_key', $path);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function send()
    {
        $this->generateHash();

        if ($data = $this->runHandler('hasCachedData')) {
            return $data;
        }

        if (!empty($this->payload)) {
            $this->preparePayload = $this->runHandler('prepareData', $this->payload);
        }

        $this->runHandler('beforeExecute');

        $exception = false;
        $response = null;

        try {
            $client = new Client();

            $response = $client->request(
                $this->method,
                $this->getUri(),
                $this->getHeaders() + $this->getPayload() + $this->getOptions()
            );

        } catch (Exception $e) {
            $exception = $e;
        } finally {
            if (is_bool($exception) && $response instanceof Response) {
                $response = $this->runHandler('parseData', $response->getBody());

                if ($data = $this->runHandler('setCachedData', $response)) {
                    return $response;
                }

                $this->runHandler('afterExecute', $response);

                return $response;
            }
        }


        $msg = null;

        if ($exception instanceof Exception) {
            $msg = $exception->getMessage();

            if ($exception instanceof RequestException) {
                $msg = $exception->getRequest();

                if ($exception->hasResponse()) {
                    $msg = $exception->getResponse()->getBody()->getContents();
                }
            }
        }

        return $this->handle('error', $msg, ['exception' => $exception instanceof Exception ? $exception : null]);
    }

    /**
     * Дамп объекта
     */
    public function dump()
    {
        dd($this);
    }

    /**
     * @throws \Exception
     */
    private function configureDefaults()
    {
        if ($this->config->has('url')) {
            $this->withUrl($this->config->get('url'));
        }

        if ($this->config->has('headers')) {
            $this->withHeader($this->config->get('headers'));
        }

        if ($this->config->has('options')) {
            $this->withOption($this->config->get('options'));
        }

        if ($this->config->has('certificate')) {
            [$path, $password] = array_values($this->config->get('certificate'));

            $this->certificate($path, $password);
        }

        if ($this->config->has('ssl')) {
            $this->ssl($this->config->get('ssl'));
        }

        if (isset($this->config->get('auth')['basic'])) {
            $this->withAuthBasic();
        }
    }

    /**
     * @param $arguments
     * @return array
     */
    private function parseArguments($arguments): array
    {
        $items = head($arguments);

        if (count($arguments) === 2) {
            $items = [$arguments[0] => $arguments[1]];
        }

        foreach ($items as $key => $item) {
            $items[$key] = $item;
        }

        return $items;
    }
}