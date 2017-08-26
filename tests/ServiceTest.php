<?php

namespace fkooman\YubiCheck\Tests;

use fkooman\YubiCheck\Request;
use fkooman\YubiCheck\Service;
use fkooman\YubiTwee\Validator;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testGet()
    {
        $validator = new Validator(new MockHttpClient('testOkay'));

        $s = new Service($validator);
        $response = $s->run(
            new Request(
                [
                    'REQUEST_METHOD' => 'GET',
                ],
                [],
                []
            )
        );
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('<html><head><title>YubiCheck</title></head><body><h1>YubiCheck</h1><form method="post"><label>Yubi OTP <input type="text" name="yubi_otp"><input type="submit" value="Check"></form></body></html>', $response->getBody());
    }

    public function testVerifyOtp()
    {
        $s = new Service(
            new Validator(
                new MockHttpClient('testOkay'),
                new MockRandom('602bbcad5b9f4790b591cd356a8f9a2b')
            )
        );

        $response = $s->run(
            new Request(
                [
                    'REQUEST_METHOD' => 'POST',
                ],
                [],
                [
                    'yubi_otp' => 'vvbvdirtrlvddetcvnndcufrjdjukelgfrtfnnfbijui',
                ]
            )
        );
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('<html><head><title>YubiCheck</title></head><body><h1>YubiCheck</h1><form method="post"><label>Yubi OTP <input type="text" name="yubi_otp"><input type="submit" value="Check"></form><p>[OK] ID=vvbvdirtrlvd</p></body></html>', $response->getBody());
    }
}
