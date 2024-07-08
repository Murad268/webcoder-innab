<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

@include('layouts.includes.head')
<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<x-admin-header-component/>

<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    @yield('content')
    <x-admin-footer-component/>
    @include('layouts.includes.foot')
</div>
</body>
</html>
