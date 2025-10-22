<?php

namespace Ngenius\NgeniusCommon;

class NgeniusHTTPTransfer
{
    private $url;
    private $httpVersion;
    private $headers;
    private $method;
    private $data;

    /**
     * @param string $url
     * @param string $httpVersion
     * @param string $method
     * @param array $data
     * @param array $headers
     */
    public function __construct(
        $url,
        $httpVersion = "",
        $method = "",
        $data = [],
        $headers = []
    ) {
        $this->url         = $url;
        $this->httpVersion = $httpVersion;
        $this->headers     = $headers;
        $this->method      = $method;
        $this->data        = $data;
    }


    /**
     * @param $key
     *
     * @return void
     */
    public function setTokenHeaders($key): void
    {
        $this->setHeaders([
                              "Authorization: Basic $key",
                              "Content-Type:  application/vnd.ni-identity.v1+json",
                              "Content-Length: 0"
                          ]);
    }

    /**
     * @param $token
     *
     * @return void
     */
    public function setPaymentHeaders($token): void
    {
        $this->setHeaders([
                              "Authorization: Bearer $token",
                              "Content-type: application/vnd.ni-payment.v2+json",
                              "Accept: application/vnd.ni-payment.v2+json"
                          ]);
    }

    /**
     * @param $token
     *
     * @return void
     */
    public function setInvoiceHeaders($token): void
    {
        $this->setHeaders([
                              "Authorization: Bearer $token",
                              "Content-type: application/vnd.ni-invoice.v1+json",
                          ]);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data ?? [];
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getHttpVersion()
    {
        return $this->httpVersion ?? "";
    }

    /**
     * @param string $httpVersion
     */
    public function setHttpVersion($httpVersion)
    {
        $this->httpVersion = $httpVersion;
    }

    public function build($requestData)
    {
        $this->url    = $requestData["uri"];
        $this->method = $requestData["method"];
        $this->data   = $requestData["data"] ?? [];
    }
}
