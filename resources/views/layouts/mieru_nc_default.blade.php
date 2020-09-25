<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">
	<script src ="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.0.js"></script>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('/css/mieru_styles.css') }}">

</head>
<body>
    <header class="sticky-top">
	<nav class="navbar navbar-expand-sm navbar-light">
		<a href="{{ route('mieru.ncs.index') }}" class="navbar-brand nav-element">機械加工</a>
		<button class="navbar-toggler" type="button"
		data-toggle="collapse"
		data-target="#navmenu1"
		aria-controls="navmenu1"
		aria-expanded="false"
		aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navmenu1">
			<div class="navbar-nav">
				
				<a class="nav-item nav-link" href="http://localhost/kobayashi_mieru/text/minutes/memo.html" target=”_blank” >メモ</a>
				<a class="nav-item nav-link" href="{{ url('/') }}" >HOME</a>
			</div>
		</div>
	</nav>
</header>

    @yield('content')


<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{asset('/js/mieru_main.js')}}"></script>
<script type="text/javascript">
    $(function(){
         $('[data-toggle="tooltip"]').tooltip()
    })
</script>

    </body>
</html>
