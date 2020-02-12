<?php

namespace Fast\ACL\Providers;

use Fast\ACL\Http\Middleware\Authenticate;
use Fast\ACL\Http\Middleware\RedirectIfAuthenticated;
use Fast\ACL\Models\Activation;
use Fast\ACL\Models\Role;
use Fast\ACL\Models\User;
use Fast\ACL\Repositories\Caches\RoleCacheDecorator;
use Fast\ACL\Repositories\Eloquent\ActivationRepository;
use Fast\ACL\Repositories\Eloquent\RoleRepository;
use Fast\ACL\Repositories\Eloquent\UserRepository;
use Fast\ACL\Repositories\Interfaces\ActivationInterface;
use Fast\ACL\Repositories\Interfaces\RoleInterface;
use Fast\ACL\Repositories\Interfaces\UserInterface;
use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Event;
use Exception;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        /**
         * @var Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('auth', Authenticate::class);
        $router->aliasMiddleware('guest', RedirectIfAuthenticated::class);

        $this->app->bind(UserInterface::class, function () {
            return new UserRepository(new User);
        });

        $this->app->bind(ActivationInterface::class, function () {
            return new ActivationRepository(new Activation);
        });

        $this->app->bind(RoleInterface::class, function () {
            return new RoleCacheDecorator(new RoleRepository(new Role));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->app->register(EventServiceProvider::class);

        $this->setNamespace('core/acl')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadRoutes(['web'])
            ->loadMigrations();

        config()->set(['auth.providers.users.model' => User::class]);

        $this->app->register(HookServiceProvider::class);

        $this->garbageCollect();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-role-permission',
                    'priority'    => 2,
                    'parent_id'   => 'cms-core-platform-administration',
                    'name'        => 'core/acl::permissions.role_permission',
                    'icon'        => null,
                    'url'         => route('roles.index'),
                    'permissions' => ['roles.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-user',
                    'priority'    => 3,
                    'parent_id'   => 'cms-core-platform-administration',
                    'name'        => 'core/acl::users.users',
                    'icon'        => null,
                    'url'         => route('users.index'),
                    'permissions' => ['users.index'],
                ]);
        });
    }

    /**
     * Garbage collect activations and reminders.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function garbageCollect()
    {
        $config = $this->app->make('config')->get('core.acl.general');

        $this->sweep($this->app->make(ActivationInterface::class), $config['activations']['lottery']);
    }

    /**
     * Sweep expired codes.
     *
     * @param mixed $repository
     * @param array $lottery
     * @return void
     */
    protected function sweep($repository, array $lottery)
    {
        if ($this->configHitsLottery($lottery)) {
            try {
                $repository->removeExpired();
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }

    /**
     * Determine if the configuration odds hit the lottery.
     *
     * @param array $lottery
     * @return bool
     */
    protected function configHitsLottery(array $lottery)
    {
        return mt_rand(1, $lottery[1]) <= $lottery[0];
    }
}
