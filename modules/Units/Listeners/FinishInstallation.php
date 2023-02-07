<?php

namespace Modules\Units\Listeners;

use App\Events\Module\Installed as Event;
use App\Traits\Permissions;
use Artisan;

class FinishInstallation
{
    use Permissions;

    public $alias = 'units';

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        $this->updatePermissions();

        //$this->callSeeds();
    }

    protected function updatePermissions()
    {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-main' => 'c,r,u,d',
        ]);
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => session('company_id'),
            '--class' => 'Modules\Units\Database\Seeds\UnitsDatabaseSeeder',
        ]);
    }
}
