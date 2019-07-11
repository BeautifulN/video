<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>视频展示</h2>
    <hr>
        <table border="1">
            <tr>
                <td>ID</td>
                <td>标题</td>
                <td>视频</td>
            </tr>
            @foreach($arr as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td><a href="content?id={{$v->id}}">{{$v->title}}</a></td>
                <td>{{$v->path}}</td>
            </tr>
            @endforeach
        </table>
</body>
</html>