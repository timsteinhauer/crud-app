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
    //  todo WEITERMACHEN
    //  - layout und system trennen nach Kunden und Admins
    //  - CustomerUserCrud fertigstellen
    //  - redirect weiche beim login  -> https://codesource.io/how-to-conditionally-redirect-users-after-login-on-laravel-jetstream/
    //  - auth()->user()->load() beim login
    //  - redis sessions
    //
    //
    //  todo Crud Main Features
    //  - restore stuff
    //  - soft delete stuff
    //
    //  todo add all other relationships
    //  - hasMany -> CHECKED
    //  - belongsTo -> CHECKED
    //  - belongsToMany
    //  - hasOne
    //
    //  todo all field types
    //  - checkbox / radio
    //  - date / datetime
    //  - range
    //  - textarea
    //
    //  todo SubQuery Sorting
    //
    //  todo Select Fields with search
    //  - for the Filters -> CHECKED
    //  - for the select fields
    //  - for the multi-select fields
    //  - for the badges UI field
    //  - for the multi-badges UI field
    //
    //
    //  todo File Upload Trait
    //
    //
    //  todo Responsive...
    //
    //
    //  todo move Curd to composer package
    //
    //
    //  todo wording array konsequent nutzen
    //
    //
    //  todo styling array konsequent nutzen


    //
    // Further Ideas:
    //
    //  1. Cloning Items
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

    // default relationships to load
    public array $with = [];


    //
    // allow of soft deleting and restoring
    // remember to activate $table->softDeletes(); in the migration of your model!
    //
    public bool $useSoftDeleting = false;

    // if true, there is "Do you really want to delete the Item?"-Question
    public bool $useInstantDeleting = false;

    // route to detail page
    public string $detailRoute = "";


    //
    // handling abilities
    // on Child Classes, override these array to handel custom user roles and abilities
    //
    public array $allowed = [
        "create" => true,
        "details" => true,
        "edit" => true,
        "delete" => true,
        "final_delete" => true,
        "restore" => true,
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
            "details_btn" => "Öffnen",
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
            "submit_btn" => "btn-primary"
        ],
        // page index, table layout
        "action_column_class" => "text-right",
        "action_column_style" => "min-width: 120px",
        // page index, card layout
        "card_action_class" => "card-footer text-center",
        // colors
        "filter_active_color" => "text-danger",
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
        $newModel = $this->modelPath::create($form);

        // store all existing relationship fields
        $this->storeRelationships($newModel);
    }

    public function update($form): void
    {
        // update entity through eloquent
        $model = $this->modelPath::find($form["id"]);
        $model->update($form);

        // update all existing relationship fields
        $this->storeRelationships($model);
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


    public function cardLayout(): array
    {
        // the interface defined this method, it must be there
        if (!method_exists($this, "tableColumns")) {
            die('Method <b>tableColumns</b> fehlt in der Child-Klass: <b>' . __CLASS__ . '</b>!');
        }
        return $this->tableColumns();
    }

    //
    // End of override stuff                        <!---------------------------------
    //

    #############################################################################################################

    //
    //
    //  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //  do not change something below this line !!!
    //  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //
    //


    //
    //
    //
    // Variable Section                             <---------------------------------
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

    // change styling from tailwind to boostrap
    protected string $paginationTheme = 'bootstrap';

    // array for all validation rules for every page scope / type
    public array $crudRules = [];

    // same array for custom attribute names
    public array $crudAttributes = [];

    // path to livewire views
    public string $path = "livewire.extends.crud-main";

    // path to the folder with all child classes views
    public string $childPath = "cruds."; // see mount()!

    // the config to create the filter view in index header
    public array $filterConfigs = [];

    // the callbacks for filers, these are not public!
    protected array $filterCallbacks = [];

    // the current opened inline filter
    public string $openedFilterModal = "";

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

    // currently, opened searchable filter
    public string $openedSearchableField = "";

    // stores the search string for the opened searchable field
    public string $searchableFieldQuery = "";

    // Template for the empty option entries for Select-Form Fields
    protected array $defaultFilterArray = [
        ["id" => "-", "name" => "-"]
    ];

    // End of:  Variable Section
    //
    //


    //
    //
    //
    // Helper Methods Section                               <---------------------------------
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


    // System-wide global helper Function to prepend an empty entry to a config array for select-form fields
    public static function withEmptySelect($array): array
    {
        return array_merge([["id" => null, "name" => "-"]], $array);
    }

    //
    // replace :name with the given models name variables
    //
    public function insertName(string $string)
    {

        if ( method_exists($this, "getItemIdentifier") ) {
            return str_replace(":name", $this->getItemName($this->form), $string);
        }

        if( isset($this->form["name"])){
            return $this->form["name"];
        }

        die('<b>Kein Name gefunden für Child-Klass: ' . __CLASS__ . '</b>! (<u>Attribut Name</u> oder Method <u>getItemIdentifier</u>)');
    }

    // carbon parse shorthand for date
    public function helpDateFormat($str, $format = "d.m.Y", $default = "-"): string
    {
        if ($str == "" || $str == null) {
            return $default;
        }

        return Carbon::parse($str)->format($format);
    }

    // carbon parse shorthand for datetime
    public function helpDatetimeFormat($str, $format = "d.m.Y H:i", $default = "-"): string
    {
        if ($str == "" || $str == null) {
            return $default;
        }

        return Carbon::parse($str)->format($format);
    }


    //
    // get the current model data for the given Index from the paginator array
    // notice: We can't use the items array, because it is mapped by the child class mapping()-Method
    //
    public function getModelFromIndex($index)
    {
        return $this->paginator["data"][$index];
    }

    // gets only the id
    public function getIdFromIndex($index)
    {
        return $this->paginator["data"][$index]["id"];
    }






    // End of:  Helper Section
    //
    //


    //
    //
    //
    // Form Fields Section                               <---------------------------------
    //


    // Form helper Function to unset an index in the given array in key.dot notation
    public function unsetArrayAt($string): void
    {
        $vars = explode('.', $string);
        $arraySelector = $vars[0];
        $index = $vars[count($vars) - 1];
        unset($vars[count($vars) - 1]);
        unset($vars[0]);

        switch (count($vars)) {

            case 1:
                unset($this->{$arraySelector}[$vars[1]][$index]);
                break;
            case 2:
                unset($this->{$arraySelector}[$vars[1]][$vars[2]][$index]);
                break;
            case 3:
                unset($this->{$arraySelector}[$vars[1]][$vars[2]][$vars[3]][$index]);
                break;
            case 4:
            case 5:
            case 6:
            case 7:
                dd("Only support Sub-Arrays with 4 level of deep in helper method <b>unsetArrayAt</b>");
        }
    }


    //
    // add form field handling
    //

    /**
     * Add a form field for both, create and edit form
     * - config can contain a subarrays for "edit" => [...] or "create" pages
     * - or values on top level for all pages
     *
     * @param $key
     * @param $type
     * @param $title
     * @param array|string $rules or ["edit" => [] || "", "create" => "" || []]
     * @param $config
     * @return void
     */
    protected function addFormField($key, $type, $title, array|string $rules = [], $config = []): void
    {
        $config = $this->prepareRelationshipConfig($config);

        $this->fields[$key] = [
            "key" => $key,
            "type" => $type,
            "title" => $title,
            "rules" => $rules,
            "config" => $config,
        ];
    }


    // Helper Fnc for blade files to get the config for a form field
    public function getFormField($key): array
    {

        if (!isset($this->fields[$key])) {
            dd("Es wurde kein FormField mit dem key: <b>" . $key . "</b> in " . __CLASS__ . " definiert!");
        }

        $field = $this->fields[$key];

        $field["keyPath"] = "form." . $field["key"];

        // if the field has page specific configs, load it
        // example: "edit_form" or "create_form"
        if (key_exists($this->currentPage, $field["config"])) {
            $field["config"] = array_merge($field["config"], $field["config"][$this->currentPage]);
        }


        return $field;
    }

    // End of:  Form Fields Section
    //
    //


    //
    //
    //
    // Relationship Section                               <---------------------------------
    //

    // load default model data for the relationship field config, if no options array provided
    protected function prepareRelationshipConfig($config): array
    {
        if (!isset($config["relation"])) {
            return $config;
        }

        if (!isset($config["relation_model"])) {
            dd('$config["relation_model"] ist nicht gesetzt in ' . __CLASS__);
        }

        // load default options
        if (!isset($config["options"])) {
            $config["options"] = $config["relation_model"]::select(["id", "name"])->get()->toArray();
        }

        return $config;
    }


    //
    // this is the default store method for all types of relationship fields.
    // If you don't want to use it, you need to handel the relationship fields at your own
    // in the child class store()-method
    //
    protected function storeRelationships($newModel)
    {

        foreach ($this->fields as $field) {


            // handle only relationship fields
            if (isset($field["config"]["relation"])) {

                // if $this->form contains data for the given relationship matching by key?
                // skip the current field
                if (!isset($this->form[$field["key"]])) {
                    continue;
                }

                $relationshipKey = $field["key"];
                $relationshipFormData = $this->form[$relationshipKey];

                switch ($field["config"]["relation"]) {

                    case "hasMany":

                        if (!is_array($relationshipFormData)) {
                            dd("The Form Array must contains an Array at the Key: <b>" . $relationshipKey . "</b> for the Relationship " . $field["title"]);
                        }
                        $syncArray = [];

                        foreach ($relationshipFormData as $relationshipId => $value) {
                            if ($value == "1") {
                                $syncArray[] = $relationshipId;
                            }
                        }

                        // performe db query and store / remove / sync data
                        $newModel->{$relationshipKey}()->sync($syncArray);

                        break;

                    case "hasOne":
                        // todo hasOne implementieren
                        break;

                    case "belongsTo":
                        // todo belongsTo implementieren
                        break;
                }

            }


        }
    }

    // load the relationship config on edit pages and convert it into a usefully structure
    protected function prepareRelationshipConfigForEdit(): void
    {

        foreach ($this->fields as $field) {

            if (!isset($field["config"]["relation"])) {
                continue;
            }

            if ($field["config"]["relation"] != "hasMany") {
                continue;
            }

            // prepare data for the key of the relationship field
            $relationKey = $field["key"];
            $newData = [];

            foreach ($this->form[$relationKey] as $item) {
                // set the value for existing ids to 1
                $newData[$item["id"]] = 1;
            }

            // override the array in the form array
            $this->form[$relationKey] = $newData;
        }

    }


    /**
     * Shorthand to build a UI for a HasMany Relation
     *
     * @param object $item
     * @param string $key
     * @param array $options = [?"layout"=>"badges|", ?"color"=>"primary"]
     * @param array $badges = [["name" => "Abc",?"class" => "", ?"style" => ""], [...]]
     * @return string
     */
    public function helpRelationHasManyFormat(object $item, string $key, array $options = [], array $items = []): string
    {
        $default = [
            "layout" => "badges",
            "color" => "primary",
        ];

        $default = array_merge($default, $options);

        if (empty($items)) {
            try {
                $items = $item->{$key}->toArray();
            } catch (\Exception $exception) {
                // ignore
            }
        }

        return view("templates.components." . $default["layout"], ["items" => $items, 'color' => $default["color"]]);
    }

    // End of:  Relationship Section
    //
    //


    //
    //
    //
    // Filter Section                               <---------------------------------
    //

    /**
     * Register a default Field-Filter UI
     *
     * @param $key
     * @param $type = ["select", "multi-select"]
     * @param $title
     * @param $options = the options for the select-tag
     * @param string $default = default value for the filter
     * @param string $position = ["header", "{key}"]
     * @param bool $searchable
     * @param callable|null $callback
     * @return void
     */
    protected function addFilter($key, $type, $title, $options, string $default = "", string $position = "header", bool $searchable = false, callable $callback = null): void
    {
        $this->filterConfigs[$key] = [
            "type" => $type,
            "title" => $title,
            "options" => $options,
            "default" => $default,
            "position" => $position,
            "searchable" => $searchable,
        ];

        // the callbacks are protected, so they won't be synced by livewire
        if ($callback !== null) {
            $this->filterCallbacks[$key] = $callback;
        }
    }

    /**
     * Register a Relationship-Filter UI
     *
     * @param $key
     * @param $type = ["select", "multi-select"]
     * @param $title
     * @param $options = the options for the select-tag
     * @param string $default = default value for the filter
     * @param string $position = ["header", "{key}"]
     * @param bool $searchable
     * @param callable|null $callback
     * @return void
     */
    protected function addRelationFilter($key, $type, $title, $options, string $default = "", string $position = "header", bool $searchable = false, callable $callback = null): void
    {
        $this->filterConfigs[$key] = [
            "relation" => $key,
            "type" => $type,
            "title" => $title,
            "options" => $options,
            "default" => $default,
            "position" => $position,
            "searchable" => $searchable,
        ];

        // the callbacks are protected, so they won't be synced by livewire
        if ($callback !== null) {
            $this->filterCallbacks[$key] = $callback;
        }
    }

    // is a filter registered for the given position
    public function hasFilter($positionKey): bool
    {
        foreach ($this->filterConfigs as $filterConfig) {
            if ($filterConfig["position"] === $positionKey) {
                return true;
            }
        }
        return false;
    }

    // has the given position key a currently active filter
    public function isFilterActive($positionKey): bool
    {

        foreach ($this->filterConfigs as $filterKey => $filterConfig) {
            if ($filterConfig["position"] === $positionKey) {
                return $this->filter[$filterKey] !== $filterConfig["default"];
            }
        }
        return false;
    }

    // give the filter config for the given position
    public function getFilterConfigAtPosition($positionKey): array
    {

        foreach ($this->filterConfigs as $filterKey => $filterConfig) {
            if ($filterConfig["position"] === $positionKey) {
                return [
                    "filterConfig" => $filterConfig,
                    "filterKey" => $filterKey,
                ];
            }
        }

        // if no config was found, there must be a serious error, because this function can only be
        // called, when a config array should be exists...
        dd("Fehler. Die Filter-Position " . $positionKey . " müsste vorhanden sein!");
    }

    public function openSearchableField($key): void
    {
        $this->searchableFieldQuery = "";
        $this->openedSearchableField = $key;
    }

    public function closeSearchableField(): void
    {
        $this->openedSearchableField = "";
    }

    // custom select field UI, this method handel the click to the "<option>" Fake tag
    public function setSearchableFieldValue($key, $value): void
    {

        $key = explode(".", $key);

        if (isset($key[1])) {

            $this->{$key[0]}[$key[1]] = $value;
        } else {
            $this->{$key[0]} = $value;
        }

        $this->openedSearchableField = "";

        $this->refresh();
    }

    // select2 fake UI, this method filter the provided <option>-Tags
    public function matchedFilterQuery($currentItem): bool
    {

        if ($this->searchableFieldQuery == "") {
            return true;
        }

        if (str_contains(strtolower($currentItem), strtolower($this->searchableFieldQuery))) {
            return true;
        }

        return false;
    }

    // End of:  Filter Section
    //
    //


    //
    //
    //
    //          Main Section                               <---------------------------------
    //

    //
    //
    //


    // validate only the rules Array for current page, if we have some rules.
    protected function validateCrud()
    {

        $rules = $this->crudRules[$this->currentPage];
        $attributes = $this->crudAttributes;

        if (!empty($rules)) {
            $this->validate($rules, [], $attributes);
        }
    }

    //
    //  get the party started...
    //
    public function mount()
    {
        // we don't allow that array in the child classes!
        if (isset($this->rules)) {
            die('Es darf <b>kein $rules Array</b> in der Child-Klass: <b>' . __CLASS__ . '</b> gesetzt werden!');
        }

        // the interface defined this method, it must be there
        if (!method_exists($this, "mountCrud")) {
            die('Method <b>mountCrud</b> fehlt in der Child-Klass: <b>' . __CLASS__ . '</b>!');
        }

        // set child classes path
        $this->childPath .= $this->model . '-crud.override';

        // set wordings
        $this->wordings["name"] = $this->singular;
        $this->wordings["names"] = $this->plural;


        // add form fields, add filter, add etc. by Child Class
        $this->mountCrud();

        // build custom rules for the crud system
        $this->mountRules();

        // set form default selections
        $this->fillFormDefaults();

        // set filter defaults
        $this->fillFilterDefaults();

        // first load of refreshable stuff
        $this->refresh();
    }

    //
    // call every stuff, witch must be refreshable at many others events like:
    // change current page
    // add new items
    // delete items
    // etc...
    //
    public function refresh()
    {
        $this->loadItems();
    }


    // livewire default updated method
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

        // crud default reloads by change filter values
        if (str_contains($propName, "filter.")) {

            // close modals
            $this->openedFilterModal = "";
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
            $attributes = $this->crudAttributes;
            if (!empty($rules) && isset($rules[$propName])) {
                $this->validateOnly($propName, $rules, [], $attributes);
            }
        }
    }

    // I don't know what this will do ...
    public function render()
    {
        return view('livewire.extends.crud-main.index');
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

        if (!empty($this->with)) {
            return $this->modelPath::query()->with($this->with);
        }

        return $this->modelPath::query();
    }

    //
    //  apply searching query's
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
    //  apply filter query's
    //
    protected function filtering($query): Builder
    {

        foreach ($this->filter as $filterKey => $selectedValue) {

            //
            // if we have a filter callback, use it to override all default behavior
            //
            if (isset($this->filterCallbacks[$filterKey])) {
                //
                // use custom filter callback to handle the filter query logic
                //
                $query = $this->filterCallbacks[$filterKey]($query, $selectedValue);

                // stop current loop iteration
                continue;
            }


            if ($selectedValue == "") {
                // stop current loop iteration
                continue;
            }


            // some values are selected, so we should filtert the query

            //
            // use default filter logic, when the value is set
            //
            if (isset($this->filterConfigs[$filterKey]["relation"])) {

                $relationType = $this->fields[$filterKey]["config"]["relation"];

                # if( $filterKey == "salutation_id")
                # dd($this->filterConfigs[$filterKey], $this->fields[$filterKey], $relationType);


                //
                // handle different relation types
                //
                switch ($relationType) {
                    case "belongsTo":

                        if (is_array($selectedValue)) {
                            // we have multiple select values => loop filter
                            $query->where($filterKey, (int)$selectedValue[array_key_first($selectedValue)]);
                            unset($selectedValue[array_key_first($selectedValue)]);

                            foreach ($selectedValue as $selectedValueLoop) {
                                $query->orWhere($filterKey, (int)$selectedValueLoop);
                            }
                        } else {
                            $query->where($filterKey, $selectedValue);
                        }
                        break;

                    case "hasMany":
                        if (is_array($selectedValue)) {
                            // we have multiple select values => loop filter
                            $query->whereHas($filterKey, function ($query) use ($selectedValue) {

                                $query->where('id', (int)$selectedValue[array_key_first($selectedValue)]);
                                unset($selectedValue[array_key_first($selectedValue)]);

                                foreach ($selectedValue as $selectedValueLoop) {
                                    $query->orWhere('id', (int)$selectedValueLoop);
                                }
                            });

                        } else {
                            // single select field
                            $query->whereHas($filterKey, function ($query) use ($selectedValue) {
                                $query->where('id', (int)$selectedValue);
                            });
                        }
                        break;
                } // switch

            } else {
                // classic default filter

                if ($selectedValue === 'not-null') {
                    $query->whereNotNull($filterKey);
                } elseif ($selectedValue === 'null') {
                    $query->whereNull($filterKey);
                } else {
                    $query->where($filterKey, $selectedValue);
                }
            }
        }


        return $query;
    }

    //
    // change sort by value and direction
    //
    public function sortBy($field)
    {
        $this->sortAsc = !($this->sortField === $field) || !$this->sortAsc;
        $this->sortField = $field;

        $this->loadItems();
    }


    // End of:  Main Section
    //
    //
    //
    //
    //


    //
    //
    //
    // Mounting Section                               <---------------------------------
    //


    //
    // rules & validation attributes stuff
    //
    protected function mountRules()
    {

        $rules = [
            "create" => [],
            "edit" => [],
        ];

        $attributes = [];

        foreach ($this->fields as $key => $field) {


            // the field has no defined rules
            if (empty($field["rules"])) {
                continue;
            }


            if (isset($field["rules"]["create"])) {
                $rules["create"]["form." . $key] = $field["rules"]["create"];
            }

            if (isset($field["rules"]["edit"])) {
                $rules["edit"]["form." . $key] = $field["rules"]["edit"];
            }

            // both fields
            if (!isset($field["rules"]["create"]) && !isset($field["rules"]["edit"])) {
                $rules["create"]["form." . $key] = $field["rules"];
                $rules["edit"]["form." . $key] = $field["rules"];
            }

            $attributes["form." . $key] = $field["title"];

        }

        $this->crudRules = $rules;
        $this->crudAttributes = $attributes;
    }

    //
    // prepare form stuff with default values
    //
    protected function fillFormDefaults(): void
    {
        $defaults = [
            "create" => [],
            "edit" => [],
        ];

        foreach ($this->fields as $key => $field) {

            // the field has no defined default value
            if (!isset($field["config"]["value"])) {
                continue;
            }

            // build array form key
            $keys = explode(".", str_replace("form.", "", $key));

            //
            // todo mehrdimensionales Array abbilden
            //

            $defaults[$keys[0]] = $field["config"]["value"];
        }

        $this->formDefaults = $defaults;

    }

    //
    // prepare Filter Stuff with default values
    //
    protected function fillFilterDefaults(): void
    {

        foreach ($this->filterConfigs as $filterKey => $filterConfig) {
            $this->filter[$filterKey] = $filterConfig["default"];
        }
    }

    // End of:  Mounting Section
    //
    //


    //
    // fix pagination trait, to only refresh when it is necessary
    //

    public
    function previousPageFix($pageName = 'page')
    {
        $this->previousPage($pageName);
        $this->loadItems();
    }

    public
    function nextPageFix($pageName = 'page')
    {
        $this->nextPage($pageName);
        $this->loadItems();
    }

    public
    function gotoPageFix($page, $pageName = 'page')
    {
        $this->gotoPage($page, $pageName);
        $this->loadItems();
    }


    //
    //
    //
    // Page handling Section                               <---------------------------------
    //


    //
    // index page handling
    //
    public
    function openIndex()
    {

        $this->addBeforeHook(__FUNCTION__);

        // everytime we open the index view, reset all error messages
        $this->resetErrorBag();

        // change view
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }


    //
    // create form handling
    //
    public
    function openCreateForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        // load default data for the create form
        $this->form = $this->formDefaults;

        // change view
        $this->currentPage = "create";

        $this->addAfterHook(__FUNCTION__);
    }


    public
    function submitCreateForm()
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
    public
    function openEditForm($index): void
    {
        $item = $this->getModelFromIndex($index);
        $this->addBeforeHook(__FUNCTION__, $item);

        // load default data for the edit form and
        // load current edit data and merge them
        $this->form = array_merge($this->formDefaults, $item);

        // convert the relationship data into a usefully structure
        $this->prepareRelationshipConfigForEdit();

        // change view
        $this->currentPage = "edit";

        $this->addAfterHook(__FUNCTION__, $item);
    }

    public
    function submitEditForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        $this->validateCrud();

        $this->update($this->form);

        $this->refresh();
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }


    //
    // delete form handling
    //
    public
    function openDeleteForm($index)
    {
        $item = $this->getModelFromIndex($index);
        $this->addBeforeHook(__FUNCTION__, $item);

        // load current edit data and merge them
        $this->form = $item;

        // change view
        $this->currentPage = "delete";

        $this->addAfterHook(__FUNCTION__, $item);
    }

    //
    public
    function submitDeleteForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        // call delete method
        $this->delete($this->form);

        $this->refresh();
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }

    //
    public
    function submitInstantDeleteForm($index)
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
    public
    function submitFinalDeleteForm()
    {
        $this->addBeforeHook(__FUNCTION__);

        // todo submitFinalDeleteForm
        // hier muss noch das Submit Form erweitert werden, damit es je nach soft delete oder normal die
        // richtige Methode ausführt


        $this->refresh();
        $this->currentPage = "index";

        $this->addAfterHook(__FUNCTION__);
    }

    // End of:  Page handling Section
    //
    //

}
