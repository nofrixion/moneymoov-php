<?php

declare(strict_types=1);

namespace Nofrixion\Model;

use \RuntimeException;

/**
 * Webhook - model class for MoneyMoov webhooks.
 */
class Webhook
{
    public $id;
    public string $merchantId;
    public string $type;
    public string $destinationUrl;
    public ?bool $retry = null;
    public string $secret;
    public ?bool $isActive = true;
    public ?string $emailAddress = null;

    /**
     * @param string|null $id Use 'null' when creating webhook, specify the id if updating.
     * @param string $merchantId
     * @param string $type must be one of PAYIN | PAYOUT
     * @param string $destinationUrl
     * @param bool|null $retry
     * @param string $secret
     * @param bool|null $isActive
     * @param string|null $emailAddress
     */
    public function __construct(
        ?string $id = null,
        string $merchantId,
        string $type,
        string $destinationUrl,
        ?bool $retry = null,
        string $secret,
        ?bool $isActive = true,
        ?string $emailAddress = null
    ) {
        $this->id = $id;
        $this->merchantId = $merchantId;
        $this->retry = $retry;
        $this->secret = $secret;
        $this->isActive = $isActive;

        // Check URL (note, does not check protocol is sensible)
        if (filter_var($destinationUrl, FILTER_VALIDATE_URL)) {
            $this->destinationUrl = $destinationUrl;
        } else {
            throw new RuntimeException('Invalid URL specified for $destiantionURL');
        }

        // Check $type is PAYIN|PAYOUT
        if (in_array($type, ['PAYIN', 'PAYOUT'], true)) {
            $this->type = $type;
        } else {
            throw new RuntimeException('Invalid value: $type must be PAYIN or PAYOUT');
        }

        // Check Email address is null (default) or valid
        if (!is_null($emailAddress)) {
            if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                $this->emailAddress = $emailAddress;
            } else {
                throw new RuntimeException('$emailAddress must be "null" or a valid email address.');
            }
        }
    }

    public static function getSignature(string $secret, string $payload): string
    {
        $hexHash = hash_hmac('sha256', $payload, $secret);
        $base64Hash = base64_encode(hex2bin($hexHash));
        return $base64Hash;
    }
}

//EOF
