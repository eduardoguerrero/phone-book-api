<?php

namespace App\Tests\Controller;

use App\Controller\ApiController;
use App\Exception\InvalidHttpBodyData;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiControllerTest
 * @package App\Tests\Controller
 */
class ApiControllerTest extends TestCase
{
    /** @var ApiController */
    protected $apiController;

    /**
     * Run before each test
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->apiController = new ApiController();
    }

    /**
     * Run after each test
     * @return void
     */
    protected function tearDown(): void
    {
        $this->apiController = null;
    }

    /**
     * @return void
     * @throws \App\Exception\InvalidHttpBodyData
     */
    public function testInvalidRequestBodyMessageException(): void
    {
        $this->expectExceptionMessage('Invalid request body');
        $this->apiController->getHttpBodyData(new Request());
    }

    /**
     * @return void
     * @throws InvalidHttpBodyData
     */
    public function testInvalidRequestBodyException(): void
    {
        $this->expectException(InvalidHttpBodyData::class);
        $this->apiController->getHttpBodyData(new Request());
    }

    /**
     * @return void
     * @throws InvalidHttpBodyData
     */
    public function testGetHttpBodyData(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'firstname' => 'Joe',
            'lastname' => 'Doe'
        ]));
        $result = $this->apiController->getHttpBodyData($request);
        $this->assertArrayHasKey('firstname', $result);
        $this->assertArrayHasKey('lastname', $result);
        $this->assertEquals('Joe', $result['firstname']);
        $this->assertEquals('Doe', $result['lastname']);
    }

}
