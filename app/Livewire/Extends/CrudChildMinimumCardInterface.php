<?php

namespace App\Livewire\Extends;


use Illuminate\Database\Eloquent\Builder;

interface CrudChildMinimumCardInterface{

    // do not declare a $rules array !

    public function tableColumns(): array;

    public function mapping($item): array;

    public function initCrud(): void;


}
