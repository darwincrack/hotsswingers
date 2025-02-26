<?php

namespace PaylandsSDK\Tests\Batch\SendPaymentFile;

use PaylandsSDK\Requests\SendPaymentFileRequest;
use PaylandsSDK\Responses\SendPaymentFileResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\BatchError;
use PaylandsSDK\Utils\HttpResponse;

class SendPaymentFileTest extends TestBase
{
    /**
     * @return void
     */
    public function test_sendPaymentFileTest_with_errors()
    {
        $request = new SendPaymentFileRequest(
            "test.csv",
            "QU1PVU5ULENBUkQsQ1VTVE9NRVJfRVhURVJOQUxfSUQsU0VSVklDRSxBRERJVElPTkFMLFVSTF9QT1NUDQoxMjAzNSxFNzZBNTdGRi00REJDLTRBM0QtQjZFMy0wNTIwRThCMTNFM0YsMzA4LDExNEFCNDI0LTAyM0ItNEUxMy",
            "E82E54A1-7D6B-4AC8-8C36-99868ECD1EE4",
            "2017-11-11 11:11:11"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'batch/authorizations',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $actual = $this->paylandsClient->sendPaymentFile($request);

        $expected = new SendPaymentFileResponse(
            "OK",
            200,
            "2017-10-26T17:28:06+0200",
            [
                new BatchError("13", "Invalid card")
            ]
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_sendPaymentFileTest_ok()
    {
        $request = new SendPaymentFileRequest(
            "test.csv",
            "QU1PVU5ULENBUkQsQ1VTVE9NRVJfRVhURVJOQUxfSUQsU0VSVklDRSxBRERJVElPTkFMLFVSTF9QT1NUDQoxMjAzNSxFNzZBNTdGRi00REJDLTRBM0QtQjZFMy0wNTIwRThCMTNFM0YsMzA4LDExNEFCNDI0LTAyM0ItNEUxMy",
            "E82E54A1-7D6B-4AC8-8C36-99868ECD1EE4",
            "2017-11-11 11:11:11"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'batch/authorizations',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $actual = $this->paylandsClient->sendPaymentFile($request);

        $expected = new SendPaymentFileResponse(
            "OK",
            200,
            "2017-10-26T17:28:06+0200"
        );

        $this->assertEquals($expected, $actual);
    }
}
