@extends('layouts.admin.admin')

@section('content')

<?php  
   $teacher = ["الفصل الثاني", "الفصل الاول"];
   $subject_yeare = ["السنة الثانية", "السنة الاولى"];
   $subject_sep = [" عملي", "نظري"];
 
//    $specialization = ["البرمجة", "الشبكات" ,"الصيانة"];
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
                <div class="page-header">
                    <h3 class="fw-bold mb-3">الطلاب</h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                            <a href="{{ route('dashBoard.teacher.home') }}">
                                <i class="icon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashBoard.teacher.home') }}">  المدرسين </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">الإنشاء</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="container mt-3">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif




                        @if ($errors->count() > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif

                    </div> 
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">قسم الإنشاء</div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dashBoard.teacher.store') }}" method="POST" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="specialization" style="font-size: 20px">الاختصاص</label>
                                                <select class="form-control" name="specializations_id" id="specialization" required>
                                                    <option value="">اختر الاختصاص</option>
                                                    @foreach ($specializations_student as $specialization)
                                                        <option value="{{ $specialization->name }}">{{ $specialization->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <p for="name" style="font-size: 20px">  الاسم  المهندس </p>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="أدخل الاسم..." required />
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="semester" value="<?php echo $teacher[0]; ?>" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    الفصل الثاني
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="semester" value="<?php echo $teacher[1]; ?>" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    الفصل الاول
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name=" subject_sep" value="<?php echo $subject_sep[0]; ?>" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    عملي 
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name=" subject_sep" value="<?php echo $subject_sep[1]; ?>" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                نظري
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                            
                            
                            
                            
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="subject_yeare" value="<?php echo $subject_yeare[0]; ?>" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                   السنة الثانية
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="subject_yeare" value="<?php echo $subject_yeare[1]; ?>" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                   السنة الاولى
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                        


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h6>  قسم البرمجة   </h6>
                                                <select class="form-select"  name="subjects[]" multiple aria-label="Multiple select example">
                                                    @foreach ($subject_programming as $item )
                                                        <option  value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                  </select>
                                            </div>
                                        </div>


                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h6> قسم الشبكات </h6>
                                                <select class="form-select"  name="subjects[]" multiple aria-label="Multiple select example">
                                                    @foreach ($subject_networking as $item )
                                                        <option  value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                  </select>
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h6>  قسم الصيانة  </h6>
                                                <select class="form-select"  name="subjects[]" multiple aria-label="Multiple select example">
                                                    @foreach ($subject_main as $item )
                                                        <option  value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                  </select>
                                            </div>
                                        </div>
                                    
                                    
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="mybtn w-100">إنشاء</button>
                                        <a href="{{ route('dashBoard.teacher.home') }}" class="mt-2">
                                            <button type="button" class="mybtnBack mt-3 w-100">
                                                صفحة المدرسين
                                            </button>
                                        </a>
                                    </div>
                                </form>
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
