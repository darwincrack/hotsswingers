<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class PaymentTypeCd
 * @package PaylandsSDK\Types\Enums
 * @method static PaymentTypeCd CSH()
 * @method static PaymentTypeCd ACC()
 * @method static PaymentTypeCd CSA()
 * @method static PaymentTypeCd HMD()
 * @method static PaymentTypeCd ATM()
 */
class PaymentTypeCd extends Enum
{
    const CSH = 'CSH';
    const ACC = 'ACC';
    const CSA = 'CSA';
    const HMD = 'HMD';
    const ATM = 'ATM';
}
