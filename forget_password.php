<!DOCTYPE html>
/**quên mật khẩu **/
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }


        label {
            display: block;
            margin-bottom: 5px;
        }

        
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            display: block;
            transition: background-color 0.3s ease;
            text-decoration: none; /* Remove underline from link */
            text-align: center;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quên mật khẩu</h1>
        <form action="send_verification_code.php" method="post">
            <label for="email">Nhập địa chỉ email của bạn:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Gửi mã xác nhận</button>
        </form>
    </div>
</body>
</html>
