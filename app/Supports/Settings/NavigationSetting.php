<?php  namespace App\Supports\Settings;

use Illuminate\Support\Collection;
use Sentinel;

class NavigationSetting 
{
	
	public $items = [];
    
    public $settingItems = [];
	
	protected static $settingItemDefaults = [
        'code'        => null,
        'label'       => null,
        'icon'        => null,
        'url'         => null,
        'order'       => -1,
        'segment'     => 1,
        // 'attributes'  => [],
        'permissions' => [],
    ];
    
    public function register(array $attributes = array())
    {
        $this->settingItems = array_merge($this->settingItems, $attributes);
    }
	
    public function render(array $attributes = array())
    {
        $user = Sentinel::getUser();

        foreach ($this->settingItems as $code => $main) {
            $item = (object) array_merge(self::$settingItemDefaults, array_merge($main, [
                'code'  => $code,
                'owner' => $code
            ]));
            
            $this->items[$code] = $item;
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
    
    public function isMainMenuItemActive($item)
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