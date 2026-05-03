@extends('layouts.admin.admin')


@section('content')

<?php
    $i = 0;
    $i+=1;
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
                            <h3 class="fw-bold mb-3">  الطلاب </h3>
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
                                    <a href="#">  قسم الصيانة  </a>
                                </li>
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#">السنة الثاني </a>
                                </li>
                            </ul>
                            
                        </div>
                       <div class="row">
                        <div class="col-md-6">
                            <form id="student-form-search">
                                <input type="text"  id="query" name="query" class="form-control search"  placeholder="search...">
                            <button type="submit" class="btn   btn-search" >  
                                <i class="fa fa-search"></i>    
                            </button>
                            </form>
                        </div>

                        <div class="container mt-3">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                        <div class="card mt-3" >
                          <table class="table text-center"  id="users-table">
                            <thead class="">
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">الرقم الجامعي</th>
                                <th scope="col">اسم الطالب </th>
                                <th scope="col">اسم الاب</th>
                                <th scope="col">اسم الام</th>
                                <th scope="col"> تاريخ التسجيل</th>
                                <th scope="col"> الحدث </th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($student as $students)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{$students->student_id}}</td>
                                    <td>{{$students->student_name}}</td>
                                    <td>{{$students->users->father}}</td>
                                    <td>{{$students->users->mother}}</td>
                                    <td>{{$students->users->date_of_registration}}</td>
                                    <td class="text-center">
                                                
                                        <a href="{{ route('dashBoard.student.deleteStudentTwo', [$students->id]) }}" class="btn btn-outline-danger w-25"> <i class="fa fa-trash"></i> </a>
                                        <a href="{{ route('dashBoard.student.edit', [$students->id]) }} " class="btn btn-outline-success w-25"> <i class="fa fa-edit"></i> </a>
                                        <a href="{{ route('dashBoard.showStudentTwostudent_name.show', [$students->id]) }}" class="btn btn-outline-primary w-25"> <i class="fa fa-eye"></i> </a>
                                    </td>
                                </tr>
                              @endforeach
                     
                            </tbody>
                          </table>
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

    <script>
        $(document).ready(function(){
            $('#student-form-search').on('submit', function(e){
                e.preventDefault();
    
                let query = $('#query').val();
    
                $.ajax({
                    url: "{{ route('filterTwoMain') }}",
                    method: "GET",
                    data: { query: query },
                    success: function(response) {
                        let tableRows = '';
    
                        response.forEach(function(student, index){
                            tableRows += `
                                <tr>
                                    <th scope="row">${index + 1}</th>
                                    <td>${student.student_id}</td>
                                    <td>${student.student_name}</td>
                                    <td>${student.father}</td>
                                    <td>${student.mother}</td>
                                    <td>${student.date_of_registration}</td>
                                    <td class="text-center">
                                        <a href="{{ route('dashBoard.student.deleteTrash', '') }}/${student.id}" class="btn btn-outline-danger w-25">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a href="{{ route('dashBoard.student.edit', '') }}/${student.id}" class="btn btn-outline-success w-25">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('dashBoard.student.show', '') }}/${student.id}" class="btn btn-outline-primary w-25">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>`;
                        });
    
                        $('#users-table tbody').html(tableRows);
                    }
                });
            });
        });
    </script>
@endsection
