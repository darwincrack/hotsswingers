<?php
namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class SubscriptionInterval
 * @package PaylandsSDK\Types\Enums\Enum
 * @method static SubscriptionInterval DAILY()
 * @method static SubscriptionInterval WEEKLY()
 * @method static SubscriptionInterval MONTHLY()
 * @method static SubscriptionInterval YEARLY()
 */
class SubscriptionInterval extends Enum
{
    const DAILY = 'DAILY';
    const WEEKLY = 'WEEKLY';
    const MONTHLY = 'MONTHLY';
    const YEARLY = 'YEARLY';
}
