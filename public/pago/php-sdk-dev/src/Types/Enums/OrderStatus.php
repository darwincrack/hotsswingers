<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class OrderStatus
 * @package PaylandsSDK\Types\Enums
 * @method static OrderStatus BLACKLISTED()
 * @method static OrderStatus CANCELLED()
 * @method static OrderStatus CREATED()
 * @method static OrderStatus EXPIRED()
 * @method static OrderStatus FRAUD()
 * @method static OrderStatus PARTIALLY_REFUNDED()
 * @method static OrderStatus PARTIALLY_CONFIRMED()
 * @method static OrderStatus PENDING_CONFIRMATION()
 * @method static OrderStatus REFUNDED()
 * @method static OrderStatus REFUSED()
 * @method static OrderStatus SUCCESS()
 * @method static OrderStatus PENDING_PROCESSOR_RESPONSE()
 * @method static OrderStatus PENDING_3DS_RESPONSE()
 * @method static OrderStatus PAID()
 */
class OrderStatus extends Enum
{
    const BLACKLISTED = 'BLACKLISTED';
    const CANCELLED = 'CANCELLED';
    const CREATED = 'CREATED';
    const EXPIRED = 'EXPIRED';
    const FRAUD = 'FRAUD';
    const PARTIALLY_REFUNDED = 'PARTIALLY_REFUNDED';
    const PARTIALLY_CONFIRMED = 'PARTIALLY_CONFIRMED';
    const PENDING_CONFIRMATION = 'PENDING_CONFIRMATION';
    const REFUNDED = 'REFUNDED';
    const REFUSED = 'REFUSED';
    const SUCCESS = 'SUCCESS';
    const PENDING_CARD = 'PENDING_CARD';
    const PENDING_PROCESSOR_RESPONSE = 'PENDING_PROCESSOR_RESPONSE';
    const PENDING_3DS_RESPONSE = 'PENDING_3DS_RESPONSE';
    const PAID = 'PAID';
}
