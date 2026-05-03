@extends('layouts.admin.admin')


@section('content')
    <!-- Sidebar -->
    @include('layouts.admin.Sidebar')
    <!-- End Sidebar -->


<style>
    form{}
</style>
    <?php  
    $semester = ["الفصل الثاني", "الفصل الاول"];
     
    $year = ["السنة الاولى", "السنة الثانية"];
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
                                    <form action="{{ route('dashBoard.subject.store') }}" method="POST">
                                        @csrf
                                        <div class="col-md-6 col-lg-12">
                                            <div class="form-group">
                                                <p for="#name" style="font-size: 20px">  اسم المادة الدراسية   </p>
                                                <input type="text" class="form-control"  name="name" id="#name"placeholder=" أدخل الاسم...."  value="{{ old('name') }}"  required />
                                            </div>
                                            



                                            
                                          <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="year" value="<?php echo $year[1]; ?>" id="flexRadioDefault1">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                       السنة الثانية
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="year" value="<?php echo $year[0]; ?>" id="flexRadioDefault2" checked>
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                      السنة الاولى
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                          <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="semester" value="<?php echo $semester[0]; ?>" id="flexRadioDefault1">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        الفصل الثاني
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="semester" value="<?php echo $semester[1]; ?>" id="flexRadioDefault2" checked>
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        الفصل الاول
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subject_sep[]" value="المواد النظري" id="subjectTheoretical" {{ in_array('المواد النظري', old('subject_sep', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="subjectTheoretical">
                                                        المواد النظري
                                                    </label>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subject_sep[]" value="المواد العملي" id="subjectPractical" {{ in_array('المواد العملي', old('subject_sep', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="subjectPractical">
                                                        المواد العملي
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                            <select class="form-select"  name="specializations[]" multiple aria-label="Multiple select example">
                                                @foreach ($specialization as $item )
                                                    <option  value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                              </select>

                                      
    
                                            <div class="form-group">
                                                
                                                <button type="submit" class="mybtn w-100">  انشاء  </button>
                                               
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
