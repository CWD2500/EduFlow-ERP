<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة النتائج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            font-size: 36px;
            color: #343a40;
            margin-bottom: 20px;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
  
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-oops {
            background: linear-gradient(149deg, #ff4b00, #5e2b2b);
            color: white;
            padding: 10px;
            width: 76px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            transition: transform .2s; /* Animation */ 
        }
        .btn-oops:hover {
            transform: scale(1.1); 
        }

        .btn-oops:active {
            transform: scale(1.2);
        }

        .message-success {
            background-color: #28a745;
            color: white;
            padding: 0px;
            border-radius: 8px;
            font-weight: bold;
            position: relative;
            top: 8px;
            display: none; /* Initially hidden */
        }
      
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">النتائج</h2>
        <div class="table-container">
            <p class="text-center"><b> الاسم : {{$user_student->name}} &nbsp; &nbsp;&nbsp;&nbsp;  الاختصاص : {{$user_student->specializations_id}} &nbsp;&nbsp;&nbsp;  الرقم الجامعي : {{$user_student->student_id}} </b> </p>
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>اسم المادة</th>
                        <th>درجة الأعمال ن</th>
                        <th>درجة الأعمال م</th>
                        <th>دمج الأعمال</th>
                        <th>امتحان ن</th>
                        <th>امتحان ع</th>
                        <th>دمج امتحان</th>
                        <th>الدرجة النهائية</th>
                        <th>النتيجة</th>
                        <th>الاعتراض</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                    @if ($exam->academic_year ==request()->get('selectYear'))
                        
                   
                    @php
                        $total_works = $exam->degree_n + $exam->degree_p;
                        $total_exam = $exam->exam_n + $exam->exam_p;
                        $final_grade = $total_works + $total_exam;
                        $result = ($final_grade < 60) ? "راسب" : "ناجح";
                    @endphp
                    <tr>
                        <td>{{ $exam->subject_id }}</td>
                        <td>{{ $exam->degree_n }}</td>
                        <td>{{ $exam->degree_p }}</td>
                        
                        {{-- @if ($total_works < 24)
                            <td style="background-color: red; color: white; border: 1px solid white; font-size: 18px; font-weight: 700;">
                                {{ $total_works }}
                            </td>
                        @else
                            <td style="background-color: #15a715; color: white; border: 1px solid white; font-size: 18px; font-weight: 700;">
                                {{ $total_works }}
                            </td>
                        @endif --}}
                        <td>{{ $total_works }}</td>
                        <td>{{ $exam->exam_n }}</td>
                        <td>{{ $exam->exam_p }}</td>
                        <td>{{ $total_exam }}</td>
                        <td>{{ $final_grade }}</td>

                        @if ($result == "راسب")
                            <td style="background-color: red; color: white; border: 1px solid white; font-size: 18px; font-weight: 700;">
                                {{ $result }}
                            </td>
                        @else
                            <td style="background-color: #15a715; color: white; border: 1px solid white; font-size: 18px; font-weight: 700;">
                                {{ $result }}
                            </td>
                        @endif

                        <td>
                            <button id="objection-btn-{{ $exam->id }}" class="btn-oops" onclick="submitObjection('{{ $user_student->student_id }}', '{{ $exam->id }}', '{{ $exam->subject_id }}')">اعترض</button>
                            <p id="objection-success-{{ $exam->id }}" class="message-success">  تم إرسال الاعتراض بنجاح راجع قسم الامتحانات</p>
                            <p id="objection-error-{{ $exam->id }}" class="message-error" style="display:none;color: #000;font-size: 13px;font-weight: 700;">لقد قمت بإرسال اعتراض على هذه المادة مسبقًا!</p>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
    function submitObjection(studentId, examId, subjectId) {
        const message = "تم الارسال بنجاح";
        fetch('/submit-objection', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                student_id: studentId,
                exam_id: examId,
                subject_id: subjectId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.previousObjection) {
                // عرض رسالة وجود اعتراض سابق
                document.getElementById('objection-error-' + examId).style.display = 'block';
                document.getElementById('objection-btn-' + examId).style.display = 'none';
            } else {
                if (data.success) {
                    // عرض رسالة التأكيد بنجاح الإرسال
                    document.getElementById('objection-success-' + examId).style.display = 'block';
                    // إخفاء الزر بعد النجاح
                    document.getElementById('objection-btn-' + examId).style.display = 'none';
                } else {
                    alert('حدث خطأ أثناء إرسال الاعتراض');
                }
            }
        })
        .catch(error => {
            alert('حدث خطأ أثناء إرسال الاعتراض');
            console.error('Error:', error);
        });
    }
    </script>
</body>
</html>
