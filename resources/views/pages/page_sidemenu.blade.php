        <nav class="page-sidebar" id="sidebar">
          <div id="sidebar-collapse">
              <div class="admin-block d-flex">
                  <div>
                      <img src="/assets/img/admin-avatar.png" width="45px" />
                  </div>
                  <div class="admin-info">
                      <div class="font-strong">Admin</div><small>Administrator</small></div>
              </div>
              <ul class="side-menu metismenu">
                  <!-- <li>
                      <a class="active" href="{{ route('dashboard.index')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                          <span class="nav-label">Dashboard</span>
                      </a>
                  </li> -->
                  <li>
                      <a class="active" href="{{ route('check.index')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                          <span class="nav-label">ตรวจประเมินพื้นที่</span>
                      </a>
                  </li>

                  <li>
                      <a class="active" href="{{ route('plan.index')}}"><i class="sidebar-item-icon fa fa-calendar"></i>
                          <span class="nav-label">แผนตรวจประเมิน</span>
                      </a>
                  </li>

                  <li class="heading">ตั้งค่าระบบ</li>
                  <li>
                      <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                          <span class="nav-label">ข้อมูลพื้นฐาน</span><i class="fa fa-angle-left arrow"></i></a>
                      <ul class="nav-2-level collapse">

                        <li>
                            <a href="{{ route('questions.index')}}">แบบฟอร์มการตรวจพื้นที่</a>

                        </li>

                          <li>
                              <a href="{{ route('auditor.index')}}">ทีมตรวจ/Auditor</a>
                          </li>
                          <li>
                              <a href="{{ route('area.index')}}">พื้นที่การตรวจ</a>
                          </li>
                          <li>
                              <a href="{{ route('user.index')}}">User Login</a>
                          </li>
                      </ul>
                  </li>

              </ul>
          </div>
        </nav>
