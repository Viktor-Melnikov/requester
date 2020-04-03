<?php
/**
 * Created by Viktor Melnikov.
 * Date: 2020-03-30
 * GitHub: viktor-melnikov
 */
declare(strict_types=1);

namespace Requester\Helpers;

class Mime
{
    const JSON = 'application/json';
    const XML = 'application/xml';
    const XHTML = 'application/html+xml';
    const FORM = 'application/x-www-form-urlencoded';
    const UPLOAD = 'multipart/form-data';
    const PLAIN = 'text/plain';
    const JS = 'text/javascript';
    const HTML = 'text/html';
    const YAML = 'application/x-yaml';
    const CSV = 'text/csv';

    /**
     * @var array
     */
    static public $mimes = [
        'json' => self::JSON,
        'xml' => self::XML,
        'form' => self::FORM,
        'plain' => self::PLAIN,
        'text' => self::PLAIN,
        'upload' => self::UPLOAD,
        'html' => self::HTML,
        'xhtml' => self::XHTML,
        'js' => self::JS,
        'javascript' => self::JS,
        'yaml' => self::YAML,
        'csv' => self::CSV,
    ];

    /**
     * @param string $short_name
     * @return string
     */
    static public function getFullMime(string $short_name): string
    {
        return array_key_exists($short_name, self::$mimes) ? self::$mimes[$short_name] : $short_name;
    }

    /**
     * @param string $short_name
     * @return bool
     */
    static public function supportsMimeType(string $short_name): bool
    {
        return array_key_exists(mb_convert_case($short_name, MB_CASE_LOWER), self::$mimes);
    }
}