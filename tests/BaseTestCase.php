<?php

namespace Tests;

class BaseTestCase extends TestCase
{
    protected function handleSingleFieldValidation($response, $message)
    {
        $data = json_decode($response->content(), true);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertArrayHasKey('errorCode', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals("Your request could not be processed", $data['message']);
        $this->assertEquals(422, $data['statusCode']);
        $this->assertEquals('VALIDATION_ERROR', $data['errorCode']);
        $this->assertCount(1, $data['errors']);
        $errors = $data['errors'];
        $this->assertEquals($message, $errors[0]);
        $response->assertStatus(422);
    }

    protected function handleUnAuthenticatedAssertions($response)
    {
        $data = json_decode($response->content(), true);

        $response->assertJsonStructure([
            'message',
            'statusCode',
            'errorCode'
        ]);

        $this->assertEquals('Unauthenticated.', $data['message']);
        $this->assertEquals(401, $data['statusCode']);
        $this->assertEquals("UNAUTHORIZED_ERROR", $data['errorCode']);
        $response->assertStatus(401);
    }
}
