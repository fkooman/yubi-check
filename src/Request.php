<?php

namespace fkooman\YubiCheck;

use fkooman\YubiCheck\Exception\HttpException;

class Request
{
    /** @var array */
    private $serverData;

    /** @var array */
    private $getData;

    /** @var array */
    private $postData;

    /**
     * @param array $serverData
     * @param array $getData
     * @param array $postData
     */
    public function __construct(array $serverData, array $getData, array $postData)
    {
        $this->serverData = $serverData;
        $this->getData = $getData;
        $this->postData = $postData;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->serverData['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getPostParameter($key)
    {
        if (!array_key_exists($key, $this->postData) && !empty($this->postData[$key])) {
            throw new HttpException(sprintf('post parameter "%s" not provided', $key), 400);
        }

        return $this->postData[$key];
    }
}
