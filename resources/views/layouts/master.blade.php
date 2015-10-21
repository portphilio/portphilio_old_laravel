<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title')::Portphilio::A Web-Based Portfolio Management System</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css">
	</head>
	<body>
		<header>
			<h1>Portphilio</h1>
			<nav>@yield('nav')</nav>
		</header>
		<main>
			@yield('main')
		</main>
		<aside>
			@yield('sidebar')
		</aside>
		<footer>
		</footer>
	</body>
</html>