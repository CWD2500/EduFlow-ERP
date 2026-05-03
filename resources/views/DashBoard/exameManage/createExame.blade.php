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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">    قسم الانشاء   </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-12">
                                        <div class="form-group">
                                            <p for="title" style="font-size: 20px">  الاسم   </p>
                                            <input type="text" class="form-control" id="email2"placeholder=" أدخل الاسم....   " />
                                         
                                        </div>

                                        <div class="form-group mb-3">
                                            <p for="user_id" class="form-label" style="font-size: 20px">المدرس المسؤول</p>
                                            <select class="form-control" id="user_id" name="user_id" required>
                                                <!-- الخيارات تأتي من قاعدة البيانات -->
                                                <option value="1">أ. محمد</option>
                                                <option value="2">أ. علي</option>
                                                <!-- المزيد من المدرسين -->
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <p for="subject_id" class="form-label" style="font-size: 20px">المادة الدراسية</p>
                                            <select class="form-control" id="subject_id" name="subject_id" required>
                                                <!-- الخيارات تأتي من قاعدة البيانات -->
                                                <option value="1">الرياضيات</option>
                                                <option value="2">العلوم</option>
                                                <!-- المزيد من المواد -->
                                            </select>
                                        </div>


                                        <div class="form-group mb-3">
                                            <p for="exam_date" class="form-label" style="font-size: 20px">تاريخ الامتحان</p>
                                            <input type="datetime-local" class="form-control" id="exam_date" name="exam_date" required>
                                        </div>

                                 

                                        <div class="form-group mb-3">
                                            <p for="description" class="form-label" style="font-size: 20px">وصف الامتحان</p>
                                            <textarea class="form-control" id="description" name="description" rows="3" cols="8" required></textarea>
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="mybtn w-100">  انشاء  </button>
                                        </div>

                                        
                                    </div>
                                </div>
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
