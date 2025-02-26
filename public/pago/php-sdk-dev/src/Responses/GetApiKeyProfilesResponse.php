<?php


namespace PaylandsSDK\Responses;

/**
 * Class GetApiKeyProfilesResponse
 * @package PaylandsSDK\Responses
 */
class GetApiKeyProfilesResponse extends BaseResponse
{
    /**
     * @var string[]
     */
    private $profiles;

    /**
     * GetApiKeyProfilesResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $profiles
     */
    public function __construct(string $message, int $code, string $current_time, array $profiles)
    {
        parent::__construct($message, $code, $current_time);
        $this->profiles = $profiles;
    }

    /**
     * @return array
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}
