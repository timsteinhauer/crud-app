<?php

namespace App\Livewire\Cruds;

use App\Livewire\Extends\CrudChildInterface;
use App\Livewire\Extends\CrudMain;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class UserCrud extends CrudMain implements CrudChildInterface
{

    // like App\\Models\\User
    protected string $modelPath = "App\\Models\\User";

    // like user
    public string $model = "user";

    // livewire default rules array
    public array $rules = [];

    // wordings
    public array $wordings = [
        "name" => "Benutzer",
        "names" => "Benutzer",
        "no_items" => "Keine Benutzer vorhanden",
    ];


    // build the query to load all data
    // without SEARCH, FILTER or SORTING stuff!
    // and without all(), or get() or paginate()
    public function query(): Builder
    {
        return User::query();
    }


    // map the model data to the viewable array
    public function mapping($item): array
    {

        return [
            "id" => $item->id,
            "name" => $item->name,
            "email" => [
                "email" => $item->email,
                "verified_at" => $item->email_verified_at,
            ],
            "created_at" => $item->created_at
        ];
    }




    /*




    public function onUpdate(): Builder
    {
        return User::query();
    }


    */
}
