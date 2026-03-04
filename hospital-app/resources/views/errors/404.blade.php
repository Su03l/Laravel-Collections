<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة غير موجودة - 404</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #0a0a0a; /* أسود داكن جداً */
            color: #e0e0e0; /* أبيض هادئ */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 40px;
            border: 1px solid #333; /* إطار خفيف */
            border-radius: 0; /* حواف حادة للاحترافية */
            background: radial-gradient(circle at center, #111 0%, #000 100%);
            box-shadow: 0 0 50px rgba(255, 255, 255, 0.05);
        }

        h1 {
            font-size: 120px;
            font-weight: 900;
            letter-spacing: 10px;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 2px 2px 0px #333;
        }

        h2 {
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 20px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            background-color: #fff;
            color: #000;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: 1px solid #fff;
            text-transform: uppercase;
        }

        .btn:hover {
            background-color: #000;
            color: #fff;
            cursor: pointer;
        }

        .divider {
            width: 50px;
            height: 2px;
            background-color: #333;
            margin: 20px auto;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>404</h1>
        <div class="divider"></div>
        <h2>الصفحة غير موجودة</h2>
        <p>
            يبدو أنك ضللت الطريق في أروقة النظام. <br>
            الرابط الذي تحاول الوصول إليه غير متاح أو تم نقله.
        </p>
        <a href="{{ url('/') }}" class="btn">العودة للرئيسية</a>
    </div>

</body>
</html>
