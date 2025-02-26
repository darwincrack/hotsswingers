<?php

namespace PaylandsSDK\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class AccountType
 * @package PaylandsSDK\Types\Enums
 * @method static AccountType ACCOUNT_NUMBER()
 * @method static AccountTYpe BUSINESS()
 * @method static AccountTYpe ACCOUNT_CLABE()
 * @method static AccountTYpe CARD_NUMBER()
 * @method static AccountTYpe INTEREST_CHECKING()
 * @method static AccountTYpe MONEY_MARKET()
 * @method static AccountTYpe MOBILE_PHONE_NUMBER()
 * @method static AccountTYpe NOT_USED_FOR_THIS_BANK()
 * @method static AccountTYpe PERSONAL()
 * @method static AccountTYpe REGULAR_CHECKING()
 * @method static AccountTYpe SAVING_ACCOUNT()
 */
class AccountType extends Enum
{
    const ACCOUNT_NUMBER = 'ACCOUNT_NUMBER';
    const BUSINESS = 'BUSINESS';
    const ACCOUNT_CLABE = 'ACCOUNT_CLABE';
    const CARD_NUMBER = 'CARD_NUMBER';
    const INTEREST_CHECKING = 'INTEREST_CHECKING';
    const MONEY_MARKET = 'MONEY_MARKET';
    const MOBILE_PHONE_NUMBER = 'MOBILE_PHONE_NUMBER';
    const NOT_USED_FOR_THIS_BANK = 'NOT_USED_FOR_THIS_BANK';
    const PERSONAL = 'PERSONAL';
    const REGULAR_CHECKING = 'REGULAR_CHECKING';
    const SAVING_ACCOUNT = 'SAVING_ACCOUNT';
}
