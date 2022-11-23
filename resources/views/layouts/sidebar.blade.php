  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('menu.index') }}" class="brand-link">
          <img src="{{ asset('adminlte3-1-0/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Nhi Fashion</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('adminlte3-1-0/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ auth()->user()->ten }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item">
                      <a href="{{ route('menu.index') }}"
                          class="nav-link {{ \Request::route()->getName() == 'menu.index' ? 'active' : '' }}">
                          <i class="fas fa-book-reader"></i>&nbsp;
                          <p>
                              Thực đơn
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('order.index') }}"
                          class="nav-link {{ \Request::route()->getName() == 'order.index' ? 'active' : '' }}">
                          <i class="fas fa-shopping-cart"></i>&nbsp;
                          <p>
                              Giỏ hàng
                              <span
                                  class="right badge badge-danger qty-product-in-cart">{{ session('cart.product') != null ? count(session('cart.product')) : 0 }}</span>
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('order.placed') }}"
                          class="nav-link {{ \Request::route()->getName() == 'order.placed' ? 'active' : '' }}">
                          <i class="fas fa-list-ol"></i>&nbsp;
                          <p>
                              Đơn hàng của bạn
                          </p>
                      </a>
                  </li>
                  @can('check-user-is-admin')
                      <li
                          class="nav-item {{ in_array(\Request::route()->getName(), ['admin.index', 'admin.order-placed', 'admin.product.index']) ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ in_array(\Request::route()->getName(), ['admin.index', 'admin.order-placed', 'admin.product.index']) ? 'active' : '' }}">
                              <i class="nav-icon fas fa-tachometer-alt"></i>
                              <p>
                                  Trang Admin
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('admin.index') }}"
                                      class="nav-link {{ \Request::route()->getName() == 'admin.index' ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Thống kê</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('admin.order-placed') }}"
                                      class="nav-link {{ \Request::route()->getName() == 'admin.order-placed' ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Danh sách đơn hàng</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('admin.product.index') }}"
                                      class="nav-link {{ \Request::route()->getName() == 'admin.product.index' ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Danh sách món ăn</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
