<?php

declare(strict_types=1);

namespace Nofrixion\Model\Merchant;

use \RuntimeException;

/**
 * Model representing a collection pay by bank settings for a merchant.
 */
class MerchantPayByBankSettings
{
    /**
     * Merchant to which the settings will be configured.
     * @var string
     */
    public string $merchantId;
    /**
     * Array of bank payment settings.
     * @var array
     */
    public array $payByBankSettings;

    /**
     * Constructor for model
     * @param mixed $merchantId
     * @param mixed $payByBankSettings
     */
    public function __construct(
        string $merchantId,
        array $payByBankSettings
    ) {
        $this->merchantId = $merchantId;
        $this->$payByBankSettings = $payByBankSettings;
    }
}

//EOF
