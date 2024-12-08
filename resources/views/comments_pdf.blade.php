<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bramming Efterskole - Kommentarer til {{$name}}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #222;
            margin-bottom: 20px;
        }
        .profile {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #3532c9;
        }
        .comments-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        ul {
            padding: 0;
            list-style: none;
            margin: 0;
        }
        li {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        li:last-child {
            border-bottom: none;
        }
        .comment-number {
            font-weight: bold;
            background-color: #3532c9;
            color: white;
            width: 30px;
            height: 30px;
            display: inline-block;
            text-align: center;
            line-height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            vertical-align: middle;
        }
        .comment-text {
            display: inline-block;
            font-size: 16px;
            vertical-align: middle;
        }
        .header {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000; /* Ensure it stays above other content */
        }
        .org img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .content {
            margin-top: 20px; /* Pushes the content below the header */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="org">
            <img src="{{ $logo }}">
        </div>
    </div>
    <div class="content">
        <div class="profile">
            <img src="{{ $profilePicture }}">
        </div>
        <div class="comments-container">
            <ul>
                @foreach ($comments as $index => $comment)
                    <li>
                        <span class="comment-number">{{ $index + 1 }}</span>
                        <span class="comment-text">{{ $comment }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
