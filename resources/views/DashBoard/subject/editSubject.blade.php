@extends('layouts.admin.admin')

<?php  
$semester = ["الفصل الثاني", "الفصل الاول"];
$subject_sep = ["المواد العملي", "المواد النظري"];
$year = ["السنة الاولى", "السنة الثانية"];

?>


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
                    <h3 class="fw-bold mb-3">المواد الدراسية </h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                            <a href="{{ route('dashBoard.subject.home') }}">
                                <i class="icon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashBoard.subject.home') }}">المواد الدراسية </a>
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
                                    <form action="{{ route('dashBoard.subject.update'  , [$subject->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-6 col-lg-12">
                                         <div class="form-group">
                                                <p for="#name" style="font-size: 20px">  اسم المادة الدراسية   </p>
                                                <input type="text" class="form-control"  name="name" id="#name"placeholder=" أدخل الاسم...."  value="{{ $subject->name }}"  required />
                                            </div>




                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="year" value="<?php echo $year[1]; ?>" id="flexRadioDefault6" {{ $subject->year == $year[1] ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="flexRadioDefault6">
                                                           السنة الثانية
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="year" value="<?php echo $year[0]; ?>" id="flexRadioDefault7" {{ $subject->year == $year[0] ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="flexRadioDefault7">
                                                          السنة الاولى
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
    
                                   

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="semester" value="{{$semester[0]}}" id="flexRadioDefault1"  {{ $subject->semester == $semester[0] ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            الفصل الثاني
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="semester" value="{{$semester[1]}}" id="flexRadioDefault2" {{ $subject->semester == $semester[1] ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            الفصل الاول
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                         
    
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="subject_sep[]" value="{{$subject_sep[0]}}" id="flexRadioDefault3" 
                                                        {{ in_array($subject_sep[0], explode("\n", $subject->subject_sep)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexRadioDefault3">
                                                            المواد النظري
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="subject_sep[]" value="{{$subject_sep[1]}}" id="flexRadioDefault4" 
                                                        {{ in_array($subject_sep[1], explode("\n", $subject->subject_sep)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexRadioDefault4">
                                                            المواد العملي 
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    
                                            <select class="form-select"  name="specializations[]" multiple aria-label="Multiple select example">
                                                @foreach ($specializations as $item)
                                                <option value="{{ $item->id }}" {{ in_array($item->id, $selectedSpecializations) ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                              </select>

                                      
    
                                            <div class="form-group">
                                                
                                                <button type="submit" class="mybtn w-100">  تحديث  </button>
                                               
                                                <a href="{{ route('dashBoard.subject.home') }}" class=" mt-2 ">
                                                <button type="button" class="mybtnBack mt-3 w-100">  
                                                  صفحة المواد الدراسية    
                                                 
                                                </button>

                                            </a>

                                            
                                            </div>
                                        </div>
                                    </form>
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
