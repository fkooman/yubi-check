<?php

namespace fkooman\YubiCheck;

use fkooman\YubiTwee\Validator;

class Service
{
    /** @var \fkooman\YubiTwee\Validator */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $request
     *
     * @return \fkooman\YubiCheck\Response
     */
    public function run(Request $request)
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->showYubiForm();
            case 'POST':
                $yubiOtp = $request->getPostParameter('yubi_otp');

                return $this->validateYubiOtp($yubiOtp);
            default:
                return new Response(405, ['Allow' => 'GET,POST']);
        }
    }

    /**
     * @return \fkooman\YubiCheck\Response
     */
    private function showYubiForm()
    {
        $htmlPage = '<html><head><title>YubiCheck</title></head><body><h1>YubiCheck</h1><form method="post"><label>Yubi OTP <input type="text" name="yubi_otp"><input type="submit" value="Check"></form></body></html>';

        return new Response(200, [], $htmlPage);
    }

    /**
     * @return \fkooman\YubiCheck\Response
     */
    private function validateYubiOtp($yubiOtp)
    {
        $response = $this->validator->verify($yubiOtp);
        $result = $response->success() ? sprintf('[OK] ID=%s', $response->id()) : sprintf('[FAIL] STATUS=%s', $response->status());
        $htmlPage = sprintf(
            '<html><head><title>YubiCheck</title></head><body><h1>YubiCheck</h1><form method="post"><label>Yubi OTP <input type="text" name="yubi_otp"><input type="submit" value="Check"></form><p>%s</p></body></html>',
            $result
        );

        return new Response(200, [], $htmlPage);
    }
}
