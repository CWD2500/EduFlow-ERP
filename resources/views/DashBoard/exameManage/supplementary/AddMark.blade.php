
@extends('layouts.admin.admin')


@section('content')
    <!-- Sidebar -->
    @include('layouts.admin.Sidebar')
    <!-- End Sidebar -->

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


                <div class="container">
               
                    <div class="page-inner">
                        <div class="page-header">
                            <h3 class="fw-bold mb-3"> الامتحانات </h3>
                            <ul class="breadcrumbs mb-3">

                                <li class="nav-home">
                                    <a href="{{ route('dashBoard.supplementary.manage') }}">
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
                                    <a href="{{ route('dashBoard.supplementary.manage') }}">قسم اضافة العلامات  التكميلي</a>
                                </li>
                            </ul>
                            
                        </div>
                       <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.addMarkSupplementDepProg.manage') }}">
                                <div class="card  myExameCard" >
                    
                                    <h2 class="text-center">قسم   البرمجة      </h2>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.addMarkSupplementDepNetwork.manage') }}">
                                <div class="card  myExameCard" >
                    
                                    <h2 class="text-center">قسم   الشبكات      </h2>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <a href="{{ route('dashBoard.addMarkSupplementDepMain.manage') }}">
                                <div class="card  myExameCard" >
                    
                                    <h2 class="text-center">قسم   الصيانة      </h2>
                                </div>
                                </a>
                            </div>
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
