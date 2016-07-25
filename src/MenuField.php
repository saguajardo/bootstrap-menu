<?php namespace Saguajardo\BootstrapMenu;

/**
 * Class FormField
 *
 * @package Kris\LaravelFormBuilder\Fields
 */
class MenuField
{
    /**
     * Name of the field
     *
     * @var
     */
    protected $id;

    /**
     * Type of the field
     *
     * @var
     */
    protected $titulo;

    /**
     * All options for the field
     *
     * @var
     */
    protected $childrens = [];

    /**
     * Is field rendered
     *
     * @var bool
     */
    protected $tieneHijos = false;

    /**
     * @var Form
     */
    protected $icono;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var FormHelper
     */
    protected $active;

    /**
     * @param             $name
     * @param             $type
     * @param Form        $parent
     * @param array       $options
     */
    public function __construct()
    {
        $this->active = false;
    }

    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * [Description]
     *
     * @param [type] $newactive [description]
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * [Description]
     *
     * @param [type] $newlink [description]
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }


    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getIcono() {
        return $this->icono;
    }

    /**
     * [Description]
     *
     * @param [type] $newicono [description]
     */
    public function setIcono($icono) {
        $this->icono = $icono;

        return $this;
    }

    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getTieneHijos() {
        return $this->tieneHijos;
    }

    /**
     * [Description]
     *
     * @param [type] $newtieneHijos [description]
     */
    public function setTieneHijos($tieneHijos) {
        $this->tieneHijos = $tieneHijos;

        return $this;
    }

    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getChildrens() {
        return $this->childrens;
    }

    /**
     * [Description]
     *
     * @param [type] $newchildrens [description]
     */
    public function setChildrens($childrens) {
        $this->childrens[] = $childrens;

        return $this;
    }


    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getTitulo() {
        return $this->titulo;
    }
    
    /**
     * [Description]
     *
     * @param [type] $newtitulo [description]
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * [Description]
     *
     * @param [type] $newid [description]
     */
    public function setId($id) {
        $this->id = $id;
    
        return $this;
    }

    public function setData($menu) {
        $this->setId($menu->id);
        $this->setTitulo($menu->titulo);
        $this->setIcono($menu->icono);
        $this->setLink($menu->link);
    }

}
