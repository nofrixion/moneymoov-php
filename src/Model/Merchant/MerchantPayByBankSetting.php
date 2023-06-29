<?php

declare(strict_types=1);

namespace NoFrixion\Model\Merchant;

use \RuntimeException;

/**
 * Model representing an individual bank payment setting.
 */
class MerchantPayByBankSetting
{
    /**
     * ID of the bank to be configured for the merchant.
     * @var string
     */
    public string $bankId;
    /**
     * Name of the Bank/Institution. 
     * @var 
     */
    public ?string $bankName;
    /**
     * Order in which this setting will appear in the UI.
     * @var int
     */
    public int $order;
    /**
     * URL of the bank's logo.
     * @var 
     */
    public ?string $logo;
    /**
     * Currency supported by the bank.
     * @var string
     */
    public string $currency;
    /**
     * Name of the bank payment processor.
     * @var 
     */
    public ?string $processor;
    /**
     * ID that the processor uses to identify the bank (personal accounts).
     * @var 
     */
    public ?string $personalInstitutionID;
    /**
     * ID that the processor uses to identify the bank (business accounts).
     * @var 
     */
    public ?string $businessInstitutionID;
    /**
     * Message relating to specific bank.
     * @var 
     */
    public ?string $message;
    /**
     * Optional image URL to be displayed with the message.
     * @var 
     */
    public ?string $messageImageUrl;

    /**
     * Summary of __construct
     * @param string $bankId
     * @param mixed $bankName
     * @param int $order
     * @param mixed $logo
     * @param string $currency
     * @param mixed $processor
     * @param mixed $personalInstitutionID
     * @param mixed $businessInstitutionID
     * @param mixed $message
     * @param mixed $messageImageUrl
     * @throws \RuntimeException
     */
    public function __construct(
        string $bankId,
        ?string $bankName,
        int $order,
        ?string $logo,
        string $currency,
        ?string $processor,
        ?string $personalInstitutionID,
        ?string $businessInstitutionID,
        ?string $message,
        ?string $messageImageUrl
    ) {
        $this->bankId = $bankId;
        $this->bankName = $bankName;
        $this->order = $order;
        $this->logo = $logo;
        $this->currency = $currency;
        $this->processor = $processor;
        $this->personalInstitutionID = $personalInstitutionID;
        $this->businessInstitutionID = $businessInstitutionID;
        $this->message = $message;
        $this->messageImageUrl = $messageImageUrl;
    }
}

//EOF
