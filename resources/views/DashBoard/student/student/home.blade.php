@extends('layouts.admin.admin')


@section('content')
    <style>
        .StudentCard {
            padding: 60px;
            background: #0c0642;
            font-weight: 800;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 24px;
            cursor: pointer;
            color: aqua;
            text-decoration-line: none;

            /* box-shadow: 0px 0px 13px 4px #16049eb0; */
            transition: box-shadow 1s, color 1s, background-color 1s;
            direction: rtl;
            /* box-shadow: 0px 0px 5px -3px #2714b1b0;
            box-shadow: 0px 0px 13px 4px #16049eb0; */
            box-shadow: 0px 0px 13px 4px #16049eb0;
        }

        .StudentCard:hover{
            color: #fff;
            box-shadow: 0px 0px 5px -3px #2714b1b0;
            transition: 0.5s;
            /* border: 1px solid aqua; */
            background-color: #1e1285;
        }
    </style>
    <?php
    $i = 0;
    $i += 1;
    ?>
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
                            <h3 class="fw-bold mb-3"> الطلاب </h3>
                            <ul class="breadcrumbs mb-3">

                                <li class="nav-home">
                                    <a href="{{ route('dashBoard.student.department.home') }}">
                                        <i class="icon-home"></i>
                                    </a>
                                </li>
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#"> قسم البرمجة </a>
                                </li>
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#">السنة الاولى </a>
                                </li>
                            </ul>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                             
                            </div>
                            <div class="col-sm-12  col-md-6   "
                                style=" display: flex;flex-direction: row;justify-content: end;">
                                <h1 class="text-right">
                                    <a href="{{ route('dashBoard.student.create') }}"
                                        class="btn btn-outline-primary w-100 "> أنشاء </a>
                                </h1>
                            </div>


                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.student.year.one') }}">
                                    <div class="card  StudentCard">
                                        <h2 class="text-center"> الطلاب البرمجة سنة الاولى <i class="fas fa-code icon"></i>
                                        </h2>
                                    </div>
                                </a>
                            </div>


                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.student.year.two') }}">
                                    <div class="card  StudentCard">
                                        <h2 class="text-center"> الطلاب البرمجة سنة الثانية <i class="fas fa-code icon"></i>
                                        </h2>
                                    </div>
                                </a>
                            </div>


                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.student.net.year.one') }}">
                                    <div class="card  StudentCard">
                                        <h2 class="text-center"> الطلاب الشبكات سنة الاولى 
                                            <i class="fas fa-server"></i>
                                        </h2>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.student.net.year.two') }}">
                                    <div class="card  StudentCard">
                                        <h2 class="text-center"> الطلاب الشبكات سنة الثاني 
                                            <i class="fas fa-server"></i>
                                        </h2>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.student.maintenance.year.one') }}">
                                    <div class="card  StudentCard">
                                        <h2 class="text-center"> الطلاب الصيانة سنة الاولى 
                                            <i class="fas fa-desktop"></i>
                                        </h2>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('dashBoard.student.maintenance.year.two') }}">
                                    <div class="card  StudentCard">
                                        <h2 class="text-center"> الطلاب الصيانة سنة الثاني 
                                            <i class="fas fa-desktop"></i>
                                        </h2>
                                    </div>
                                </a>
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
