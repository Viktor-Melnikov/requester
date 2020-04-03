<?php

declare(strict_types=1);

namespace Requester\Contracts;

use Requester\Request;

/**
 * Interface HandlerInterface
 *
 * @package Requester\Contracts
 */
interface HandlerInterface
{
    public function init(Request $request);

    /**
     * Load data from cache
     *
     * @return bool
     */
    public function hasCachedData();

    /**
     * Метод выполняется перед отправкой запроса. Даже немногим раньше.
     */
    public function beforeExecute();

    /**
     * Событие срабатывает после выполнения запроса и получения обработанных данных методом parse;
     *
     * @param         $body
     * @return $this
     */
    public function afterExecute($body);

    /**
     *
     * @param         $body
     * @return $this
     */
    public function setCachedData($body);

    /**
     * обработчик ошибок реквеста
     *
     * @param         $message
     * @param         $context
     * @return
     */
    public function error($message, array $context = []);

    /**
     * Парсит API Response и возвращает нормальные данные
     *
     * @param string  $body
     * @return mixed
     */
    public function parseData($body);

    /**
     * Сериализует body (payload) в строку для запроса.
     * Все что передали в метод body, попадет сюда.
     *
     * @param mixed   $payload
     * @return string
     */
    public function prepareData($payload);
}