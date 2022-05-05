<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Repository\ContactRepository;
use App\Service\ContactService;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiControllerTest
 * @package App\Tests\Controller
 */
class ContactServiceTest extends TestCase
{
    /** @var ContactService */
    protected $contactService;

    /** @var ContactRepository */
    protected ContactRepository $contactRepository;

    /**
     * Run before each test
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->contactRepository = $this->createMock(ContactRepository::class);
        $this->contactService = new ContactService($this->contactRepository);
    }

    /**
     * Run after each test
     * @return void
     */
    protected function tearDown(): void
    {
        $this->contactService = null;
    }

    /**
     * @dataProvider datesDataProvider
     */
    public function testValidateDates(string $date, bool $expected)
    {
        $this->assertEquals($expected, $this->contactService->filterValidateDate($date));
    }

    /**
     * @return array[]
     */
    public function datesDataProvider(): array
    {
        return
            [
                'OldValidDate' => [
                    '2019-09-12',
                    true,
                ],
                'ValidDate' => [
                    '2022-01-03',
                    true,
                ],
                'InvalidDate' => [
                    '20320-03-01',
                    false,
                ],
            ];
    }

}
