<?php

namespace Tests\Unit;

use App\Helpers\AppUtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AppUtilityHelperTest extends TestCase
{
    /**
     * Test for utility error response
     *
     * @return void
     */
    public function test_give_error_response_should_response_with_error_code()
    {
        $response = resolve(AppUtilityHelper::class)->giveErrorResponse();
        $this->assertEquals(json_decode($response->getContent())->status_code, Response::HTTP_BAD_REQUEST);
    }

    /**
     * test for utility success response
     *
     * @return void
     */
    public function test_give_success_response_should_response_with_ok_code()
    {
        $response = resolve(AppUtilityHelper::class)->giveSuccessResponse();
        $this->assertEquals(json_decode($response->getContent())->status_code, Response::HTTP_OK);
    }

    /**
     * test for utility no content response
     *
     * @return void
     */
    public function test_give_no_content_response_should_response_with_nocontent_code()
    {
        //since we are return no content response then we test for header http code only.
        $response = resolve(AppUtilityHelper::class)->giveSuccessResponse();
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }
}
