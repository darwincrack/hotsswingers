<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class DocumentIdentificationIssuer
 * @package PaylandsSDK\Types\Enums
 * @method static DocumentIdentificationIssuer STATE_GOVERNMENT()
 * @method static DocumentIdentificationIssuer FEDERAL_GOVERNMENT()
 * @method static DocumentIdentificationIssuer MONEY_TRAMSMITTER()
 * @method static DocumentIdentificationIssuer PROFESSIONAL_ASSOCIATION()
 */
class DocumentIdentificationIssuer extends Enum
{
    const STATE_GOVERNMENT = 'STATE_GOVERNMENT';
    const FEDERAL_GOVERNMENT = 'FEDERAL_GOVERNMENT';
    const MONEY_TRAMSMITTER = 'MONEY_TRAMSMITTER';
    const PROFESSIONAL_ASSOCIATION = 'PROFESSIONAL_ASSOCIATION';
}
