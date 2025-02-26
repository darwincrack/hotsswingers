<?php


namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class Evaluation
 * @package PaylandsSDK\Types\Enums
 * @method static Evaluation NONE()
 * @method static Evaluation RISKY()
 * @method static Evaluation FRAUD()
 * @method static Evaluation VHITELISTED()
 * @method static Evaluation BLACKLISTED()
 */
class Evaluation extends Enum
{
    const NONE = "NONE";
    const RISKY = "RISKY";
    const FRAUD = "FRAUD";
    const VHITELISTED = "VHITELISTED";
    const BLACKLISTED = "BLACKLISTED";
}
