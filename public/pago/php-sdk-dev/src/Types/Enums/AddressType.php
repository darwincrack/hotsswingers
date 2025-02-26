<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class AddressType
 * @package PaylandsSDK\Types\Enums
 * @method static AddressType BILLING()
 * @method static AddressType SHIPPING()
 * @method static AddressType OTHER()
 */
class AddressType extends Enum
{
    const BILLING = 'BILLING';
    const SHIPPING = 'SHIPPING';
    const OTHER = 'OTHER';
}
