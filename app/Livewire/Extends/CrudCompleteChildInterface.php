<?php

namespace App\Livewire\Extends;


use Illuminate\Database\Eloquent\Builder;

interface CrudCompleteChildInterface{

    // do not declare a $rules array !

    public function tableColumns(): array;

    public function mapping($item): array;

    public function mountCrud(): void;


    //
    // full stack
    //

    //
    public function getItemIdentifier($item): string;

    public function beforeOpenEditForm($item): void;

    // custom child class create method to handle relations etc.
    public function create($form): void;

}
