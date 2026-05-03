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
                <h3 class="fw-bold mb-3">المواد الدراسية</h3>
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
                        <a href="{{ route('dashBoard.subject.home') }}">المواد الدراسية</a>
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
                <div class="col-sm-12 col-md-6" style="display: flex;flex-direction: row;justify-content: end;">
                    <h1 class="text-right">
                        <a href="{{ route('dashBoard.subject.create') }}" class="btn btn-outline-primary w-100">إنشاء</a>
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
                            <thead class="table-dark text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">اسم المادة</th>
                                    <th scope="col">الاختصاص</th>
                                    <th scope="col">السنة الدراسية</th>
                                    <th scope="col">الفصل الدراسي</th>
                                    <th scope="col">نوع المواد</th>
                                    <th scope="col">الحدث</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider" style="color: black;font-size: 20px;font-weight: 800;font-family: 'Times New Roman', Times, serif">
                                @foreach ($subjects as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if ($item->specializations->isEmpty())
                                            لا يوجد اختصاصات مرتبطة
                                        @else
                                            <ul>
                                                @foreach ($item->specializations as $specialization)
                                                    <li class="list-unstyled">{{ $specialization->name }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>{{ $item->year }}</td>
                                    <td>{{ $item->semester }}</td>
                                    <td>
                                        <ul>
                                            <li>    {!! nl2br(e($item->subject_sep)) !!}   </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashBoard.subject.destroy', [$item->id]) }}" class="btn btn-outline-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a href="{{ route('dashBoard.subject.edit', [$item->id]) }}" class="btn btn-outline-success">
                                            <i class="fa fa-edit"></i>
                                        </a>
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
                url: "{{ route('filtersubject') }}",
                method: "GET",
                data: { query: query },
                success: function(response) {
                    let tableRows = '';

                    response.forEach(function(subject, index){
                        let specializationsContent = '';

                        if (subject.specializations.length === 0) {
                            specializationsContent = 'لا يوجد اختصاصات مرتبطة';
                        } else {
                            specializationsContent = '<ul>';
                            subject.specializations.forEach(function(specialization) {
                                specializationsContent += `<li class="list-unstyled">${specialization.name}</li>`;
                            });
                            specializationsContent += '</ul>';
                        }

                        tableRows += `
                            <tr>
                                <th scope="row">${index + 1}</th>
                                <td>${subject.name}</td>
                                <td>${specializationsContent}</td>
                                <td>${subject.year}</td>
                                <td>${subject.semester}</td>
                                <td>${subject.subject_sep}</td>
                                <td class="text-center">
                                    <a href="{{ route('dashBoard.subject.destroy', '') }}/${subject.id}" class="btn btn-outline-danger w-25">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="{{ route('dashBoard.subject.edit', '') }}/${subject.id}" class="btn btn-outline-success w-25">
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
