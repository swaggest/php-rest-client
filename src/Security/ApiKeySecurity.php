<?php

namespace Swaggest\RestClient\Security;

use Psr\Http\Message\RequestInterface;
use Swaggest\RestClient\RequestMiddleware;

abstract class ApiKeySecurity implements RequestMiddleware
{
    const IN_HEADER = 'header';
    const IN_QUERY = 'query';

    /** @var string */
    protected $name;

    /** @var string */
    private $value;

    /** @var string */
    protected $in;

    /**
     * ApiKeySecurity constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface|static
     */
    public function prepareRequest(RequestInterface $request)
    {
        if ($this->in === self::IN_HEADER) {
            return $request->withHeader($this->name, $this->value);
        } else { // self::IN_QUERY
            $uri = $request->getUri();
            $query = $uri->getQuery();
            $query .= ($query ? '&' : '') . urlencode($this->name) . '=' . urlencode($this->value);
            return $request->withUri($uri->withQuery($query));
        }
    }
}