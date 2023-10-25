
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 my-3 fixed-start ms-3   bg-white" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0 text-center" href="/admin/dashboard">
    <img src="/assets/img/logo.jpeg" width="100" height="500" class="d-inline-block align-top" alt="">

    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      @can('dashboard_access')
        <li class="nav-item">
            <a class="nav-link text-dark {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.dashboard") }}">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10 {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'text-white' : '' }}">dashboard</i>
            </div>
            <span class="nav-link-text ms-1 text-uppercase">Dashboard</span>
            </a>
        </li>
      @endcan
      @can('inventories_access')
      <li class="nav-item"  data-toggle="collapse" data-target="#products" class="collapsed active">
        <a class="nav-link text-dark" href="#">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-caret-down " style="font-size: 17px"></i>

        </div>
          <span class="nav-link-text ms-1 text-uppercase">Manage Category</span>
        </a>
      </li>
      @endcan

        <div class="sub-menu collapse show" id="products">
            @can('inventories_access')
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.products.index") }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-list text-dark {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                        </div>
                        <span class="nav-link-text ms-1 text-uppercase">Inventories</span>
                    </a>
                </li>
            @endcan
            @can('categories_access')
            <li class="nav-item">
                <a class="nav-link text-dark {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.categories.index") }}">
                <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-tag {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                </div>
                <span class="nav-link-text ms-1 text-uppercase">Categories</span>
                </a>
            </li>
            @endcan
        </div>


        @can('salesforcast_access')
        <li class="nav-item">
          <a class="nav-link text-dark {{ request()->is('admin/sales_reports') || request()->is('admin/sales_reports/*') ? 'bg-gradient-dark text-white' : '' }}" href="/admin/sales_reports/daily/daily/daily">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-list {{ request()->is('admin/sales_reports') || request()->is('admin/sales_reports/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
            </div>
            <span class="nav-link-text ms-1 text-uppercase">Saleforecast</span>
          </a>
        </li>
        @endcan
        @can('activities_access')
        <li class="nav-item">
          <a class="nav-link text-dark {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'bg-gradient-dark text-white' : '' }}" href="/admin/activities">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-list {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
            </div>
            <span class="nav-link-text ms-1 text-uppercase">Activities</span>
          </a>
        </li>
        @endcan
        @can('accounts_access')
        <li class="nav-item"  data-toggle="collapse" data-target="#accounts" class="collapsed active">
            <a class="nav-link text-dark" href="#">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-caret-down " style="font-size: 17px"></i>

            </div>
            <span class="nav-link-text ms-1 text-uppercase">Manage Accounts</span>
            </a>
       </li>
       @endcan

        <div class="sub-menu collapse show" id="accounts">
            @can('roles_access')
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.roles.index") }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tag {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                    </div>
                    <span class="nav-link-text ms-1 text-uppercase">Roles</span>
                    </a>
                </li>
            @endcan
            @can('accounts_access')
            <li classW="nav-item">
                <a class="nav-link text-dark {{ request()->is('admin/accounts') || request()->is('admin/accounts/*') ? 'bg-gradient-dark text-white' : '' }}" href="/admin/accounts">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-list {{ request()->is('admin/accounts') || request()->is('admin/accounts/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                    </div>
                    <span class="nav-link-text ms-1 text-uppercase">Accounts</span>
                </a>
            </li>
            @endcan
        </div>



    </ul>
  </div>

</aside>


