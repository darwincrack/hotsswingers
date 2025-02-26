<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class TransactionStatus
 * @package PaylandsSDK\Types\Enums\Enum
 * @method static TransactionStatus CREATED()
 * @method static TransactionStatus SUCCESS()
 * @method static TransactionStatus REFUSED()
 * @method static TransactionStatus ERROR()
 * @method static TransactionStatus PENDING()
 * @method static TransactionStatus CANCELLED()
 */
class TransactionStatus extends Enum
{
    const CREATED = 'CREATED';
    const SUCCESS = 'SUCCESS';
    const REFUSED = 'REFUSED';
    const ERROR = 'ERROR';
    const PENDING = 'PENDING';
    const CANCELLED = 'CANCELLED';
}
