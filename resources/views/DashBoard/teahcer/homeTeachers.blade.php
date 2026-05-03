@extends('layouts.admin.admin')

@section('content')

<?php $i = 0; $i+=1; ?>
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
                        <h3 class="fw-bold mb-3">المدرسين</h3>
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
                                <a href="{{ route('dashBoard.teacher.home') }}">المدرسين</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">الرئيسية</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="subjects-form-search">
                                <input type="text" id="query" name="query" class="form-control search" placeholder="search...">
                                <button type="submit" class="btn btn-search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-12 col-md-6" style="display: flex; flex-direction: row; justify-content: end;">
                            <h1 class="text-right">
                                <a href="{{ route('dashBoard.teacher.create') }}" class="btn btn-outline-primary w-100">أنشاء</a>
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container mt-3">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <table class="table" id="users-table">
                                    <thead class="table-dark text-white" >
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">الاختصاص</th>
                                            <th scope="col">اسم المدرس</th>
                                            <th scope="col">الفصل الدراسي</th>
                                            <th scope="col">المواد المسؤولة</th>
                                            <th scope="col">السنة الدراسية</th>
                                            <th scope="col">الحدث</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider" style="color: black; font-size: 20px; font-weight: 800; font-family: 'Times New Roman', Times, serif">
                                        @php $i = 1; @endphp
                                        @foreach ($teachers as $teacher)
                                            <tr>
                                                <td scope="row">{{ $i++ }}</td>
                                                <td>{{ $teacher->specializations_id ?? 'N/A' }}</td>
                                                <td>{{ $teacher->name }}</td>
                                                <td>{{ $teacher->semester ?? 'N/A' }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($teacher->subjects as $subject)
                                                            <li>{{ $subject->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ $teacher->subject_yeare }}</td>
                                                <td>
                                                    <a href="{{ route('dashBoard.teacher.destroy', [$teacher->id]) }}" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
                                                    <a href="{{ route('dashBoard.teacher.edit', [$teacher->id]) }}" class="btn btn-outline-success"><i class="fa fa-edit"></i></a>
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
</div>

<!-- Custom template | don't include it in your project! -->
@include('layouts.admin.settings')
<!-- End Custom template -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#subjects-form-search').on('submit', function(e){
            e.preventDefault();

            let query = $('#query').val();

            $.ajax({
                url: "{{ route('filterteacher') }}",
                method: "GET",
                data: { query: query },
                success: function(response) {
                    let tableRows = '';

                    response.forEach(function(teacher, index){
                        let subjectsContent = '';

                        if (teacher.subjects.length === 0) {
                            subjectsContent = 'لا يوجد مواد';
                        } else {
                            subjectsContent = '<ul>';
                            teacher.subjects.forEach(function(subject) {
                                subjectsContent += `<li class="list-unstyled">${subject.name}</li>`;
                            });
                            subjectsContent += '</ul>';
                        }

                        tableRows += `
                            <tr>
                                <th scope="row">${index + 1}</th>
                                <td>${teacher.specializations_id}</td>
                                <td>${teacher.name}</td>
                                <td>${teacher.semester ?? 'N/A'}</td>
                                <td>${subjectsContent}</td>
                                <td>${teacher.subject_yeare ?? 'N/A'}</td>
                                
                                <td class="text-center">
                                    <a href="{{ route('dashBoard.teacher.destroy', '') }}/${teacher.id}" class="btn btn-outline-danger w-25">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="{{ route('dashBoard.teacher.edit', '') }}/${teacher.id}" class="btn btn-outline-success w-25">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>`;
                    });

                    $('#users-table tbody').html(tableRows);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


@endsection
