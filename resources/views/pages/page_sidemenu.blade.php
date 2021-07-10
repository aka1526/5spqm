        <nav class="page-sidebar" id="sidebar">
          <div id="sidebar-collapse">
              <div class="admin-block d-flex">
                  <div>
                      <img src="./assets/img/admin-avatar.png" width="45px" />
                  </div>
                  <div class="admin-info">
                      <div class="font-strong">Admin</div><small>Administrator</small></div>
              </div>
              <ul class="side-menu metismenu">
                  <li>
                      <a class="active" href="index.html"><i class="sidebar-item-icon fa fa-th-large"></i>
                          <span class="nav-label">Dashboard</span>
                      </a>
                  </li>
                  <li class="heading">ตั้งค่าระบบ</li>
                  <li>
                      <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                          <span class="nav-label">กำหนดแผน</span><i class="fa fa-angle-left arrow"></i></a>
                      <ul class="nav-2-level collapse">
                          <li>
                              <a href="{{ route('plan.index')}}">แผนการตรวจ</a>
                          </li>
                          <li>
                              <a href="{{ route('area.index')}}">พื้นที่การตรวจ</a>
                          </li>

                      </ul>
                  </li>

              </ul>
          </div>
        </nav>
