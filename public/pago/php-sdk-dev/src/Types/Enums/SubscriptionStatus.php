<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class SubscriptionStatus
 * @package PaylandsSDK\Types\Enums\Enum
 * @method static SubscriptionStatus CREATED()
 * @method static SubscriptionStatus ISSUED()
 * @method static SubscriptionStatus DENIED()
 * @method static SubscriptionStatus FAILED_NOTIFICATION()
 * @method static SubscriptionStatus PAID()
 */
class SubscriptionStatus extends Enum
{
    const CREATED = 'CREATED';
    const ISSUED = 'ISSUED';
    const DENIED = 'DENIED';
    const FAILED_NOTIFICATION = 'FAILED_NOTIFICATION';
    const PAID = 'PAID';
}
