<?php

namespace App\Livewire\Extends;

use Livewire\Component;
use Livewire\WithPagination;
use function view;
use Illuminate\Database\Eloquent\Builder;


class CrudMain extends Component
{

    //
    //      override and set in child PHP Class          <!-------------------------------
    //

    // like App\\Models\\User
    protected string $modelPath = "You cant use these Class directly!";

    // like user
    public string $model;

    // livewire default rules array
    public array $rules = [];



    //
    //      other optional(!) override stuff             <!---------------------------------
    //


    //
    // allow of soft deleting and restoring
    // remember to activate $table->softDeletes(); in the migration of your model!
    //
    public bool $useSoftDeleting = false;

    //
    // no create, edit, delete, restore or cloning
    //
    public bool $viewOnlyMode = false;


    // default page
    public string $currentPage = "index";

    // default index layout style
    public string $indexLayout = "table"; // "table" or "cards"

    // default searchable props
    public array $searchProps = ["name"];

    // default Search String
    public string $search = "";

    // default sorting Field
    public string $sortField = "id";

    // default sorting direction
    public bool $sortAsc = true;

    // default pagination per page
    public int $perPage = 10;

    // default filter
    public array $filter = [];

    // allow a deeplink to filter-, sorted- and searching results with custom per page count
    protected $queryString = [
        'search',
        'sortAsc',
        'sortField',
        'perPage',
        'filter',
    ];

    //
    // End of override stuff                        <!---------------------------------
    //
    //
    //  do not change something below this line !!!
    //
    //

    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    //
    // path to livewire views
    //
    public string $path = "livewire.extends.crud-main";

    // path to the folder with all child classes views
    public string $childPath = "cruds."; // see mount()!



    // the config to create the filter view in index header
    public array $filterConfig = [];

    // the config to create the sortable columns view in index.table-header
    public array $sortingConfig = [];

    // the model items
    public array $items = [];

    // the pagination stuff
    public array $pagination = [];


    //
    // Helper Stuff
    //

    protected array $defaultFilterArray = [
        ["id" => "-", "name" => "-"]
    ];


    //
    //
    //      main methods
    //
    //
    public function rules(): array{
        return [];
    }

    public function mount()
    {
        // set child classes path
        $this->childPath .= $this->model .'-crud.override';

        // mounting everything up
        /*if (method_exists($this, 'getCrudDefaultSortingField')) {
            $this->sortField = $this->model::getCrudDefaultSortingField();
        }*/

        // first load of refreshable stuff
        $this->refresh();
    }

    //
    // load every stuff, witch must be refreshable
    //
    public function refresh()
    {
        $this->loadItems();
    }


    public function updated($propName, $propValue)
    {
        // fix empty rules
        if (count($this->rules) == 0) {
            $this->rules = $this->rules();
        }

        if (method_exists($this, 'onUpdate')) {
            // call Child-Class custom updated handling
            return $this->onUpdate();
        }

        $onUpdateProp = 'onUpdate_' . str_replace('.', '_', $propName);
        if (method_exists($this, $onUpdateProp)) {
            // call Child-Class custom updated handling for specific property
            return $this->{$onUpdateProp}();
        }


        if (isset($this->rules[$propName])) {
            $this->validateOnly($propName);
        }
    }


    public function render()
    {
        return view('livewire.extends.crud-main.index');
    }


    //
    //
    //          business logic methods
    //
    //

    //
    // build the main query and get the paginated data
    //
    public function loadItems()
    {
        $query = $this->getQuery();

        // searching
        $query = $this->searching($query);

        // filtering
        $query = $this->filtering($query);

        // sorting
        $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        // fire
        $pagination = $query->paginate($this->perPage);

        //
        // map data from objects to viewable arrays
        // and store items them in a separately public array
        //

        if( !method_exists($this, 'mapping')){
            die("Hier läuft etwas ganz dolle falsch! Du musst in einer Child-Class eine Funktion mapping() haben... Wie sie vom Interface vorgegeben wird!");
        }

        $this->items = [];
        foreach ($pagination as $item){
            $this->items[] = $this->mapping($item);
        }

        // convert
        $pagination = $pagination->toArray();

        // remove data (items)
        unset($pagination["data"]);

        // store the rest of the pagination in a public array
        $this->pagination = $pagination;
    }

    protected function getQuery(): Builder
    {
        if (method_exists($this, 'query')) {
            // get query from child Crud-Class
            return $this->query();
        }

        return $this->modelPath::query();
    }

    protected function searching($query): Builder
    {

        if ($this->search == "") {
            return $query;
        }

        $search = $this->search;

        $query->where(function ($query) use ($search) {
            foreach ($this->searchProps as $i => $prop){
                $query->orWhere($prop, 'like', '%' . $search . '%');
            }
        });

        return $query;
    }


    protected function filtering($query): Builder
    {

        foreach ($this->filter as $key => $value) {
            if ($value !== '-') {

                if ($value === 'notNull') {
                    $query->whereNotNull($key);
                } elseif ($value === 'isNull') {
                    $query->whereNull($key);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        return $query;
    }
}
