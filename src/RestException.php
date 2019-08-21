<?php

namespace Swaggest\RestClient;


class RestException extends \Exception
{
    const MISSING_SECURITY = 1;
    const ALREADY_SENT = 2;
    const UNSUPPORTED_RESPONSE_CODE = 3;

}