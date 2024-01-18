<?php

namespace Tests\Http;

use App\Http\Enums\HttpMethod;
use App\Http\Router;
use App\Http\Routes\RouteContract;
use Exception;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @test
     */
    public function returns404OnNonExistingRoute(): void
    {
        $router = Router::getInstance();

        $_SERVER['REQUEST_METHOD'] = 'get';
        $_SERVER['REQUEST_URI'] = 'non/existing/route';

        $router->handleRequest();

        $this->assertEquals(404, http_response_code());
    }

    /**
     * @test
     */
    public function returns500OnExceptionInRoute(): void
    {
        $router = Router::getInstance();

        $mockBuilder = $this->getMockBuilder(RouteContract::class);

        $mockBuilder->onlyMethods([
            'method',
            'uri',
            'canHandle',
            'handle',
        ]);

        $mock = $mockBuilder->getMock();

        $mock->expects($this->any())->method('method')->willReturn($method = HttpMethod::GET->value);
        $mock->expects($this->any())->method('uri')->willReturn($uri = 'some/uri');
        $mock->expects($this->once())->method('canHandle')->willReturn(true);
        $mock->expects($this->once())->method('handle')->willThrowException(new Exception());

        $router->addRoute($mock);

        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        $router->handleRequest();

        $this->assertEquals(500, http_response_code());
    }
}
