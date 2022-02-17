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

    // naming
    public string $singular = "";
    public string $plural = "";

    // do not declare a $rules array ! <----------------
    // work with the ${Page-Name}FormRules Arrays!


    //
    //
    //
    //
    //
    //      other optional(!) override stuff             <!---------------------------------
    //

    //
    // the rules for specific pages
    //
    public array $createFormRules = [];
    public array $editFormRules = [];
    public array $deleteFormRules = [];
    public array $restoreFormRules = [];

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
        "no_items" => "Keine Ergebnisse vorhanden",
        // header
        "new" => '<i class="bi bi-plus-lg"></i>',
        "search" => "Suchen...",

        // global buttons
        "back_btn" => "Zurück",

        // pages specific buttons
        "index" => [
            "edit_btn" => "Bearbeiten",
            "delete_btn" => "Löschen",
        ],
        "create" => [
            "headline" => "erstellen",
            "submit_btn" => "Erstellen",
        ],
        "edit" => [
            "headline" => "aktualisieren",
            "submit_btn" => "Aktualisieren",
        ],
    ];

    //
    // styling stuff, witch could be different for other models
    //
    public array $styling = [
        "action_column_class" => "text-right",
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

    // the array for livewire form bindings
    public array $form = [];

    // store all configs for the form fields
    public array $fields = [];

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

    protected function addFormField($key, $type, $title, $options = [])
    {
        $this->fields["both"]["form.".$key] = [
            "key" => "form.".$key,
            "type" => $type,
            "title" => $title,
            "options" => $options,
        ];
    }

    protected function addCreateFormField($key, $type, $title, $options = [])
    {
        $this->fields["create"]["form.".$key] = [
            "key" => "form.".$key,
            "type" => $type,
            "title" => $title,
            "options" => $options,
        ];
    }

    protected function addEditFormField($key, $type, $title, $options = [])
    {
        $this->fields["edit"]["form.".$key] = [
            "key" => "form.".$key,
            "type" => $type,
            "title" => $title,
            "options" => $options,
        ];
    }

    public function getFormField($key, $scope = "both"): array
    {
        if( !isset($this->fields[$scope]["form.".$key])){
            dd("Es wird kein FormField mit dem key: ". $key ." in ". __CLASS__ . " definiert");
        }

        return $this->fields[$scope]["form.".$key];
    }


    //
    //
    //      main methods
    //
    //
    public function rules(): array
    {
        if( $this->currentPage != "index"){
            $rules = $this->currentPage."FormRules";
            return $this->{$rules};
        }

        return [];
    }

    //
    // validate only the hole rules Array for current page, if we have some rules.
    //
    protected function validateCrud(){
        if( $this->rules() != [] ){
            $this->validate();
        }
    }

    public function mount()
    {
        if( isset($this->rules) ){
            die('Es darf <b>kein $rules Array</b> in der Child-Klass: <b>'. __CLASS__ .'</b> gesetzt werden!');
        }

        // set child classes path
        $this->childPath .= $this->model . '-crud.override';

        // set wordings
        $this->wordings["name"] = $this->singular;
        $this->wordings["names"] = $this->plural;

        //
        // mounting everything up
        //

        // set form fields
        if( !method_exists($this, "initFormFields")){
            die('Method <b>initFormFields</b> fehlt in der Child-Klass: <b>'. __CLASS__ .'</b>!');
        }

        $this->initFormFields();

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
    protected function addBeforeHook($functionName, $passThrough = null): void
    {
        $this->addHook("before", $functionName, $passThrough);
    }
    protected function addAfterHook($functionName, $passThrough = null): void
    {
        $this->addHook("after", $functionName, $passThrough);
    }

    protected function addHook($hookName, $functionName = "", $passThrough = null): void
    {
        $hookName .= ucfirst($functionName);

        // if hook exists in child class
        if (method_exists($this, $hookName)) {
            // call the hook
            $this->{$hookName}($passThrough);
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
    // get the current model data for the given Index from the paginator array
    // notice: We can't use the items array, because it is mapped by the child class mapping()-Method
    //
    public function getModelFromIndex($index){
        return $this->paginator["data"][$index];
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

        // load default data for the create form
        if( method_exists($this, "defaultCreateFormData")){
            $this->form = $this->defaultCreateFormData();
        }

        // change view
        $this->currentPage = "create";

        $this->addAfterHook(__FUNCTION__);
    }


    public function submitCreateForm(){

        $this->validateCrud();

        $this->addBeforeHook(__FUNCTION__);

        // change view
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }


    //
    // edit form handling
    //
    public function openEditForm($index)
    {
        $item = $this->getModelFromIndex($index);
        $this->addBeforeHook(__FUNCTION__, $item);

        // load current edit data in the form
        $this->form = $item;

        // change view
        $this->currentPage = "edit";

        $this->addAfterHook(__FUNCTION__, $item);
    }


    public function submitEditForm(){

        $this->validateCrud();

        $this->addBeforeHook(__FUNCTION__);

        // change view
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }

}
