<?php

namespace PaylandsSDK\Tests\Batch\SendRefundsFile;

use PaylandsSDK\Requests\SendRefundsFileRequest;
use PaylandsSDK\Responses\SendRefundsFileResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\BatchError;
use PaylandsSDK\Utils\HttpResponse;

class SendRefundsFileTest extends TestBase
{
    /**
 * @return void
 */
    public function test_sendRefundsFileTest_ok()
    {
        $request = new SendRefundsFileRequest(
            "test.csv",
            "QU1PVU5ULENBUkQsQ1VTVE9NRVJfRVhURVJOQUxfSUQsU0VSVklDRSxBRERJVElPTkFMLFVSTF9QT1NUDQoxMjAzNSxFNzZBNTdGRi00REJDLTRBM0QtQjZFMy0wNTIwRThCMTNFM0YsMzA4LDExNEFCNDI0LTAyM0ItNEUxMy",
            "2017-11-11 11:11:11"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'batch/refunds',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $actual = $this->paylandsClient->sendRefundsFile($request);

        $expected = new SendRefundsFileResponse(
            "OK",
            200,
            "2017-10-26T17:28:06+0200"
        );

        $this->assertEquals($expected, $actual);
    }

    /**
 * @return void
 */
    public function test_sendRefundsFileTest_with_errors()
    {
        $request = new SendRefundsFileRequest(
            "test.csv",
            "QU1PVU5ULENBUkQsQ1VTVE9NRVJfRVhURVJOQUxfSUQsU0VSVklDRSxBRERJVElPTkFMLFVSTF9QT1NUDQoxMjAzNSxFNzZBNTdGRi00REJDLTRBM0QtQjZFMy0wNTIwRThCMTNFM0YsMzA4LDExNEFCNDI0LTAyM0ItNEUxMy",
            "2017-11-11 11:11:11"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'batch/refunds',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $actual = $this->paylandsClient->sendRefundsFile($request);

        $expected = new SendRefundsFileResponse(
            "OK",
            200,
            "2017-10-26T17:28:06+0200",
            [
                new BatchError("13", "Invalid card")
            ]
        );

        $this->assertEquals($expected, $actual);
    }
}
