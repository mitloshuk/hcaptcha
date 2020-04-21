<?php

namespace hCaptcha\Tests;

use hCaptcha\CurlRequest;
use hCaptcha\hCaptcha;
use hCaptcha\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 *
 * @package hCaptcha\Tests
 */
class RequestTest extends TestCase
{
    /**
     * Test SECRET KEY from API documentation
     */
    const TEST_SECRET_KEY = '0x0000000000000000000000000000000000000000';

    /**
     * Test RESPONSE from API documentation
     */
    const TEST_RESPONSE = '10000000-aaaa-bbbb-cccc-000000000001';

    public function testEmptyRequest()
    {
        $request = new CurlRequest();

        $response = $request->getResponse(
            hCaptcha::VERIFY_URL,
            self::TEST_SECRET_KEY,
            ''
        );

        $responseObject = new Response($response);

        $this->assertFalse($responseObject->isSuccess());
    }

    public function testWrongResponseRequest()
    {
        $request = new CurlRequest();

        $response = $request->getResponse(
            hCaptcha::VERIFY_URL,
            self::TEST_SECRET_KEY,
            'captcha-response-example'
        );

        $responseObject = new Response($response);

        $this->assertFalse($responseObject->isSuccess());
    }

    public function testResponseRequest()
    {
        $request = new CurlRequest();

        $response = $request->getResponse(
            hCaptcha::VERIFY_URL,
            self::TEST_SECRET_KEY,
            self::TEST_RESPONSE
        );

        $responseObject = new Response($response);

        $this->assertTrue($responseObject->isSuccess());
    }

    /**
     * Test for response
     *
     * @return void
     */
    public function testWrongRequestUrl()
    {
        $request = new CurlRequest(1);

        $urls = [
            'google.com',
            '',
            'nothing',
            null,
            123,
        ];

        foreach ($urls as $url) {
            $response = $request->getResponse(
                $url,
                self::TEST_SECRET_KEY,
                ''
            );

            $responseObject = new Response($response);

            $this->assertContains('status code', $response);

            $this->assertFalse($responseObject->isSuccess());

            foreach ($responseObject->getErrors() as $error) {
                $this->assertContains('status code', $error);
            }
        }
    }
}
