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
     * @param SecurityApplicator $applicator
     * @return $this
     */
    public function withSecurity($name, SecurityApplicator $applicator)
    {
        $this->security[$name] = $applicator;
        return $this;
    }

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
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    /** @codeCoverageIgnoreEnd */
}