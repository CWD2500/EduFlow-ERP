<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
  <div class="container-fluid">
      <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"></nav>
      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
          <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"></li>
          <li class="nav-item topbar-icon dropdown hidden-caret">
              <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <span class="notification">{{ count($notifications) }}</span>
              </a>
              <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                  <li>
                      <div class="dropdown-title">You have {{ count($notifications) }} new notifications</div>
                  </li>
                  <li>
                      <div class="notif-scroll scrollbar-outer">
                          <div class="notif-center">
                              @foreach ($notifications as $item)
                                  <a href="#">
                                      <div class="notif-icon notif-primary"><i class="fa fa-user-plus"></i></div>
                                      <div class="notif-content">
                                          <span class="block">  {{ $item->users->name   }} : {{$item->user_id}} </span>
                                          <span class="block"> {{$item->message}}   </span>
                                          <span class="time">{{$item->created_at}}</span>
                                      </div>
                                  </a>
                              @endforeach
                          </div>
                      </div>
                  </li>
                  <li></li>
              </ul>
          </li>
      </ul>
  </div>
</nav>
