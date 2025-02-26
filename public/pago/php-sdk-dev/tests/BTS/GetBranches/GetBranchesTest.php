<?php


namespace PaylandsSDK\Tests\BTS\GetBranches;

use PaylandsSDK\Requests\GetBranchesRequest;
use PaylandsSDK\Responses\GetBranchesResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Branch;
use PaylandsSDK\Utils\HttpResponse;

class GetBranchesTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getBranchesTest_ok()
    {
        $request = new GetBranchesRequest(
            "service uuid",
            "EK6"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "bts/branches",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetBranchesResponse(
            "OK",
            200,
            "2020-02-24T10:16:07+0100",
            [
                new Branch(
                    "EK6",
                    "1",
                    "5411",
                    "BA PRESTA PRENDA PALACIO NACIONAL NEZA",
                    "MEX",
                    "MEX",
                    "CIUDAD NEZAHUALCOYOTL",
                    "PALACIO NACIONAL LOTE 65 66, METROPOLITANA 2A SECC ",
                    "54558",
                    "+55 55 5555 555",
                    "Mon to Sun:  9:00a.m - 9:00p.m."
                )
            ]
        );
        $actual = $this->paylandsClient->getBranches($request);
        $this->assertEquals($expected, $actual);
    }

    protected $responseClass = GetBranchesResponse::class;

    public function getExpectedResponse(): String
    {
        return '{
  "message": "OK",
  "code": 200,
  "current_time": "2020-02-24T10:16:07+0100",
  "branches": [
    {
      "pay_agent_cd": "EK6",
      "pay_agent_region_sd": "1",
      "pay_agent_branch_sd": "5411",
      "pay_agent_branch_ds": "BA PRESTA PRENDA PALACIO NACIONAL NEZA",
      "pay_agent_country_cd": "MEX",
      "pay_agent_state_sd": "MEX",
      "pay_agent_city": "CIUDAD NEZAHUALCOYOTL",
      "pay_agent_address": "PALACIO NACIONAL LOTE 65 66, METROPOLITANA 2A SECC ",
      "pay_agent_zipcode": "54558",
      "pay_agent_phone": "+55 55 5555 555",
      "pay_agent_schedule": "Mon to Sun:  9:00a.m - 9:00p.m."
    }
  ]
}';
    }

    public function getRequest()
    {
        return new GetBranchesRequest(
            "service uuid",
            "EK6"
        );
    }

    public function setupMockResponse($request, $expectedResponse)
    {
        $this->httpClient->expects($this->once())
            ->method("post")
            ->with($this->equalTo("bts/branches"), $this->equalTo(["json" => $request->parseRequest()]))
            ->willReturn($expectedResponse);
    }

    public function getResponse($request)
    {
        return $this->paylandsClient->getBranches($request);
    }

    public function assertions($response, $expectedResponse)
    {
    }
}
