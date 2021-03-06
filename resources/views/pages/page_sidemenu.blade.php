        <nav class="page-sidebar" id="sidebar">
          <div id="sidebar-collapse">
              <div class="admin-block d-flex">
                  <div>
                      <img src="/assets/img/admin-avatar.png" width="45px" />
                  </div>
                  <div class="admin-info">
                       @if(Cookie::get('USER_LEVEL') =='admin' || Cookie::get('USER_LEVEL') =='user')
                          <div class="font-strong"> {{ Cookie::get('USER_NAME') }}</div>
                          <small> {{ Cookie::get('USER_LEVEL') }}</small>
                        @else
                          <div class="font-strong">ผู้เยี่ยมชม</div>
                          <small>-</small>
                        @endif

                  </div>
              </div>
              <ul class="side-menu metismenu">
                    <li class="active">
                        <a href="javascript:;" aria-expanded="true"><i class="sidebar-item-icon fa fa-sitemap"></i>
                            <span class="nav-label">สรุปผลแยกตามพื้นที่</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse in" aria-expanded="true" style="">
                            @for ($y =2021; $y <=  date('Y'); $y++)
                            <li class="">

                                <a href="javascript:;" aria-expanded="false">
                                    <span class="nav-label">{{ $y }}</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-3-level collapse" aria-expanded="false" style="height: 0px;">
                                  @for ($i =1; $i <= 12; $i++)
                                  <?php
                                   $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
                                   ?>
                                  <li>
                                      <a href="{{ route('report.byarea') }}?year={{ $y}}&month={{$i}}"> {{ $i.'. '.$months[$i] }}</a>
                                  </li>
                                   @endfor


                                </ul>
                            </li>
                             @endfor
                        </ul>
                    </li>
                    <li class="">
                        <a href="javascript:;" aria-expanded="false"><i class="sidebar-item-icon fa fa-sitemap"></i>
                            <span class="nav-label">คะแนนการตรวจพื้นที่</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse" aria-expanded="false" style="">
                            @for ($y =2021; $y <=  date('Y'); $y++)
                            <li class="">

                                <a href="javascript:;" aria-expanded="false">
                                    <span class="nav-label">{{ $y }}</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-3-level collapse" aria-expanded="false" style="height: 0px;">
                                  @for ($i =1; $i <= 12; $i++)
                                  <?php
                                   $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
                                   ?>
                                  <li>
                                      <a href="{{ route('check.byscore') }}?year={{ $y}}&month={{$i}}"> {{ $i.'. '.$months[$i] }}</a>
                                  </li>
                                   @endfor


                                </ul>
                            </li>
                             @endfor
                        </ul>
                    </li>
                    @if(Cookie::get('USER_LEVEL') =='admin' || Cookie::get('USER_LEVEL') =='user')
                            <li>
                                <a class="active" href="{{ route('check.index')}}">
                                  <i class="sidebar-item-icon fas fa-clipboard-check"></i>

                                    <span class="nav-label">ตรวจประเมินพื้นที่</span>
                                </a>
                            </li>
                      @endif
                      @if(Cookie::get('USER_LEVEL') =='admin')
                          <li class="heading">ตั้งค่าระบบ</li>
                          <li>
                              <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                                  <span class="nav-label">ข้อมูลพื้นฐาน</span><i class="fa fa-angle-left arrow"></i></a>
                              <ul class="nav-2-level collapse">
                                <li>
                                    <a  href="{{ route('plan.index')}}">สร้างแผนตรวจประเมิน</a>
                                </li>
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
                                      <a href="{{ route('user.index')}}">List User</a>
                                  </li>
                              </ul>
                          </li>

                    @endif

         </ul>
          </div>
        </nav>
