<?php

namespace App\Livewire\Cruds\Admin;

use Timsteinhauer\LivewireCrud\CrudMain;
use Timsteinhauer\LivewireCrud\Interfaces\CrudChildMinimumTableInterface;

class CustomerCrud extends CrudMain implements CrudChildMinimumTableInterface
{

    // like App\\Models\\User
    protected string $modelPath = "App\\Models\\Customer\\Customer";

    // like user
    public string $model = "customer";

    // naming
    public string $singular = "Kunde";
    public string $plural = "Kunden";

    //
    // optional override stuff             <!---------------------------------    //
    //
    public array $with = ['users'];

    public array $searchProps = ["name"];

    public bool $allowLayoutChange = true; // default is false

    // route to detail page
    public string $detailRoute = "admin.customer";

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
            "name" => [
                "display" => "Name",
                "sorting" => true,
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
            "created_at" => $this->helpDateFormat($item->created_at),
        ];
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


        $this->addFormField("name", "text", "Name",
            "required",
        );



        //
        // complex Relationship Fields
        //

        /*$this->addFormField("roles", "badges", "Rollen",
            ["required","array","min:1"],
            [
                "relation" => "hasMany",
                "relation_model" => "Spatie\\Permission\\Models\\Role",
            ]
        );*/


        //
        //
        // Filter
        //
        //


    }

    // override create method
    public function create($form): void
    {
        // handle customer model specific create stuff

        // create new entity through eloquent
        $newModel = $this->modelPath::create($form);

        $this->storeRelationships($newModel);
    }


}
