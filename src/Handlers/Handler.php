<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-28
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Handlers;

use Requester\Contracts\HandlerInterface;
use Requester\Request;

/**
 * Class Handler
 *
 * @package Requester\Handlers
 */
class Handler  implements HandlerInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     * @return $this
     */
    public function init(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}