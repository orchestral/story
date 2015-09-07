<?php namespace Orchestra\Story\Http\Handlers\TestCase;

use Mockery as m;
use Orchestra\Contracts\Auth\Guard;
use Orchestra\Widget\Handlers\Menu;
use Orchestra\Foundation\Support\MenuHandler;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Story\Http\Handlers\StoryMenuHandler;

class StoryMenuHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testItIsInitializable()
    {
        $app = m::mock(Application::class);
        $menu = m::mock(Menu::class);

        $app->shouldReceive('make')->once()->with('orchestra.platform.menu')->andReturn($menu);

        $stub = new StoryMenuHandler($app);

        $this->assertInstanceOf(StoryMenuHandler::class, $stub);
        $this->assertInstanceOf(MenuHandler::class, $stub);
    }

    public function testItCantBeAuthorizedWhenGivenGuest()
    {
        $app = m::mock(Application::class);
        $menu = m::mock(Menu::class);
        $guard = m::mock(Guard::class);

        $app->shouldReceive('make')->once()->with('orchestra.platform.menu')->andReturn($menu);
        $guard->shouldReceive('guest')->once()->andReturn(true);

        $stub = new StoryMenuHandler($app);

        $this->assertFalse($stub->authorize($guard));
    }

    public function testItCanBeAuthorizedWhenGivenUser()
    {
        $app = m::mock(Application::class);
        $menu = m::mock(Menu::class);
        $guard = m::mock(Guard::class);

        $app->shouldReceive('make')->once()->with('orchestra.platform.menu')->andReturn($menu);
        $guard->shouldReceive('guest')->once()->andReturn(false);

        $stub = new StoryMenuHandler($app);

        $this->assertTrue($stub->authorize($guard));
    }
}
