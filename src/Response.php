<?php

namespace hCaptcha;

/**
 * Response class returned by any request to hCaptcha
 *
 * @package hCaptcha
 */
class Response
{
    /**
     * @var bool $success
     */
    protected $success;

    /**
     * @var bool $credit
     */
    protected $credit = false;

    /**
     * @var string|null $hostname
     */
    protected $hostname = null;

    /**
     * @var string|null $date
     */
    protected $date = null;

    /**
     * @var array|null $errors
     */
    protected $errors = null;

    /**
     * Response constructor
     *
     * @param string $responseString
     */
    public function __construct($responseString)
    {
        $json = json_decode($responseString, true);

        $this->success = (bool)$json['success'];

        if ($this->isSuccess()) {
            $this->credit = (bool)$json['credit'];
            $this->hostname = (bool)$json['hostname'];
            $this->date = (bool)$json['challenge_ts'];
        } else {
            $this->errors = (array)$json['error-codes'];
        }
    }

    /**
     * Is it human?
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * Is it credit?
     *
     * @return bool
     */
    public function isCredit()
    {
        return $this->credit;
    }

    /**
     * @return array|null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getHostname()
    {
        return $this->hostname;
    }
}