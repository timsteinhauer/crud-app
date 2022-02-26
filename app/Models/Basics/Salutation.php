<?php

namespace App\Models\Basics;

use App\Livewire\Extends\CrudMain;
use Illuminate\Database\Eloquent\Model;

class Salutation extends Model
{

    public static function toSelect($withEmptyRow = false): array
    {
        $options = self::select(["id", "name"])->get()->toArray();

        if( $withEmptyRow ){
            return CrudMain::withEmptySelect($options);
        }

        return $options;
    }

    public static function defaultSelected(): int
    {
        // return default id
        return 1;
    }

}
