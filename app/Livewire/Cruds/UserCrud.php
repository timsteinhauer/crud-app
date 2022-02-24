<?php

namespace App\Livewire\Cruds;

use App\Livewire\Extends\CrudChildMinimumTableInterface;
use App\Livewire\Extends\CrudMain;
use App\Models\Basics\Salutation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserCrud extends CrudMain implements CrudChildMinimumTableInterface
{

    // like App\\Models\\User
    protected string $modelPath = "App\\Models\\User";

    // like user
    public string $model = "user";

    // naming
    public string $singular = "Benutzer";
    public string $plural = "Benutzer";

    //
    // optional override stuff             <!---------------------------------    //
    //
    public array $with = ["roles"];

    public array $searchProps = ["name", "email"];

    public bool $allowLayoutChange = true; // default is false

    // end



    //
    // define table Head
    //
    public function tableColumns(): array
    {
        return [
            "id" => [
                "display" => "ID",
                "sorting" => true,
            ],
            "salutation_id" => [
                "display" => "Anrede",
                "sorting" => true,
            ],
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
                "sorting" => false,
                "class" => "text-nowrap",
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
            "salutation_id" => $item->salutation->name,
            "name" => $item->name,
            "email" => [
                "email" => $item->email,
                "verified_at" => $item->email_verified_at,
            ],

            "roles" => $this->helpRelationHasManyFormat($item, "roles", /* ["color" => "info"] */),

            "last_login_at" => $this->helpDateFormat($item->last_login_at),
            "created_at" => $this->helpDateFormat($item->created_at),
        ];
    }

    //
    // define the Name for one Item
    //
    public function getItemIdentifier($item): string
    {
        return $item["salutation"]["name"] . " " . $item["name"];
    }


    //
    // add all complex stuff like form fields, filters etc.
    //
    public function initCrud(): void
    {
        //
        // Form Fields
        //

        $this->addFormField("id", null, "ID","",);

        $this->addFormField("salutation_id", "select", "Anrede",
            "required",
            [
                "options" => Salutation::toSelect(true),
                "value" => Salutation::defaultSelected(),
            ]
        );

        $this->addFormField("name", "text", "Name",
            "required",
            [
                "value" => "Beispiel für ein Standardwert",
            ]
        );

        $this->addCreateFormField("email", "email", "E-Mail",
            "required|email|unique:users,email",
            [
                "value" => "random". now()->format("u") ."@domain.de",
                "placeholder" => "mail@domain.de",
            ]
        );

        $this->addEditFormField("email", "email", "E-Mail",
            "",
            [
                "disabled" => true,
                "placeholder" => "mail@domain.de",
            ]
        );

        $this->addEditFormField("text_example", "text", "text_example",
            "",
            [
                "value" => "Standardwert",
            ]
        );

        //
        // complex Relationship Fields
        //

        $this->addFormField("roles", "badges", "Rollen",
            ["required","array","min:1"],
            [
                "relation" => "hasMany",
                "relation_model" => "Spatie\\Permission\\Models\\Role",
            ]
        );


        //
        // Filter
        //

        $this->addFilter(
            "email_verified_at",
            "select",
            "E-Mail verifiziert",
            $this->withEmptySelect(
                [
                    ["id" => "not-null", "name" => "Verifiziert"],
                    ["id" => "null", "name" => "Nicht verifiziert"],
                ],
            ),
            "",
            "email",
            true,
            /*function ($query, $selectedValue) {
                dd($query, $selectedValue);
            }*/
        );

        $this->addRelationFilter(
            "roles",
            "select",
            "Berechtigungen",
            $this->withEmptySelect(Role::select(["id", "name"])->get()->toArray()),
            "",
            "header",
            true,
            /*function ($query, $selectedValue) {
                dd($query, $selectedValue);
            }*/
        );
    }

    // override create method
    public function create($form): void
    {
        // handle user model specific create stuff

        // set random password
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%&!$%&!$%&!$%&');
        $password = substr($random, 0, 12);
        $form["password"] = Hash::make($password);

        // create new entity through eloquent
        $newModel = $this->modelPath::create($form);

        $this->storeRelationships($newModel);
    }


}
