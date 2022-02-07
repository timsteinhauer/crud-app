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

    // naming
    public string $singular = "Benutzer";
    public string $plural = "Benutzer";




    //
    // define table Head
    //
    public function tableHead(): array
    {
        return [
            "name" => [
                "display" => "Name",
                "sorting" => true,
            ],
            "email" => [
                "display" => "E-Mail",
                "sorting" => true,
            ],
            "roles" => [
                "display" => "Berechtigungen",
                "sorting" => false,
            ],
            "last_login_at" => [
                "display" => "Letzter Login",
                "sorting" => true,
                "class" => "text-right",
            ],
            "created_at" => [
                "display" => "Erstellt",
                "sorting" => true,
                "class" => "text-right",
            ],
        ];
    }

    //
    // map the model data to the viewable array
    //
    public function mapping($item): array
    {
        return [
            "id" => $item->id,
            "name" => $item->name,
            "email" => [
                "email" => $item->email,
                "verified_at" => $item->email_verified_at,
            ],
            "created_at" => $this->helpDateFormat($item->created_at),
        ];
    }



    /*

    public function onUpdate(): Builder
    {
        return User::query();
    }


    */
}
