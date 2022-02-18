<?php

namespace App\Livewire\Extends;


use Illuminate\Database\Eloquent\Builder;

interface CrudChildInterface{

    // do not declare a $rules array !

    public function tableHead(): array;

    public function mapping($item): array;

    public function initFormFields(): void;

    //
    // full stack
    //
    public function beforeOpenEditForm($item);

}
