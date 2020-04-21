<?php

namespace hCaptcha;

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
     */
    public function __construct($secretKey, $request = null)
    {
        $this->secretKey = $secretKey;

        if ($request && $request instanceof RequestInterface) {
            $this->request = $request;
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
}