<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix("/css/app.css") }} ">
    <link rel="stylesheet" href="{{ mix("/css/theme.css") }} ">
    
    <title>laravel course</title>
</head>

<body>
<nav class="navbar navbar-expand navbar-dark bg-success">
    <ul class="nav navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href=" {{ route('posts.index') }} ">Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href=" {{ route('posts.create') }} ">Add New Posts</a>
        </li>
    </ul>
</nav>


   <!-- <ul class="nave">-->
       
        <!-- forme of the href unprofessoinal -->
     <!--   <a href="/home">
            <li>Home</li>
        </a>
        <a href="  ">
            <li>Posts</li>
        </a>
        <a href="  ">
            <li>Add New Posts</li>
        </a>
    </ul>
-->
<div class="container">


    @yield('content')
</div>

    
</body>

</html>
