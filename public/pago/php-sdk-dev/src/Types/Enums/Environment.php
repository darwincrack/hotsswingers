<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class Environment
 * @package PaylandsSDK\Types\Enums
 * @method static Environment PRODUCTION()
 * @method static Environment SANDBOX()
 */
class Environment extends Enum
{
    const PRODUCTION = 'PRODUCTION';
    const SANDBOX = 'SANDBOX';
}
