<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ URL::asset('public/assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->display_name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>     
      <li class="treeview {{ in_array(\Request::route()->getName(), ['orders.index', 'orders.create', 'orders.edit', 'orders-detail.index', 'orders-detail.edit', 'orders-detail.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-fw fa-list-alt"></i> 
          <span>Đơn hàng</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['orders.index', 'orders.edit']) ? "class=active" : "" }}><a href="{{ route('orders.index') }}"><i class="fa fa-circle-o"></i> Đơn hàng</a></li>
          <li {{ \Request::route()->getName() == "orders.create" ? "class=active" : "" }}><a href="{{ route('orders.create') }}"><i class="fa fa-circle-o"></i> Thêm đơn hàng</a></li>         
        </ul>
      </li>
        
      <li class="treeview {{ in_array(\Request::route()->getName(), ['customer.index', 'customer.create', 'customer.edit', 'customer.detail']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-fw fa-users"></i> 
          <span>Khách hàng</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['customer.index', 'customer.edit']) ? "class=active" : "" }}><a href="{{ route('customer.index') }}"><i class="fa fa-circle-o"></i> Khách hàng</a></li>
          <li {{ \Request::route()->getName() == "customer.create" ? "class=active" : "" }}><a href="{{ route('customer.create') }}"><i class="fa fa-circle-o"></i> Thêm khách hàng</a></li>         
        </ul>
      </li>
      @if( Auth::user()->role > 1)
      <li class="treeview {{ in_array(\Request::route()->getName(), ['menu.index', 'size.index', 'size.create', 'size.edit', 'thuoc-tinh.index', 'color.index', 'color.edit', 'color.create', 'account.index', 'account.edit', 'account.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa  fa-gears"></i>
          <span>Cài đặt</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">          
          <li {{ \Request::route()->getName() == "account.index" ? "class=active" : "" }}><a href="{{ route('account.index') }}"><i class="fa fa-circle-o"></i> Users</a></li>          
          <li {{ \Request::route()->getName() == "staff.index" ? "class=active" : "" }}><a href="{{ route('staff.index') }}"><i class="fa fa-circle-o"></i> Nhân viên</a></li>  
          <li {{ \Request::route()->getName() == "logs.index" ? "class=active" : "" }}><a href="{{ route('logs.index') }}"><i class="fa fa-circle-o"></i> Logs</a></li>      
        </ul>
      </li>
      @endif
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<style type="text/css">
  .skin-blue .sidebar-menu>li>.treeview-menu{
    padding-left: 15px !important;
  }
</style>