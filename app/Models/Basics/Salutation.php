<?php

namespace App\Models\Basics;

use App\Livewire\Extends\CrudMain;
use Illuminate\Database\Eloquent\Model;

class Salutation extends Model
{

    public static function toSelect($withEmptyRow = false): array
    {
        return CrudMain::modelWithEmptySelect($withEmptyRow, self::select(["id", "name"])->get()->toArray());
    }

    public static function defaultSelected(): int
    {
        // return default id
        return 1;
    }

}
