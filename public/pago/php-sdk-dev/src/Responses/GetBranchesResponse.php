<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Branch;

/**
 * Class GetBranchesResponse
 * @package PaylandsSDK\Responses
 */
class GetBranchesResponse extends BaseResponse
{
    /**
     * @var Branch[]
     */
    private $branches;

    /**
     * GetBranchesResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $branches
     */
    public function __construct(string $message, int $code, string $current_time, array $branches)
    {
        parent::__construct($message, $code, $current_time);
        $this->branches = $branches;
    }

    /**
     * @return Branch[]
     */
    public function getBranches()
    {
        return $this->branches;
    }
}
