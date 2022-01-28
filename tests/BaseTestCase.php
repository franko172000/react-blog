<?php

namespace Tests;

class BaseTestCase extends TestCase
{
    public function assetValidationError(array $data, int $errorCount)
    {
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertArrayHasKey('errorCode', $data);
        $this->assertArrayHasKey('errors', $data);

        $this->assertEquals("Your request could not be processed", $data['message']);
        $this->assertEquals(422, $data['statusCode']);
        $this->assertEquals('VALIDATION_ERROR', $data['errorCode']);

        $this->assertCount($errorCount, $data['errors']);
    }
}
