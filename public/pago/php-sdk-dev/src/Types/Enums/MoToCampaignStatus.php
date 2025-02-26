<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class MoToCampaignStatus
 * @package PaylandsSDK\Types\Enums
 * @method static MoToCampaignStatus PENDING()
 * @method static MoToCampaignStatus COMPLETED()
 * @method static MoToCampaignStatus ERROR_CREATING()
 * @method static MoToCampaignStatus ERROR_SENDING()
 */
class MoToCampaignStatus extends Enum
{
    const PENDING = 'PENDING';
    const COMPLETED = 'COMPLETED';
    const ERROR_CREATING = 'ERROR_CREATING';
    const ERROR_SENDING = 'ERROR_SENDING';
}
