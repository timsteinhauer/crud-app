<?php

namespace App\Livewire\Cruds\Admin;


use App\Models\Basics\Salutation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

use Timsteinhauer\LivewireCrud\CrudMain;
use Timsteinhauer\LivewireCrud\Interfaces\CrudChildMinimumTableInterface;

use function now;


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

    // change Subpage Layout to modals
    public string $pageStyle = "modal";


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
            ["required"],
            [
                "relation" => "belongsTo",
                "relation_model" => "App\\Models\\Basics\\Salutation",
                "value" => Salutation::defaultSelected(),
            ]
        );

        $this->addFormField("name", "text", "Name",
            ["required"],
            [
                "value" => "Beispiel für ein Standardwert",
            ]
        );

        $this->addFormField("email", "email", "E-Mail",
            [
                "create" => ["required","email","unique:users,email"],
                "edit" => ["required","email"],
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
                "options" => Role::select(["id","name"])->where("is_operator_role", 1)->get()->toArray(),
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
            $this->withEmptySelect(Role::select(["id", "name"])->where('is_operator_role', 1)->get()->toArray()),
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

    protected function query(): Builder
    {
        // only admin / operator users (operator == 1)
        return $this->modelPath::query()->with($this->with)->where('is_operator', 1);
    }


    // override create method
    public function create($form): void
    {
        // handle user model specific create stuff

        // set random password
        $form["password"] = User::randomPasswordHash();

        // this form creates admin users
        $form["is_operator"] = 1;

        // operator users belongs to no customer
        $form["customer_id"] = null;

        // create new entity through eloquent
        $newModel = $this->modelPath::create($form);

        $this->storeRelationships($newModel);
    }


}
