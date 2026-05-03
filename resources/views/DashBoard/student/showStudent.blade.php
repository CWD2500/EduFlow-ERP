@extends('layouts.admin.admin')


@section('content')
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
                            <h3 class="fw-bold mb-3 myTitleStudentsPrint"> الطلاب </h3>
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
                                    <a href="#"> الطلاب </a>
                                </li>
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#">الرئيسية</a>
                                </li>
                            </ul>

                        </div>
                  
                        <button class="mybtnPrint" onclick="window.print()"> طباعة</button>
                        <br><br>





                        <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="">
                                    <div class="image-profile-student">
                                        <div class="col-md-6 col-lg-6">
                                        {{-- <img src="{{ asset('img/pexels-andy-barbour-6683440.jpg') }}" alt=""> --}}
                                        </div>
                                    
                                    </div>

                                    <div class="title-student">
                                       
                                            <h4>  الجمهورية العربية السورية   </h4>
                                            <h6>   المعهد التقاني لتقنيات الحاسوب   </h6>
                                   
                                    </div>
                                    <div class="info-student">
                                        <div class="row">
                                        <div class="col-md-6">
                                            <h5> الاسم :   <b> {{$student_id->name}}  </b>   </h5>
                                            <h5> النسبة : <b>{{$student_id->ratio}} </b>  </h5>
                                            <h5> اسم الأب  : <b> {{$student_id->father}} </b>   </h5>

                                            <h5> وظيفة الأب :    <b>  {{$student_id->father_job}} </b> </h5>
                                            <h5> اسم الأم :  <b> {{$student_id->mother}}  </b> </h5>
                                            <h5> مكان ورقم التسجيل : <b>  {{$student_id->place_and_number_of_registration}}  </b>  </h5>
                                            <h5> مكان الميلاد :  <b> {{$student_id->place_of_birth}} </b> </h5>
                                            <h5> مكان الحصول على الشهادة :  <b>   {{$student_id->place_Get_the_certificate}} </b> </h5>
                                            <h5> المجموع :  <b>   {{$student_id->total}}  </b> </h5>
                                            <h5> الديانة :  <b>   {{$student_id->religion}} </b> </h5>
                                            <h5> المدينة :  <b> {{$student_id->city}} </b> </h5>
                                            <h5> الجنس : <b>  {{$student_id->gender}} </b>  </h5>
                                            <h5> اللغة :  <b> {{$student_id->language}} </b> </h5>
                                            <h5> الدورة الامتحانية : <b>   {{$student_id->exam_session}} </b>  </h5>
                                        </div>
                                        <div class="col-md-6">
                                          
                                
                         
                                     
                                            <h5> المدرسة :  <b>   {{$student_id->teacher}}  </b> </h5>
                                            <h5> الأسرة :  <b>  {{$student_id->family}}  </b> </h5>
                                            <h5> شعبة التجنيد : <b> {{$student_id->recruitment_division}}  </b>   </h5>
                                            <h5> الرقم الوطني : <b>  {{$student_id->national_number}} </b>  </h5>
                                            <h5> تاريخ الميلاد : <b>  {{$student_id->date_of_birth}}   </b>  </h5>
                                            <h5> رقم الجوال :  <b>  {{$student_id->mobile_phone_number}}  </b> </h5>
                                           
                                            <h5> رقم الهاتف الأرضي :  <b> {{$student_id->landline_number}}  </b> </h5>
                                            <h5> العنوان التفصيلي: <b > {{$student_id->detailed_address}}  </b>  </h5>
                                            <h5> تاريخ التسجيل: <b>    {{$student_id->date_of_registration}}  </b>   </h5>
                                  
                                          
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>







                        {{-- <div  class="row" >

                            <div class="card-student row1" >

                              <div class="student-image-info-container col1">
                                <div class="student-image between row1">
                                    <div class="image">
                                        <img src="{{ asset('img/pexels-andy-barbour-6683440.jpg') }}" alt="">
                                    </div>
                                    <p>الجمهورية العربية السورية</p>
                                </div>
                                <div class="student-info">
                                    <p >الاسم: <b> محمد سليمان</b></p>
                                    <p>الاسم: محمد سليمان</p>
                                    <p>الاسم: محمد سليمان</p>
                                    <p>الاسم: محمد سليمان</p>
                                </div>
                              </div>

                              <div class="student-center-card-container between col1">
                                <div class="center-name col1">
                                    <p>وزارة التربية</p>
                                    <p>المعهد المتوسط التقاني لتفنيات الحاسوب</p>
                                </div>
                                <div class="between col1 center">
                                    <div class="center-image"></div>
                                    <div class="card-name">
                                        بطافة الطالب
                                    </div>
                                </div>
                              </div>

                            </div>

                        </div> --}}


                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Custom template | don't include it in your project! -->
    @include('layouts.admin.settings')
    <!-- End Custom template -->
@endsection
