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
                "class" => "",
            ],
            "created_at" => [
                "display" => "Erstellt",
                "sorting" => true,
                "class" => "",
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


    //
    // create form fields
    //
    public function initFormFields(): void
    {

        $this->addFormField("name", "text", "Name");

        $this->addCreateFormField("email", "email", "E-Mail");

        $this->addEditFormField("email", "email", "E-Mail",
            [
                "disabled" => true,
            ]
        );

    }

    public function beforeOpenEditForm($item)
    {

        #    dd($item);

    }

    public function defaultCreateFormData(): array
    {

        return [
            "name" => "Max Muster",
        ];

    }


    /*

    public function onUpdate(): Builder
    {
        return User::query();
    }


    */
}
