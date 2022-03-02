<?php

namespace App\Livewire\Customer\Cruds;

use App\Livewire\Extends\CrudChildMinimumTableInterface;
use App\Livewire\Extends\CrudMain;
use App\Models\Basics\Salutation;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class CustomerUserCrud extends CrudMain implements CrudChildMinimumTableInterface
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
        ];
    }


    //
    // map the model data to the viewable array
    //
    public function mapping($item): array
    {

        return [
            "salutation_id" => $item->salutation->name,
            "name" => $item->name,
            "email" => [
                "email" => $item->email,
                "verified_at" => $item->email_verified_at,
            ],

            "roles" => $this->helpRelationHasManyFormat($item, "roles", /* ["color" => "info"] */),

        ];
    }

    //
    // define the Name for one Item
    //
    public function getItemName($item): string
    {
        return $item["salutation"]["name"] . " " . $item["name"];
    }


    //
    // add all complex stuff like form fields, filters etc.
    //
    public function mountCrud(): void
    {
        //
        // Form Fields
        //

        $this->addFormField("id", null, "ID","",);

        $this->addFormField("salutation_id", "select", "Anrede",
            "required",
            [
                "relation" => "belongsTo",
                "relation_model" => "App\\Models\\Basics\\Salutation",
                "value" => Salutation::defaultSelected(),
            ]
        );

        $this->addFormField("name", "text", "Name",
            "required",
            [
                "value" => "Beispiel für ein Standardwert",
            ]
        );

        $this->addFormField("email", "email", "E-Mail",
            [
                "create" => "required|email|unique:users,email",
                "edit" => "required|email",
            ],
            [
                // global config for all forms
                "placeholder" => "mail@domain.de",

                // config only for create form
                "create" => [
                    "value" => "random". now()->format("u") ."@domain.de",
                ],

                // config only for edit form
                "edit" => [
                    "disabled" => true,
                ]
            ]
        );


        $this->addFormField("text_example", "text", "text_example",
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
        //
        // Filter
        //
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


        // Example Filter for a hasMany relation
        $this->addRelationFilter(
            "roles",
            "select",
            "Berechtigungen",
            $this->withEmptySelect(Role::select(["id", "name"])->get()->toArray()),
            "",
            "header",
            false,
        /*function ($query, $selectedValue) {
            dd($query, $selectedValue);
        }*/
        );


        // Example Filter for a belongsTo relation
        $this->addRelationFilter(
            "salutation_id",
            "select",
            "Anrede",
            $this->withEmptySelect(Salutation::select(["id", "name"])->get()->toArray()),
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
