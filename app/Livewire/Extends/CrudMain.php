<?php

namespace App\Livewire\Extends;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use function view;
use Illuminate\Database\Eloquent\Builder;


class CrudMain extends Component
{

    //
    // todo Crud Main Features
    //
    // 1. SubQuery Sorting
    //
    //

    //
    //      override and set this stuff in child PHP Class          <!-------------------------------
    //

    // like App\\Models\\User
    protected string $modelPath = "You cant use these Class directly!";

    // like user
    public string $model;

    // livewire default rules array
    public array $rules = [];

    // naming
    public string $singular = "";
    public string $plural = "";


    //
    //
    //
    //
    //
    //      other optional(!) override stuff             <!---------------------------------
    //


    //
    // allow of soft deleting and restoring
    // remember to activate $table->softDeletes(); in the migration of your model!
    //
    public bool $useSoftDeleting = false;

    //
    // handling current user abilities
    //
    public array $allowed = [
        "create" => true,
        "open" => true,
        "edit" => true,
        "delete" => true,
        "restore" => true,
        "clone" => true,
        // features
        "show_search" => true,
        "show_filter" => true,
    ];

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
    // wording stuff, witch could be different for other models
    //
    public array $wordings = [
        "name" => "",
        "names" => "",
        // index view
        "no_items" => "Keine Benutzer vorhanden",
        // header
        "new" => "Neu +",
        "search" => "Benutzer suchen...",
    ];

    //
    // styling stuff, witch could be different for other models
    //
    public array $styling = [
        "action_column_class" => "text-center",
        "action_column_style" => "min-width: 120px",
    ];

    //
    //
    //
    public array $perPageConfig = [
        ["value" => "10", "name" => "10"],
        ["value" => "25", "name" => "25"],
        ["value" => "50", "name" => "50"],
        ["value" => "100", "name" => "100"],
        ["value" => "250", "name" => "250"],
        ["value" => "0", "name" => "Alle"],
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
    public array $paginator = [];


    //
    // Helper Stuff
    //

    protected array $defaultFilterArray = [
        ["id" => "-", "name" => "-"]
    ];

    //
    // Helper Methods
    //

    public function helpDateFormat($str, $format = "d.m.Y"): string
    {
        return Carbon::parse($str)->format($format);
    }

    public function helpDatetimeFormat($str, $format = "d.m.Y H:i"): string
    {
        return Carbon::parse($str)->format($format);
    }


    //
    //
    //      main methods
    //
    //
    public function rules(): array
    {
        return [];
    }

    public function mount()
    {
        // set child classes path
        $this->childPath .= $this->model . '-crud.override';

        // set wordings
        $this->wordings["name"] = $this->singular;
        $this->wordings["names"] = $this->plural;


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
            $this->onUpdate();
        }


        $onUpdateProp = 'onUpdate_' . str_replace('.', '_', $propName);
        if (method_exists($this, $onUpdateProp)) {
            // call Child-Class custom updated handling for specific property
            $this->{$onUpdateProp}($propValue);
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
    // fix pagination trait, to only refresh when it is necessary
    //

    public function previousPageFix($pageName = 'page')
    {
        $this->previousPage($pageName);
        $this->loadItems();
    }

    public function nextPageFix($pageName = 'page')
    {
        $this->nextPage($pageName);
        $this->loadItems();
    }

    public function gotoPageFix($page, $pageName = 'page')
    {
        $this->gotoPage($page, $pageName);
        $this->loadItems();
    }



    //
    //
    //
    //
    //          business logic methods
    //
    //

    //
    // add hooks to Crud Main
    //
    protected function addBeforeHook($functionName): void
    {
        $this->addHook("before", $functionName);
    }
    protected function addAfterHook($functionName): void
    {
        $this->addHook("after", $functionName);
    }

    protected function addHook($hookName, $functionName = ""): void
    {
        $hookName .= ucfirst($functionName);

        // if hook exists in child class
        if (method_exists($this, $hookName)) {
            // call the hook
            $this->{$hookName}();
        }
    }


    //
    // reload items on change perPage
    //
    protected function onUpdate_perPage($propValue)
    {
        $this->loadItems();
    }

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
        $paginator = $query->paginate($this->perPage);

        //
        // map data from objects to viewable arrays
        // and store items them in a separately public array
        //

        if (!method_exists($this, 'mapping')) {
            die("Hier läuft etwas ganz dolle falsch! Du musst in einer Child-Class eine Funktion mapping() haben... Wie sie vom Interface vorgegeben wird!");
        }

        $this->items = [];
        foreach ($paginator as $item) {
            $this->items[] = $this->mapping($item);
        }

        // convert
        $paginatorArr = $paginator->toArray();

        $paginatorArr["total"] = $paginator->total();
        $paginatorArr["hasPages"] = $paginator->hasPages();
        $paginatorArr["onFirstPage"] = $paginator->onFirstPage();
        $paginatorArr["currentPage"] = $paginator->currentPage();
        $paginatorArr["hasMorePages"] = $paginator->hasMorePages();
        $paginatorArr["elements"] = $paginator->links()["elements"];

#dd($paginator->links()["elements"]);
        // remove data (items)
        unset($paginator["data"]);

        // store the rest of the pagination in a public array
        $this->paginator = $paginatorArr;
        # dd($paginator);
    }

    //
    //
    //
    protected function getQuery(): Builder
    {
        if (method_exists($this, 'query')) {
            // get query from child Crud-Class
            return $this->query();
        }

        return $this->modelPath::query();
    }

    //
    //
    //
    protected function searching($query): Builder
    {

        if ($this->search == "") {
            return $query;
        }

        $search = $this->search;

        $query->where(function ($query) use ($search) {
            foreach ($this->searchProps as $i => $prop) {
                $query->orWhere($prop, 'like', '%' . $search . '%');
            }
        });

        return $query;
    }

    //
    //
    //
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

    //
    // index page handling
    //
    public function openIndex()
    {
        $this->addBeforeHook(__FUNCTION__);

        // change view
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }

    //
    // create form handling
    //
    public function openCreateForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        // change view
        $this->currentPage = "create";

        $this->addAfterHook(__FUNCTION__);
    }

}
