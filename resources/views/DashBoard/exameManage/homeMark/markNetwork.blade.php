@extends('layouts.admin.admin')


@section('content')
    <!-- Sidebar -->
    @include('layouts.admin.Sidebar')
    <!-- End Sidebar -->
<style>
    /* All Mark */
.card{
    background: #1a2035;
    color: white;
    width: 431px;
    padding: 30px;
    /* border-radius: 100%; */
    height: 180px;
    text-align: center;
    display: flex;
    justify-content: center
   
}
.card h4{
    font-size: 26px;
    font-family:Arial, Helvetica, sans-serif;
}
.card:hover{
    border: 1px solid blue;
    text-shadow: 0px 1px 0px blue;
    
}
</style>

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <!-- Logo Header -->
                @include('layouts.admin.headerLogo')
                <!-- End Logo Header -->
            </div>
            <!-- Navbar Header -->
            @include('layouts.admin.navbar')
            <!-- End Navbar -->
        </div>

        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <h3 class="fw-bold mb-3">الامتحانات</h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                            <a href="#">
                                <i class="icon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">الامتحانات</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">الانشاء</a>
                        </li>
                    </ul>
                </div>
                <div class="row m-5">
                       <div class="col-md-6 col-lg-6">
                        <a href="">
                            <div class="card">
                                <h4> الشبكات سنة اولى</h4>
                            </div>
                        </a>
                       </div>
                       <div class="col-md-6 col-lg-6">
                        <div class="card">
                            <h4> الشكبات سنة الثانية</h4>
                         </div>
                       </div>
                
                  
                  
                </div>
            </div>
        </div>
    </div>
    


    <!-- Custom template | don't include it in your project! -->
    @include('layouts.admin.settings')
    <!-- End Custom template -->
@endsection
