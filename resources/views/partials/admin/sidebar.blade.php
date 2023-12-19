
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 my-3 fixed-start ms-3   bg-white" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0 text-center" href="/admin/dashboard">
    <img src="/assets/img/logo.jpeg" width="30%" class="d-inline-block align-top" alt="">
    <h5 class="mt-1" style="color:#C50901; -webkit-text-stroke-width: 1px;
  -webkit-text-stroke-color: #AE9E00; font-weight: bold;">Triple J Savers Mart</h5>

    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      @can('dashboard')
        <li class="nav-item">
            <a class="nav-link text-dark {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.dashboard") }}">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10 {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'text-white' : '' }}">dashboard</i>
            </div>
            <span class="nav-link-text ms-1 text-uppercase">Dashboard</span>
            </a>
        </li>
      @endcan
      <hr class="bg-primary">
      @can('inventories')
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
            @can('inventories')
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.products.index") }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-list text-dark {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                        </div>
                        <span class="nav-link-text ms-1 text-uppercase">Inventories</span>
                    </a>
                </li>
            @endcan
            @can('categories')
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
        <hr class="bg-primary">
        <li class="nav-item"  data-toggle="collapse" data-target="#supplier" class="collapsed active">
            <a class="nav-link text-dark" href="#">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-caret-down " style="font-size: 17px"></i>

            </div>
            <span class="nav-link-text ms-1 text-uppercase">Suppliers</span>
            </a>
        </li>

        <div class="sub-menu collapse show" id="supplier">
            <li class="nav-item">
                <a class="nav-link text-dark {{ request()->is('admin/purchase_order') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.purchase_order.index") }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-list text-dark {{ request()->is('admin/purchase_order') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                    </div>
                    <span class="nav-link-text ms-1 text-uppercase">Purchase Order</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark {{ request()->is('admin/purchase_order/deliveries') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.purchase_order.deliveries") }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-list text-dark {{ request()->is('admin/purchase_order/deliveries') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                    </div>
                    <span class="nav-link-text ms-1 text-uppercase">Deliveries</span>
                </a>
            </li>
        </div>
        <hr class="bg-primary">
        <li class="nav-item"  data-toggle="collapse" data-target="#reports" class="collapsed active">
            <a class="nav-link text-dark" href="#">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-caret-down " style="font-size: 17px"></i>

            </div>
            <span class="nav-link-text ms-1 text-uppercase">Reports</span>
            </a>
        </li>
        <div class="sub-menu collapse show" id="reports">
            @can('salesforcast')
            <li class="nav-item">
            <a class="nav-link text-dark {{ request()->is('admin/sales_reports') || request()->is('admin/sales_reports/*') || request()->is('admin/salesforcast/*') ? 'bg-gradient-dark text-white' : '' }}" href="/admin/sales_reports/daily/daily/daily">
                <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-list {{ request()->is('admin/sales_reports') || request()->is('admin/sales_reports/*') || request()->is('admin/salesforcast/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                </div>
                <span class="nav-link-text ms-1 text-uppercase">Saleforecast</span>
            </a>
            </li>
            @endcan
            <li class="nav-item">
            <a class="nav-link text-dark {{ request()->is('admin/inventory_reports') || request()->is('admin/inventory_reports/*') ? 'bg-gradient-dark text-white' : '' }}" href="/admin/inventory_reports">
                <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-list {{ request()->is('admin/inventory_reports') || request()->is('admin/inventory_reports/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                </div>
                <span class="nav-link-text ms-1 text-uppercase">Inventory Reports</span>
            </a>
            </li>
            @can('activities')
            <li class="nav-item">
            <a class="nav-link text-dark {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'bg-gradient-dark text-white' : '' }}" href="/admin/activities">
                <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-list {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                </div>
                <span class="nav-link-text ms-1 text-uppercase">Activities</span>
            </a>
            </li>
            @endcan
        </div>
        <hr class="bg-primary">
        @can('accounts')
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
            @can('roles')
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.roles.index") }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tag {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
                    </div>
                    <span class="nav-link-text ms-1 text-uppercase">Roles</span>
                    </a>
                </li>
            @endcan
            @can('accounts')
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


