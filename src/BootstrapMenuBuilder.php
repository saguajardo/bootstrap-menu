<?php  namespace Saguajardo\BootstrapMenu;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Route;
use Saguajardo\BootstrapMenu\MenuField;
use Auth;
use App\User;

class BootstrapMenuBuilder
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var model
     */
    protected $model;

    /**
     * @var menu
     */
    protected $menu = array();

    /**
     * @var menuField
     */
    protected $menuField;

    /**
     * @var FormHelper
     */
    protected $bootstrapMenuHelper;

    /**
     * @param Container  $container
     * @param FormHelper $formHelper
     */
    public function __construct(Container $container, BootstrapMenuHelper $bootstrapMenuHelper)
    {
        $this->container = $container;
        $this->bootstrapMenuHelper = $bootstrapMenuHelper;
    }

    /**
     * @param       $formClass
     * @param       $options
     * @param       $data
     * @return Form
     */
    public function create($bootstrapMenuClass, array $options = [])
    {
        $class = $bootstrapMenuClass;

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                'BootstrapMenu class with name ' . $class . ' does not exist.'
            );
        }

        $bootstrapMenu = $this->container
            ->make($class)
            ->setBootstrapMenuHelper($this->bootstrapMenuHelper)
            ->setBootstrapMenuBuilder($this)
            ->setBootstrapMenuOptions($options);

        $bootstrapMenu->buildBootstrapMenu();

        return $bootstrapMenu;
    }

    /**
     * [getUrlActual description]
     * @return [type] [description]
     */
    protected function getUrlActual() {
        $routes = Route::current()->getCompiled()->getStaticPrefix();
        return $routes;
    }

    public function getBootstrapMenu($model) {

        $this->model = $model;

        $user = User::find(Auth::user()->id);

        //Inicializo la variable de iteración
        $cantMenu = 0;

        $routes = $this->getUrlActual();

        //Obtengo la cantidad total de opciones de menu cargadas
        $count = $this->model->where("padre", "0")->count();

        $resultMenu = $this->model->all()->where("padre", "0")->where("anterior", "0")->first();

        //Mientras no se alcance la cantidad total de menús cargados...
        while($cantMenu < $count) {

            //Si es el primero, busco el menú principal (aquel que no tiene predecesores)
            if($cantMenu == "0") {
                $idAnterior = "0";
            } else {
                //De lo contrario asigno la ID del menú que tiene predecesor cero
                $idAnterior = $resultMenu->id;
            }

            //Obtengo los datos del menú actual
            $resultMenu = $this->model->all()->where("padre", "0")->where("anterior", "$idAnterior")->first();
        
            //Obtengo los submenus en caso de existir
            $submenu = $this->model->all()->where("padre", "$resultMenu->id")->where("anterior", "0")->first();
            
            //Si tiene submenus, los muestro
            if ($submenu) {
                $this->menuField = new MenuField();
                $this->menuField->setData($resultMenu);
                $this->menuField->setTieneHijos(true);

                //Inicializo la variable de iteración
                $cantSubMenu = 0;

                $countSubmenu = $this->model->where("padre", "$resultMenu->id")->count();

                $muestraMenu = false;
                //Mientras no se alcance la cantidad total de menús cargados...
                while($cantSubMenu < $countSubmenu) {
                    $active = false;
                    $show = false;
                    $objSubmenu = new MenuField();

                    //Si es el primero, busco el menú principal (aquel que no tiene predecesores)
                    if($cantSubMenu == "0") {
                        $idAnteriorSubmenu = "0";
                    } else {
                        //De lo contrario asigno la ID del menú que tiene predecesor cero
                        $idAnteriorSubmenu = $submenu->id;
                    }

                    $submenu = $this->model->all()->where("padre", "$resultMenu->id")->where("anterior", "$idAnteriorSubmenu")->first();
                    
                    // *************Consulta si el submenu tiene a su vez un submenu*************
                    
                    //Obtengo los submenus de segundo nivel en caso de existir
                    $submenuSecond = $this->model->all()->where("padre", "$submenu->id")->where("anterior", "0")->first();


                    //Si tiene submenus de segundo nivel, los muestro
                    if ($submenuSecond) {
                        $objSubmenu->setData($submenu);
                        $objSubmenu->setTieneHijos(true);

                        //Inicializo la variable de iteración
                        $cantSubMenuSecond = 0;

                        $countSubmenuSecond = $this->model->where("padre", "$submenu->id")->count();

                        //Mientras no se alcance la cantidad total de submenu cargados...
                        while($cantSubMenuSecond < $countSubmenuSecond) {
                            $objSubmenuSecond = new MenuField();

                            //Si es el primero, busco el menu principal (aquel que no tiene predecesores)
                            if($cantSubMenuSecond == "0") {
                                $idAnteriorSubmenuSecond = "0";
                            } else {
                                //De lo contrario asigno la ID del menu que tiene predecesor cero
                                $idAnteriorSubmenuSecond = $submenuSecond->id;
                            }

                            $submenuSecond = $this->model->all()->where("padre", "$submenu->id")->where("anterior", "$idAnteriorSubmenuSecond")->first();
                            
                            if($user->can($submenuSecond->slug)) {
                                $show = true;
                                // muestro el menu con submenus
                                $objSubmenuSecond->setData($submenuSecond);
                                $objSubmenu->setChildrens($objSubmenuSecond);
                                if($routes == $objSubmenuSecond->getLink()) {
                                    $objSubmenuSecond->setActive(true);
                                    $active = true;
                                }
                            }
                            
                            $cantSubMenuSecond++;
                        }
                    } else {
                        
                        if($user->can($submenu->slug)) {
                            $show = true;
                            //de lo contrario, muestro el menu sin submenus
                            $objSubmenu->setData($submenu);
                            if($routes == $objSubmenu->getLink()) {
                                $objSubmenu->setActive(true);
                                $active = true;
                            }
                        }
                    }

                    // *************Fin submenu del submenu*************
                    if($show) {
                        $muestraMenu = true;
                        $this->menuField->setChildrens($objSubmenu);
                        if($active)
                            $this->menuField->setActive(true);    
                    }
                   $cantSubMenu++;
                }
                if($muestraMenu) {
                    $this->menu[] = $this->menuField;
                }
                    
            } else {
                
                // Verifica si tiene permisos para mostrar el menu
                if($user->can($resultMenu->slug)) {
                    //de lo contrario, muestro el menu sin submenus
                    $this->menuField = new MenuField();
                    $this->menuField->setData($resultMenu);
                    if($routes == $this->menuField->getLink())
                        $this->menuField->setActive(true);

                    $this->menu[] = $this->menuField;    
                }
            }

            //incremento la variable de iteracion.
            $cantMenu++;
        }

        return $this->menu;
    }

}
