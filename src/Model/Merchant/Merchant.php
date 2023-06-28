<?php

declare(strict_types=1);

namespace Nofrixion\Model\Merchant;

use \RuntimeException;

/**
 * Model to represent a MoneyMoov merchant. A merchant is the top
 * level entity that is the ultimate parent of all other resources such as
 * payment accounts etc.
 * @todo POCO relies on API for data validation, could add some features.
 */
class Merchant
{

    /**
     * Unique ID for the merchant.
     * @var string
     */
    public string $id;
    /**
     * The registered business name of the merchant.
     * @var 
     */
    public ?string $name;
    /**
     * Flag to indicate if merchant is enabled
     * @var bool
     */
    public bool $enabled;
    /**
     * The Company ID recorded in the Compliance system.
     * @var 
     */
    public ?string $companyId;
    /**
     * The industry code that represents the merchant's primary trading activity.
     * @var 
     */
    public ?string $merchantCategoryCode;
    /**
     * A URL friendly shortish name for the merchant. Principal purpose is
     * to use in the hosted payment page URL.
     * @var 
     */
    public ?string $shortName;
    /**
     * An optional trading name. If not set the Name field will be used .
     * @var 
     */
    public ?string $tradingName;
    /**
     * The maximum number of payment accounts that can be created for the Merchant.
     * To increase the limit contact support.
     * @var int
     */
    public int $paymentAccountLimit;
    /**
     * Timestamp the merchant was added to MoneyMoov.
     * @var string
     * @todo investigate DateTime or numeric type for compatibility
     */
    public string $inserted; 
    /**
     * The jurisdiction the merchant entity is incorporated or established in.
     * @var string
     */
    public string $jurisdiction;
    /**
     * The version of the hosted payment page to use with the merchant.
     * @var int
     */
    public int $hostedPayVersion;
    /**
     * The maximum number of web hooks that can be created for the Merchant.
     * To increase the limit contact support.
     * @var int
     */
    public int $webhookLimit;
    /**
     * Indicates if a QR Code containing the payment link should be displayed
     * on the hosted payment page.
     * @var bool
     */
    public bool $displayQrOnHostedPay;
    /**
     * The role of the identity that loaded the merchant record.
     * @var string
     */
    public string $yourRole;
    /**
     * The list of users that have been assigned a role on the merchant.
     * @var array
     */
    public array $userRoles;
    /**
     * An optional list of descriptive tags that can be used on merchant entities
     * such as payment requests.
     * @var array
     */
    public array $tags;
    /**
     * List of merchant's paymentAccounts
     * @var array
     */
    public array $paymentAccounts;


}

//EOF
