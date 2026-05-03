<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">

        <a href="{{ route('dashBoard.home') }}">
          <img src="{{ asset('img/logo.png') }}" alt="" style="   width: 60px;height: 60px;"
          >
        </a>
       
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item active">
            <a
             
              href="{{ route('dashBoard.home' ) }}"
              class="collapsed"
              aria-expanded="false"
            >
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
              <span class="caret"></span>
            </a>
          
          </li>
          <li class="nav-section">
            <span class="sidebar-mini-icon ">
              <i class="fa fa-ellipsis-h" ></i>
            </span>
            <h4 class="text-section text-white">-------------</h4>
          </li>
          <li class="nav-item">
            <a href="{{ route('dashBoard.exams.manage.home') }}">
              <i class="fas fa-layer-group  font-icon-slide"></i>
              <p class="text-white" style="font-size: 20px"> الامتحانات</p>
              {{-- <span class="caret"></span> --}}
            </a>
          </li>


          <li class="nav-item">
            <a  href="{{ route('dashBoard.specialization.home' ) }}">
              <i class="fa fa-graduation-cap font-icon-slide"></i>
              <p class="text-white" style="font-size: 20px">  الاختصاصات  </p>
              {{-- <span class="caret"></span> --}}
            </a>
          </li>


          
          <li class="nav-item">
            <a  href="{{ route('dashBoard.subject.home') }}">
              <i class="fas fa-book-open font-icon-slide"></i>
              <p class="text-white" style="font-size: 20px"> المواد الدراسية</p>
          
            </a>
          </li>
 
          <li class="nav-item">
            <a  href="{{ route('dashBoard.teacher.home') }}">
              <i class="fa fa-user-tie font-icon-slide"></i>
              <p class="text-white" style="font-size: 20px">  المهندسين  </p>

            </a>
          </li>


          



          <li class="nav-item">
            <a  href="{{ route('dashBoard.student.department.home') }}">
              <i class="fas fa-user-graduate font-icon-slide"></i>
              <p class="text-white" style="font-size: 20px">  الطلاب  </p>
              {{-- <span class="caret"></span> --}}
            </a>
          </li>


          {{-- <li class="nav-item">
            <a data-bs-toggle="collapse" href="#">
              <i class="fas fa-graduation-cap font-icon-slide"></i>
              <p class="text-white" style="font-size: 20px">   العلامات    </p>
          
            </a>
          </li> --}}
{{-- 

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#">
              <i class="fas fa-wrench font-icon-slide"></i>
              <p class="text-white" style="font-size: 20px">  الاعدادات     </p>
            
            </a>
          </li> --}}
  
 
       


        </ul>
      </div>
    </div>
  </div>