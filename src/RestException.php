<?php

namespace Swaggest\RestClient;

class RestException extends \Exception
{
    const MISSING_SECURITY = 1;
    const UNSUPPORTED_RESPONSE_CODE = 2;
}