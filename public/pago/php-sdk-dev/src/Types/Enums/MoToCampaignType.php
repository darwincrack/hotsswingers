<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class MoToCampaignType
 * @method static MoToCampaignType MAIL()
 * @method static MoToCampaignType SMS()
 * @method static MoToCampaignType MANUAL()
 * @method static MoToCampaignType PHONE()
 * @method static MoToCampaignType CUSTOM_DELIVERY()
 */
class MoToCampaignType extends Enum
{
    const MAIL = 'MAIL';
    const SMS = 'SMS';
    const MANUAL = 'MANUAL';
    const PHONE = 'PHONE';
    const CUSTOM_DELIVERY = 'CUSTOM_DELIVERY';
}
