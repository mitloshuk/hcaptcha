<?php

namespace hCaptcha;

use hCaptcha\Requests\CurlRequest;
use hCaptcha\Requests\RequestFormatException;
use hCaptcha\Requests\RequestInterface;
use hCaptcha\Responses\Response;

/**
 * Class hCaptcha
 *
 * @package hCaptcha
 */
class hCaptcha
{
    const VERIFY_URL = 'https://hcaptcha.com/siteverify';

    /**
     * Personal hCaptcha secret key
     *
     * @var string $secretKey
     */
    protected $secretKey;

    /**
     * Request maker
     *
     * @var RequestInterface $request
     */
    protected $request;

    /**
     * hCaptcha constructor.
     *
     * @param string                $secretKey
     * @param RequestInterface|null $request
     *
     * @throws RequestFormatException
     */
    public function __construct($secretKey, $request = null)
    {
        $this->secretKey = $secretKey;

        if ($request) {
            if ($request instanceof RequestInterface) {
                $this->request = $request;
            } else {
                throw new RequestFormatException();
            }
        } else {
            $this->request = new CurlRequest();
        }
    }

    /**
     * @param string $response
     * @param null   $userIp
     *
     * @return Response
     */
    public function verify($response, $userIp = null)
    {
        $response = $this->request->getResponse(
            self::VERIFY_URL,
            $this->secretKey,
            $response,
            $userIp
        );

        return new Response($response);
    }

    public static function isSuccess($response, $secretKey, $userIp = null)
    {
        $hCaptcha = new static($secretKey);

        return $hCaptcha->verify($response, $userIp)->isSuccess();
    }
}