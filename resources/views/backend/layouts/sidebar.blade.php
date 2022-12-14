  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

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
                      <a href="{{ route('backend.the_loai.index') }}"
                          class="nav-link {{ \Request::route()->getName() == 'the_loai.index' ? 'active' : '' }}">
                          <i class="fas fa-book-reader"></i>&nbsp;
                          <p>
                              Thể loại
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('backend.san_pham.index') }}"
                          class="nav-link {{ \Request::route()->getName() == 'san_pham.index' ? 'active' : '' }}">
                          <i class="fas fa-shopping-cart"></i>&nbsp;
                          <p>
                              Sản phẩm
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('backend.don_hang.index') }}"
                          class="nav-link {{ \Request::route()->getName() == 'don_hang.index' ? 'active' : '' }}">
                          <i class="fas fa-list-ol"></i>&nbsp;
                          <p>
                              Đơn hàng của bạn
                          </p>
                      </a>
                  </li>
                  {{-- @can('check-user-is-admin')
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
                                  <a href="{{ route('backend.admin.index') }}"
                                      class="nav-link {{ \Request::route()->getName() == 'admin.index' ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Thống kê</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('backend.admin.order-placed') }}"
                                      class="nav-link {{ \Request::route()->getName() == 'admin.order-placed' ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Danh sách đơn hàng</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('backend.admin.product.index') }}"
                                      class="nav-link {{ \Request::route()->getName() == 'admin.product.index' ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Danh sách món ăn</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan --}}
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
