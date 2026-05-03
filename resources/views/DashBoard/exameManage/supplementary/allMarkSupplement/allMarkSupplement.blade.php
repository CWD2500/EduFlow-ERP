@extends('layouts.admin.admin')


@section('content')
    <!-- Sidebar -->
    @include('layouts.admin.Sidebar')
    <!-- End Sidebar -->

<?php
    $academic_year =['السنة الاولى' ,  'السنة الثانية'];
    $Supplementary_course =['الدورة التكميلية' ];
?>

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
                            <a href="#">قسم التكميلي </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">  فسم النتائج التكميلي  </a>
                        </li>
                    </ul>
                </div>
                <div class="row justify-content-around">
               
                    <div class="col-md-6 ">
                        <a href="{{ route('dashBoard.viewMarkSupplementprogYearOne.manage') }}">
                            <div class="card"  style="    font-size: 25px;padding: 38px;background: blue;color: white;text-align: center;" >
                                <h4>  نتائج البرمجة النسة الاول التكميلي </h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 ">
                        <a href="{{ route('dashBoard.viewMarkSupplementprogYearTwo.manage') }}">
                            <div class="card"  style="    font-size: 25px;padding: 38px;background: blue;color: white;text-align: center;" >
                                <h4>  نتائج البرمجة النسة الثانية  التكميلي </h4>
                            </div>
                        </a>
                    </div>



                    <div class="col-md-6 ">
                        <a href="{{ route('dashBoard.viewMarkSupplementNetworkYearOne.manage') }}">
                          
                        <div class="card"  style="    font-size: 25px;padding: 38px;background: rgb(79, 2, 151);color: white;text-align: center;" >
                            <h4>  نتائج الشبكات النسة الاول  التكميلي   </h4>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-6 ">
                        <a href="{{ route('dashBoard.viewMarkSupplementNetworkYearTwo.manage') }}">
                        <div class="card"  style="    font-size: 25px;padding: 38px;background: rgb(79, 2, 151);color: white;text-align: center;" >
                            <h4>  نتائج الشبكات النسة الثانية  </h4>
                        </div>
                    </a>
                    </div>


                    <div class="col-md-6 ">
                        <a href="{{ route('dashBoard.viewMarkSupplementMainYearOne.manage') }}">
                        <div class="card"  style="    font-size: 25px;padding: 38px;background: rgb(25 22 78);color: white;text-align: center;" >
                            <h4>  نتائج الصيانة النسة الاول  </h4>
                        </div>
                    </a>
                    </div>
                    <div class="col-md-6 ">
                        <a href="{{ route('dashBoard.viewMarkSupplementMainYearTwo.manage') }}">
                        <div class="card"  style="    font-size: 25px;padding: 38px;background: rgb(25 22 78);color: white;text-align: center;" >
                            <h4>  نتائج الصيانة النسة الثانية  </h4>
                        </div>
                    </a>
                    </div>
                    
            
                            </form>
                        </div>
                    </div>
                </div>
            </div>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#searchable_select').select2({
                placeholder: 'Select an option',
                allowClear: true
            });
        });
    </script>

    <!-- Custom template | don't include it in your project! -->
    @include('layouts.admin.settings')
    <!-- End Custom template -->
@endsection
