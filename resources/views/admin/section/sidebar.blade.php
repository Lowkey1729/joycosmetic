<!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-dark bg-dark" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
         <h2 style="color: #fff;" align="center"> <img src="{{asset('img/core-img/logo.png')}} " class="navbar-brand-img" alt="...">&nbsp;JoyCosmetics</h2>
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->

          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link @if(request()->route()->getName() === 'admin.dashboard') active  @endif " href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('css/admin/assets/img/icons/common/home.png') }}" width="20px">&nbsp;
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->route()->getName() === 'admin.categories') active  @endif  " href="{{ route('admin.categories') }}">
            <img src="{{ asset('css/admin/assets/img/icons/common/dollar.png') }}" width="20px">&nbsp;
                <span class="nav-link-text">Categories</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link  @if(request()->route()->getName() === 'admin.products') active  @endif " href="{{ route('admin.products') }}">
                <img src="{{ asset('css/admin/assets/img/icons/common/wallet.png') }}" width="20px">&nbsp;
                <span class="nav-link-text">Products</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->route()->getName() === 'admin.orders') active @endif " href="{{ route('admin.orders') }}">
                <img src="{{ asset('css/admin/assets/img/icons/common/coins.png') }}" width="20px">&nbsp;
                <span class="nav-link-text">Orders</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->route()->getName() === 'admin.users') active  @endif " href="{{ route('admin.users') }}">
                <img src="{{ asset('css/admin/assets/img/icons/common/group.png') }}" width="20px">&nbsp;
                <span class="nav-link-text">Users</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link  @if(request()->route()->getName() === 'admin.payments') active  @endif " href="{{ route('admin.payments') }}">
               <img src="{{ asset('css/admin/assets/img/icons/common/bussiness-man.png') }}" width="20px">&nbsp;
                <span class="nav-link-text">Payments</span>
              </a>
            </li>




          </ul>
        </div>
      </div>
    </div>
  </nav>

