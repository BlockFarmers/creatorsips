<?php

namespace Azuriom\Plugin\CreatorsIps\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Models\User;
use Azuriom\Plugin\CreatorsIps\Models\CreatorIp;

class CreatorsIpsServiceProvider extends BasePluginServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom($this->pluginPath('config/creatorsips.php'), 'creatorsips');
    }

    public function boot(): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->registerAdminNavigation();

        Permission::registerPermissions([
            'creatorsips.admin' => 'creatorsips::admin.permission',
        ]);

        User::created(fn (User $user) => CreatorIp::linkPendingTo($user));
    }

    protected function adminNavigation(): array
    {
        return [
            'creatorsips' => [
                'name' => trans('creatorsips::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-megaphone',
                'route' => 'creatorsips.admin.*',
                'permission' => 'creatorsips.admin',
                'items' => [
                    'creatorsips.admin.ips.index' => [
                        'name' => trans('creatorsips::admin.nav.ips'),
                        'permission' => 'creatorsips.admin',
                    ],
                    'creatorsips.admin.settings' => [
                        'name' => trans('creatorsips::admin.nav.settings'),
                        'permission' => 'creatorsips.admin',
                    ],
                ],
            ],
        ];
    }
}
