<?php

namespace App\Classes\Parsers;

use App\Contracts\IParser;
use Illuminate\Support\Str;

class PermissionUrlParser implements IParser {

    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function run()
    {
        $name = Str::replace('-action','', $this->text);
        $name = explode('.', $name);

        if( count($name) <= 1 )
            return $name[0];

        switch ($name[1]){
            case 'index':
                $name[1] = 'all';
                break;
            case 'create':
            case 'store':
                $name[1] = 'new';
                $name[0] = Str::singular($name[0]);
                break;
            case 'edit':
            case 'update':
                $name[1] = 'edit';
                $name[0] = Str::singular($name[0]);
                break;
            case 'destroy':
                $name[1] = 'delete';
                $name[0] = Str::singular($name[0]);
                break;
        }
        return "{$name[1]}-{$name[0]}";
    }
}
