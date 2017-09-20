<?php

namespace fkooman\YubiCheck;

class Response
{
    /** @var int */
    private $statusCode;

    /** @var array */
    private $headers;

    /** @var string */
    private $body;

    /**
     * @param int    $statusCode
     * @param array  $headers
     * @param string $body
     */
    public function __construct($statusCode = 200, array $headers = [], $body = '')
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return void
     */
    public function send()
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $k => $v) {
            header(sprintf('%s: %s', $k, $v));
        }
        echo $this->body;
    }
}
