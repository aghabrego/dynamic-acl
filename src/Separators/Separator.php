<?php

namespace DynamicAcl\Separators;

use Illuminate\Support\Manager;
use DynamicAcl\Separators\{RouteName, Uri};

class Separator extends Manager
{
    public function getDefaultDriver()
    {
        return config('dynamicACL.separator_driver', 'name');
    }

    protected function createNameDriver()
    {
        return resolve(RouteName::class);
    }
}