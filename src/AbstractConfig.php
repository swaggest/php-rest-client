<?php

namespace Swaggest\RestClient;

abstract class AbstractConfig
{
    /** @var string */
    protected $baseUrl;

    /** @var SecurityApplicator[] */
    protected $security = array();

    /**
     * @param string $name
     * @return SecurityApplicator|null
     */
    public function security($name)
    {
        if (isset($this->security[$name])) {
            return $this->security[$name];
        }
        return null;
    }

    /**
     * @codeCoverageIgnoreStart
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }
    /** @codeCoverageIgnoreEnd */

    /**
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    /** @codeCoverageIgnoreEnd */
}