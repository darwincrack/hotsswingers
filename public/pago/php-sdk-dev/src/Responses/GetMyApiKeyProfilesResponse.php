<?php


namespace PaylandsSDK\Responses;

class GetMyApiKeyProfilesResponse extends BaseResponse
{
    /**
     * @var string[]
     */
    private $profiles;

    /**
     * @var bool
     */
    private $is_pci;

    public function __construct(string $message, int $code, string $current_time, array $profiles, bool $is_pci)
    {
        parent::__construct($message, $code, $current_time);
        $this->profiles = $profiles;
        $this->is_pci = $is_pci;
    }

    /**
     * @return array|string[]
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @return bool
     */
    public function isIsPci()
    {
        return $this->is_pci;
    }
}
