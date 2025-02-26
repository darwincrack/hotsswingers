<?php

namespace  PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class EntryType
 * @package PaylandsSDK\Types\Enums
 * @method static EntryType WEBSERVICE()
 * @method static EntryType FORM()
 * @method static EntryType BACKEND()
 */
class EntryType extends Enum
{
    const WEBSERVICE = 'WEBSERVICE';
    const FORM = 'FORM';
    const BACKEND = 'BACKEND';
}
