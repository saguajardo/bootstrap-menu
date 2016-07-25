
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="{{ $classUl }}" {{ $optionsUl }}>
    @foreach($menus as $menu)
        @if(!$menu->getTieneHijos())
            <!-- No tiene submenus -->
            <li @if($menu->getActive()) class="active" @endif>
                <a href="{{ URL::to($menu->getLink()) }}">
                  <i class="{{ $menu->getIcono() }}"></i> <span>{{ $menu->getTitulo() }}</span>
                </a>
            </li>
        @else
            <!-- Tiene submenus -->
            <li class="treeview @if($menu->getActive()) active @endif">
                <a href="#">
                  <i class="{{ $menu->getIcono() }}"></i> <span>{{ $menu->getTitulo() }}</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @foreach($menu->getChildrens() as $children)
                        @if(!$children->getTieneHijos())
                            <!-- tiene un submenu de 1 nivel -->
                            <li class=" @if($children->getActive()) active @endif">
                                <a href="{{ URL::to($children->getLink()) }}">
                                  <i class="{{ $children->getIcono() }}"></i> {{ $children->getTitulo() }}
                                </a>
                            </li>
                        @else
                            <li class="treeview @if($children->getActive()) active @endif">
                                <a href="#">
                                  <i class="{{ $children->getIcono() }}"></i> <span>{{ $children->getTitulo() }}</span>
                                  <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                @foreach($children->getChildrens() as $child)
                                    <li class=" @if($child->getActive()) active @endif">
                                        <a href="{{ URL::to($child->getLink()) }}">
                                          <i class="{{ $child->getIcono() }}"></i> {{ $child->getTitulo() }}
                                        </a>
                                    </li>
                                @endforeach
                                </ul>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach
</ul>

