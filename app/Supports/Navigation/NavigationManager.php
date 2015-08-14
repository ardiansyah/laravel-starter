<?php  namespace App\Supports\Navigation;

use Sentinel;

/**
*
*/
class NavigationManager
{

    protected $items = array();

    protected $childItems = array();

    protected $navigationItems = [];

    protected static $navigationItemDefaults = [
        'code'        => null,
        'label'       => null,
        'icon'        => null,
        'url'         => null,
        'order'       => -1,
        'segment'     => 1,
        'attributes'  => [],
        'permissions' => [],
        'childMenu'    => []
    ];

    protected static $navigationChildItemDefaults = [
        'code'        => null,
        'group'        => null,
        'label'       => null,
        'icon'        => null,
        'url'         => null,
        'order'       => -1,
        'segment'     => 2,
        'attributes'  => [],
        'permissions' => []
    ];

    public function register(array $attributes = array())
    {
        $this->navigationItems = array_merge($this->navigationItems, $attributes);
    }

    public function render(array $attributes = array())
    {
        $user = Sentinel::getUser();

        foreach ($this->navigationItems as $code => $main) {
            $item = (object) array_merge(self::$navigationItemDefaults, array_merge($main, [
                'code'  => $code,
                'owner' => $code
            ]));

            $this->items[$code] = $item;
            foreach ($item->childMenu as $childCode => $child) {
                // $this->filterItemPermissions($user, $child[$childCode]);
                $item->childMenu[$childCode] = (object) array_merge(
                    self::$navigationChildItemDefaults,
                    array_merge($child, [
                        'code'  => $childCode,
                        // 'owner' => $code
                    ])
                );

            }

        }

        uasort($this->items, function ($a, $b) {
            return $a->order - $b->order;
        });


        $this->items = $this->filterItemPermissions($user, $this->items);

        return $this->items;
    }

    public function items()
    {
        return $this->items = $this->render();
    }

    public function listMainMenuItems()
    {
        return $this->items();
    }

    public function listChildMenu()
    {
        foreach ($this->listMainMenuItems() as $item) {
            if ($this->isMainMenuItemActive($item)) {
                $activeItem = $item;
                break;
            }

            $activeItem = null;
        }

        if (!$activeItem) {
            return [];
        }

        // $items = $activeItem->childMenu;
        $user = Sentinel::getUser();
        $items = $this->filterItemPermissions($user, $activeItem->childMenu);;

        return $items;;
    }

    public function isMainMenuItemActive($item)
    {
         return \Request::segment($item->segment) ==  $item->code ? true : false;
    }

    public function isChildMenuItemActive($item)
    {
         return \Request::segment($item->segment) ==  $item->code ? true : false;
    }

    /**
     * Removes menu items from an array if the supplied user lacks permission.
     * @param User $user A user object
     * @param array $items A collection of menu items
     * @return array The filtered menu items
     */
    protected function filterItemPermissions($user, array $items)
    {
        if (!$user) {
            return $items;
        }

        $items = array_filter($items, function ($item) use ($user) {
            if (!$item->permissions ) {
                return true;
            }

            if($user->hasAccess('superuser')){
                return true;
            }

            return $user->hasAnyAccess($item->permissions);
        });

        return $items;
    }

}
