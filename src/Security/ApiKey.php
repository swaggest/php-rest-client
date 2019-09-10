<?php

namespace Swaggest\RestClient\Security;

use Psr\Http\Message\RequestInterface;
use Swaggest\RestClient\SecurityApplicator;

abstract class ApiKey implements SecurityApplicator
{
    const IN_HEADER = 'header';
    const IN_QUERY = 'query';
    const IN_COOKIE = 'cookie';

    /** @var string */
    protected $name;

    /** @var string */
    private $value;

    /** @var string */
    protected $in;

    /**
     * ApiKey constructor.
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
    public function secureRequest(RequestInterface $request)
    {
        if ($this->in === self::IN_HEADER) {
            return $request->withHeader($this->name, $this->value);
        } elseif ($this->in === self::IN_QUERY) {
            $uri = $request->getUri();
            $query = $uri->getQuery();
            $query .= ($query ? '&' : '') . urlencode($this->name) . '=' . urlencode($this->value);
            return $request->withUri($uri->withQuery($query));
        } elseif ($this->in === self::IN_COOKIE) {
            return $request->withHeader('Cookie', $this->name . '=' . $this->value);
        }
        return $request;
    }
}