<?php

namespace App\Livewire\Extends;


use Illuminate\Database\Eloquent\Builder;

interface CrudChildMinimumTableInterface{

    // do not declare a $rules array !

    public function tableColumns(): array;

    public function mapping($item): array;

    public function mountCrud(): void;


}
