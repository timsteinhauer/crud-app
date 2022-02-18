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
    //  todo Crud Main Features
    //  - action buttons
    //  - restore stuff
    //  - clone stuff
    //  - soft delete stuff
    //
    //  - table column sorting && card data sorting
    //  - header filter stuff
    //
    //
    //  todo SubQuery Sorting
    //
    //  todo Multi-Select Fields
    //
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
    public bool $useInstantDeleting = false;

    //
    // handling current user abilities
    //
    public array $allowed = [
        "create" => true,
        "open" => true,
        "edit" => true,
        "delete" => true,
        "restore" => true,
        # "clone" => true, // todo clone einbauen
        // features
        "show_search" => true,
        "show_filter" => true,
    ];

    // default page
    public string $currentPage = "index";

    // default index layout style
    public string $indexLayout = "table"; // "table" or "cards"

    // allow layout change
    public bool $allowLayoutChange = false;

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
        "delete" => [
            "headline" => "wirklich löschen",
            "message" => "Der Datensatz <b>:name</b> wird gelöscht!",
            "submit_btn" => "Ja, jetzt löschen",
        ],
        "soft_delete" => [
            "headline" => "archivieren",
            "message" => "Der Datensatz <b>:name</b> wird archiviert.",
            "submit_btn" => "Archivieren",
        ],
        "restore" => [
            "headline" => "wiederherstellen",
            "message" => "Der Datensatz <b>:name</b> wird wiederhergestellt.",
            "submit_btn" => "Wiederherstellen",
        ],
    ];

    //
    // styling stuff, witch could be different for other models
    //
    public array $styling = [
        "create" => [
            "submit_btn" => "btn-primary",
        ],
        "edit" => [
            "submit_btn" => "btn-primary",
        ],
        "delete" => [
            "message" => "bg-danger",
            "submit_btn" => "btn-danger",
        ],
        "soft_delete" => [
            "message" => "bg-warning",
            "submit_btn" => "btn-warning"
        ],
        "restore" => [
            "submit_btn" => "btn-success"
        ],
        // page index, table layout
        "action_column_class" => "text-right",
        "action_column_style" => "min-width: 120px",
        // page index, card layout
        "card_action_class" => "card-footer text-center",
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
    // overrideable methods
    //

    public function create($form): void
    {
        // create new entity through eloquent
        $this->modelPath::create($form);
    }

    public function delete($item): void
    {
        // create new entity through eloquent
        $this->modelPath::find($item["id"])->delete();
    }

    public function finalDelete($item): void
    {
        // create new entity through eloquent
        $this->modelPath::withTrashed()->find($item["id"])->finalDelete();
    }

    public function restore($item): void
    {
        // create new entity through eloquent
        $this->modelPath::withTrashed()->find($item["id"])->restore();
    }

    public function clone($item): void
    {
        // todo clone
    }

    //
    // End of override stuff                        <!---------------------------------
    //

    #############################################################################################################

    //
    //  do not change something below this line !!!
    //
    //

    //
    // actions for the different pages
    //
    public array $formActions = [
        "create" => [
            "submit_btn" => "submitCreateForm",
        ],
        "edit" => [
            "submit_btn" => "submitEditForm",
        ],
        "delete" => [
            "submit_btn" => "submitDeleteForm",
        ],
        "soft_delete" => [
            "submit_btn" => "submitSoftDeleteForm"
        ],
        "restore" => [
            "submit_btn" => "submitRestoreForm"
        ],
    ];

    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    // array for all validation rules for every page scope / type
    public array $crudRules = [];

    // same array for custom attribute names
    public array $crudAttributes = [];

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

    // store all default values for the form fields
    public array $formDefaults = [];

    // the pagination stuff
    public array $paginator = [];




    //
    //
    // Helper Stuff
    //
    //

    protected array $defaultFilterArray = [
        ["id" => "-", "name" => "-"]
    ];


    //
    // Helper Methods
    //

    public static function withEmptySelect($withEmptyRow, $array): array
    {

        if ($withEmptyRow) {
            return array_merge([["id" => null, "name" => "-"]], $array);
        }
        return $array;
    }

    //
    // :string to item variables
    //
    public function parseAttr($string){

        // the interface defined this method, it must be there
        if (!method_exists($this, "getItemIdentifier")) {
            die('Method <b>getItemIdentifier</b> fehlt in der Child-Klass: <b>' . __CLASS__ . '</b>!');
        }

        return str_replace( ":name", $this->getItemIdentifier($this->form), $string);
    }

    //
    // date helpers
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
    // form field handling
    //
    protected function addFormField($key, $type, $title, array|string $rules = [], $config = [])
    {
        $this->fields["both"]["form." . $key] = [
            "key" => "form." . $key,
            "type" => $type,
            "title" => $title,
            "rules" => $rules,
            "config" => $config,
        ];
    }

    protected function addCreateFormField($key, $type, $title, array|string $rules = [], $config = [])
    {
        $this->fields["create"]["form." . $key] = [
            "key" => "form." . $key,
            "type" => $type,
            "title" => $title,
            "rules" => $rules,
            "config" => $config,
        ];
    }

    protected function addEditFormField($key, $type, $title, array|string $rules = [], $config = [])
    {
        $this->fields["edit"]["form." . $key] = [
            "key" => "form." . $key,
            "type" => $type,
            "title" => $title,
            "rules" => $rules,
            "config" => $config,
        ];
    }

    public function getFormField($key, $scope = "both"): array
    {
        # dd($this->fields);
        if (!isset($this->fields[$scope]["form." . $key])) {
            dd("Es wurde kein FormField mit dem key: <b>" . $key . "</b> in " . __CLASS__ . " definiert!");
        }

        return $this->fields[$scope]["form." . $key];
    }

    //
    // blade
    //


    //
    //
    //      main methods
    //
    //


    //
    //
    //

    //
    //      validate only the hole rules Array for current page, if we have some rules.
    //
    protected function validateCrud()
    {
        # dd($this->crudRules);
        $rules = $this->crudRules[$this->currentPage];
       $attributes = $this->crudAttributes[$this->currentPage];
        # dd($rules);
        if (!empty($rules)) {
            $this->validate($rules, [], $attributes);
        }
    }

    //
    //
    //
    public function mount()
    {
        // we don't allow that array!
        if (isset($this->rules)) {
            die('Es darf <b>kein $rules Array</b> in der Child-Klass: <b>' . __CLASS__ . '</b> gesetzt werden!');
        }

        // the interface defined this method, it must be there
        if (!method_exists($this, "initFormFields")) {
            die('Method <b>initFormFields</b> fehlt in der Child-Klass: <b>' . __CLASS__ . '</b>!');
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
        $this->initFormFields();

        // build rules
        $this->initRules();

        // set form default selections
        $this->fillFormDefaults();


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
        // crud default reloads by updating perPage
        if ($propName == "perPage") {
            $this->loadItems();
        }

        // crud default reloads by updating search and go to first page
        if ($propName == "search") {
            $this->gotoPage(1);
            $this->loadItems();
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

        // add live validation on updated
        if ($this->currentPage == "create" || $this->currentPage == "edit") {
            $rules = $this->crudRules[$this->currentPage];
            $attributes = $this->crudAttributes[$this->currentPage];
            if (!empty($rules) && isset($rules[$propName])) {
                $this->validateOnly($propName, $rules, [], $attributes);
            }
        }
    }


    public function render()
    {
        return view('livewire.extends.crud-main.index');
    }


    //
    //
    //      mounting stuff
    //
    //

    //
    //      rules & validation attributes stuff
    //
    protected function initRules()
    {

        $rules = [
            "create" => [],
            "edit" => [],
        ];

        $attributes = [
            "create" => [],
            "edit" => [],
        ];

        foreach ($this->fields as $scope => $fields) {
            foreach ($fields as $key => $field) {

                // the field has no defined rules
                if (empty($field["rules"])) {
                    continue;
                }

                if ($scope == "both") {
                    $rules["create"][$key] = $field["rules"];
                    $rules["edit"][$key] = $field["rules"];

                    $attributes["create"][$key] = $field["title"];
                    $attributes["edit"][$key] = $field["title"];
                } else {
                    $rules[$scope][$key] = $field["rules"];

                    $attributes[$scope][$key] = $field["title"];
                }
            }
        }

        $this->crudRules = $rules;
        $this->crudAttributes = $attributes;
    }

    //
    // prepare form stuff
    //
    protected function fillFormDefaults()
    {
        $defaults = [
            "create" => [],
            "edit" => [],
        ];

        foreach ($this->fields as $scope => $fields) {
            foreach ($fields as $key => $field) {

                // the field has no defined default value
                if (!isset($field["config"]["value"])) {
                    continue;
                }

                // build array form key
                $keys = explode(".", str_replace("form.", "", $key));

                //
                // todo mehrdimensionales Array abbilden
                // todo mehrdimensionales Array abbilden
                // todo mehrdimensionales Array abbilden
                // todo mehrdimensionales Array abbilden
                //

                if ($scope == "both") {
                    $defaults["create"][$keys[0]] = $field["config"]["value"];
                    $defaults["edit"][$keys[0]] = $field["config"]["value"];
                } else {
                    $defaults[$scope][$keys[0]] = $field["config"]["value"];
                }
            }
        }

        $this->formDefaults = $defaults;

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
    public function getModelFromIndex($index)
    {
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
        $this->form = $this->formDefaults["create"];

        // change view
        $this->currentPage = "create";

        $this->addAfterHook(__FUNCTION__);
    }


    public function submitCreateForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        $this->validateCrud();

        // the interface defined this method, it must be there
        if (!method_exists($this, "create")) {
            die('Method <b>create()</b> fehlt in der Child-Klass: <b>' . __CLASS__ . '</b>!');
        }

        $this->create($this->form);

        $this->refresh();
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

        // load default data for the edit form and
        // load current edit data and merge them
        $this->form = array_merge($this->formDefaults["edit"], $item);

        // change view
        $this->currentPage = "edit";

        $this->addAfterHook(__FUNCTION__, $item);
    }

    public function submitEditForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        $this->validateCrud();

        // todo submitEditForm


        $this->refresh();
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }


    //
    // delete form handling
    //
    public function openDeleteForm($index){
        $item = $this->getModelFromIndex($index);
        $this->addBeforeHook(__FUNCTION__, $item);

        // load current edit data and merge them
        $this->form = $item;

        // change view
        $this->currentPage = "delete";

        $this->addAfterHook(__FUNCTION__, $item);
    }

    public function submitDeleteForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        // call delete method
        $this->delete($this->form);

        $this->refresh();
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }

    public function submitInstantDeleteForm($index)
    {
        $item = $this->getModelFromIndex($index);
        $this->addBeforeHook(__FUNCTION__, $item);

        // call delete method
        $this->delete($item);

        $this->refresh();
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__, $item);
    }



    //
    // final delete and restore stuff
    //
    public function submitFinalDeleteForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        // todo submitFinalDeleteForm


        $this->refresh();
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }


}
