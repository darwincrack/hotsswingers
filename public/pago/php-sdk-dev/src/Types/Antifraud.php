<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\Evaluation;

/**
 * Class Antifraud
 */
class Antifraud
{
    /**
     * @var Evaluation
     */
    private $evaluation;
    /**
     * @var int
     */
    private $score;

    /**
     * @var int
     */
    private $risk_score;

    /**
     * @var int
     */
    private $fraud_score;

    /**
     * Antifraud constructor.
     * @param Evaluation $evaluation
     * @param int $score
     * @param int $risk_score
     * @param int $fraud_score
     */
    public function __construct(Evaluation $evaluation, int $score, int $risk_score, int $fraud_score)
    {
        $this->evaluation = $evaluation;
        $this->score = $score;
        $this->risk_score = $risk_score;
        $this->fraud_score = $fraud_score;
    }

    /**
     * @return Evaluation
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @param Evaluation $evaluation
     * @return Antifraud
     */
    public function setEvaluation(Evaluation $evaluation): Antifraud
    {
        $this->evaluation = $evaluation;
        return $this;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return Antifraud
     */
    public function setScore(int $score): Antifraud
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return int
     */
    public function getRiskScore()
    {
        return $this->risk_score;
    }

    /**
     * @param int $risk_score
     * @return Antifraud
     */
    public function setRiskScore(int $risk_score): Antifraud
    {
        $this->risk_score = $risk_score;
        return $this;
    }

    /**
     * @return int
     */
    public function getFraudScore()
    {
        return $this->fraud_score;
    }

    /**
     * @param int $fraud_score
     * @return Antifraud
     */
    public function setFraudScore(int $fraud_score): Antifraud
    {
        $this->fraud_score = $fraud_score;
        return $this;
    }
}
