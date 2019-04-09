<!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('img/avatar.png') }}" width="48" alt="User Image">
      <div>
        {{-- <p class="app-sidebar__user-name">{{Auth()->user()->name}}</p>
        <p class="app-sidebar__user-designation">{{Auth()->user()->email}}</p> --}}
      </div>
    </div>
    <ul class="app-menu">
      @auth('admin')
      <li><a class="app-menu__item {{ Route::currentRouteNamed('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>
      <li><a class="app-menu__item {{ Route::currentRouteNamed('departments.index') ? 'active' : '' || Route::currentRouteNamed('departments.create') ? 'active' : ''}}" href="{{ route('departments.index') }}"><i class="app-menu__icon 	fa fa-clipboard"></i><span class="app-menu__label">Departments</span></a></li>    
      <li><a class="app-menu__item {{ Route::currentRouteNamed('pastpapers.index') ? 'active' : '' || Route::currentRouteNamed('pastpapers.create') ? 'active' : ''}}" href="{{ route('pastpapers.index') }}"><i class="app-menu__icon 	fa fa-clipboard"></i><span class="app-menu__label">Pastpapers</span></a></li>         
      @endauth
    </ul>
  </aside>