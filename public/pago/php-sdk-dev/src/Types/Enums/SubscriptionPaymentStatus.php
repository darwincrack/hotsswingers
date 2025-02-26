<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class SubscriptionPaymentStatus
 * @package PaylandsSDK\Types\Enums\Enum
 * @method static SubscriptionPaymentStatus CREATED()
 * @method static SubscriptionPaymentStatus ISSUED()
 * @method static SubscriptionPaymentStatus DENIED()
 * @method static SubscriptionPaymentStatus FAILED_NOTIFICATION()
 * @method static SubscriptionPaymentStatus PAID()
 */
class SubscriptionPaymentStatus extends Enum
{
    const CREATED = 'CREATED';
    const ISSUED = 'ISSUED';
    const DENIED = 'DENIED';
    const FAILED_NOTIFICATION = 'FAILED_NOTIFICATION';
    const PAID = 'PAID';
}
