<?php namespace Orchestra\Story\TestCase;

use Mockery as m;
use Illuminate\Container\Container;
use Orchestra\Story\StoryServiceProvider;
use Orchestra\Foundation\Testing\TestCase;

class StoryServiceProviderTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test Orchestra\Story\StoryServiceProvider::register() method.
     *
     * @test
     */
    public function testRegisterMethod()
    {
        $app = $this->app;

        $stub = new StoryServiceProvider($app);
        $stub->register();

        $this->assertInstanceOf('\Orchestra\Story\Storyteller', $app['orchestra.story']);
        $this->assertInstanceOf('\Orchestra\Story\FormatManager', $app['orchestra.story.format']);
    }

    /**
     * Test Orchestra\Story\StoryServiceProvider::boot() method.
     *
     * @test
     */
    public function testBootMethod()
    {
        $app = $this->app;
        $app['orchestra.acl'] = $acl = m::mock('\Orchestra\Contracts\Authorization\Factory');
        $app['orchestra.app'] = $orchestra = m::mock('\Orchestra\Contracts\Foundation\Foundation');
        $app['orchestra.platform.memory'] = $memory = m::mock('\Orchestra\Contracts\Memory\Provider');
        $app['orchestra.extension.config'] = $repository = m::mock('\Orchestra\Extension\Config\Repository');

       $repository->shouldReceive('map')->once()->with('orchestra/story', m::type('Array'))->andReturn(null);

        $acl->shouldReceive('make')->once()->with('orchestra/story')->andReturn($acl)
            ->shouldReceive('attach')->once()->with($memory)->andReturn(null);

        $stub = new StoryServiceProvider($app);

        $stub->boot();
    }
}
