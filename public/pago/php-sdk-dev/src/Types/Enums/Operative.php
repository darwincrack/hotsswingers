<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class Operative
 * @package PaylandsSDK\Types\Enums
 * @method static Operative AUTHORIZATION()
 * @method static Operative DEFERRED()
 * @method static Operative PAYOUT()
 * @method static Operative TRANSFER()
 * @method static Operative REFUND()
 * @method static Operative CONFIRMATION()
 * @method static Operative CANCELLATION()
 */
class Operative extends Enum
{
    const AUTHORIZATION = 'AUTHORIZATION';
    const DEFERRED = 'DEFERRED';
    const PAYOUT = 'PAYOUT';
    const TRANSFER = 'TRANSFER';
    const REFUND = 'REFUND';
    const CONFIRMATION = 'CONFIRMATION';
    const CANCELLATION = 'CANCELLATION';
}
