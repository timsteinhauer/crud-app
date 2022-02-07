<?php

namespace App\Livewire\Extends;


use Illuminate\Database\Eloquent\Builder;

interface CrudChildInterface{

    //


    public function tableHead(): array;

    public function mapping($item): array;
}
