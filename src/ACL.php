<?php

namespace DynamicAcl;

use Illuminate\Support\Facades\Facade;

class ACL extends Facade
{
    public static function getFacadeAccessor()
    {
        return "acl_handler";
    }
}