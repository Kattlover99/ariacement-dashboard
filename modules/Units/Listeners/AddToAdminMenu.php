<?php

namespace Modules\Units\Listeners;

use App\Events\Menu\AdminCreated as Event;

class AddToAdminMenu
{
    public function handle(Event $event)
    {
        // Add child to existing menu item
//        $item = $event->menu->whereTitle(trans_choice('general.items', 2));
//        $item->route('items.index', trans_choice('general.items', 2), [], 1, ['icon' => '']);
//        $item->route('units.index', trans('units::general.name'), [], 2, ['icon' => '']);

        // Add new menu item
        $event->menu->add([
            'route' => ['units.index', []],
            'title' => trans('units::general.name'),
            'icon' => 'fas fa-pen',
            'order' => 21,
        ]);
    }
}