<?php

namespace Saguajardo\BootstrapMenu;

use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;
use Illuminate\Http\Request;

class BootstrapMenu {

    /**
     * @var DatatableHelper
     */
    private $bootstrapMenuHelper;

    /**
     * @var DatatableBuilder
     */
    private $bootstrapMenuBuilder;

    /**
     * Datatable options
     *
     * @var array
     */
    protected $bootstrapMenuOptions = [
        'model' => '',
    ];

    /**
     * Name of the parent form if any
     *
     * @var string|null
     */
    protected $model = '';

    /**
     * Constructor de la clase
     */
    public function __construct() {
        // Construct
    }

    /**
     * Set the datatable helper only on first instantiation
     *
     * @param DatatableHelper $datatableHelper
     * @return $this
     */
    public function setBootstrapMenuHelper(BootstrapMenuHelper $bootstrapMenuHelper)
    {
        $this->bootstrapMenuHelper = $bootstrapMenuHelper;

        return $this;
    }

    /**
     * Set datatable builder instance on helper so we can use it later
     *
     * @param DatatableBuilder $datatableBuilder
     * @return $this
     */
    public function setBootstrapMenuBuilder(BootstrapMenuBuilder $bootstrapMenuBuilder)
    {
        $this->bootstrapMenuBuilder = $bootstrapMenuBuilder;

        return $this;
    }

    /**
     * Get datatable helper
     *
     * @return DatatableHelper
     */
    public function getBootstrapMenuHelper()
    {
        return $this->bootstrapMenuHelper;
    }

    /**
     * Get all datatable options
     *
     * @return array
     */
    public function getBootstrapMenuOptions()
    {
        return $this->bootstrapMenuOptions;
    }

    /**
     * Get single datatable option
     *
     * @param string $option
     * @param $default
     * @return mixed
     */
    public function getBootstrapMenuOption($option, $default = null)
    {
        return array_get($this->bootstrapMenuOptions, $option, $default);
    }

    /**
     * Set single datatable option on datatable
     *
     * @param string $option
     * @param mixed $value
     *
     * @return $this
     */
    public function setBootstrapMenuOption($option, $value)
    {
        $this->bootstrapMenuOptions[$option] = $value;

        return $this;
    }


    /**
     * Get Model
     *
     * @return string model
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Set Model
     *
     * @param string $model Model
     */
    public function setModel($model) {
        $this->model = $model;

        return $this;
    }

    /**
     * Build the datatable
     *
     * @return mixed
     */
    public function buildBootstrapMenu()
    {   
        $model = $this->bootstrapMenuHelper->getConfig('models.menu');
        $this->model = new $model;
        return $this;
    }

    /**
     * Set datatable options
     *
     * @param array $datatableOptions
     * @return $this
     */
    public function setBootstrapMenuOptions($bootstrapMenuOptions)
    {

        $this->bootstrapMenuOptions = $this->bootstrapMenuHelper->mergeOptions($this->bootstrapMenuOptions, $bootstrapMenuOptions);
        
        return $this;
    }


    /**
     * Define the datatable's default values
     * @return string
     */
    protected function renderViewBootstrapMenu() {
        return $this->bootstrapMenuHelper->getView()
            ->make($this->getTemplateView())
            ->with('classAside', $this->bootstrapMenuHelper->getConfig('classAside'))
            ->with('optionsAside', $this->bootstrapMenuHelper->getConfig('optionsAside'))
            ->with('classSection', $this->bootstrapMenuHelper->getConfig('classSection'))
            ->with('optionsSection', $this->bootstrapMenuHelper->getConfig('optionsSection'))
            ->with('classUl', $this->bootstrapMenuHelper->getConfig('classUl'))
            ->with('optionsUl', $this->bootstrapMenuHelper->getConfig('optionsUl'))
            ->with('menus', $this->bootstrapMenuBuilder->getBootstrapMenu($this->model))
            ->with('bootstrapMenuBuilder', $this->bootstrapMenuBuilder)
            ->render();
    }

    /**
     * Render full datatable
     *
     * @param array $options
     * @param bool  $showStart
     * @param bool  $showFields
     * @param bool  $showEnd
     * @return string
     */
    public function renderBootstrapMenu()
    {
        return $this->renderViewBootstrapMenu();
    }

    /**
     * Get template from options if provided, otherwise fallback to config
     *
     * @return mixed
     */
    protected function getTemplateView()
    {
        return $this->getBootstrapMenuOption('template', $this->bootstrapMenuHelper->getConfig('menu_template'));
    }

}