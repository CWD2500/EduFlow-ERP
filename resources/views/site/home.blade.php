<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f9;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .row {
            display: flex;
            justify-content: center;
            align-content: center;
            margin: 0 auto;
            border: 2px solid #ffffff;
            width: 50vw;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0px 0px 33px 3px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
        }

        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .marquee-container {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            margin-bottom: 30px;
            border-radius: 5px;
            text-align: center;
        }

        .marquee-container b {
            font-size: 24px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn {
            border-radius: 10px;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="marquee-container">
            <marquee direction="left" scrollamount="3"> <b>المعهد التقاني لتقنيات الحاسوب ترحب بكم</b> </marquee>
        </div>

        <div class="row" style="direction: rtl">
            <div style="text-align: center; margin-top: -20px;">
                <i class="fas fa-user-graduate" style="color: #007bff; font-size: 5em;"></i>
            </div>
            <form action="{{ route('login') }}" method="get">
                @method('GET')
                @csrf
                <div class="form-group">
                    <label for="selectYearStudent" class="form-label">اختر السنة الدراسية</label>
                    <select name="selectYear" id="selectYearStudent" class="form-control">
                        <option value="السنة الاولى">السنة الاولى</option>
                        <option value="السنة الثاني">السنة الثانية</option>
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="semesterStudent" class="form-label">اختر الفصل الدراسي</label>
                    <select name="semesterStudent" id="semesterStudent" class="form-control">
                        <option value="الفصل الاول">الفصل الاول</option>
                        <option value="الفصل الثاني">الفصل الثاني</option>
                    </select>
                </div>

                <div class="form-group mt-1">
                    <label for="student_id" class="form-label">الرقم الجامعي:</label>
                    <input type="text" id="student_id" name="student_id" class="form-control mt-1 w-100">
                    @error('student_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-1">
                    <label for="name" class="form-label">الاسم:</label>
                    <input type="text" id="name" name="name" class="form-control mt-1">
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-outline-primary mt-4 w-100">تسجيل الدخول</button>
            </form>
        </div>
    </div>
</body>

</html>
