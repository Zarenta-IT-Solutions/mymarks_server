<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="shortcut icon" href="https://mymarks.in/assets/img/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="https://mymarks.in/assets/img/apple-icon.png" />
    <link rel="stylesheet" href="https://mymarks.in/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="https://mymarks.in/assets/styles/tailwind.css" />
    <title>{{config('app.name')}} - @yield('TITLE')</title>
    @yield('style')
</head>

<body class="text-gray-800 antialiased">
<noscript>You need to enable JavaScript to run this app.</noscript>
<div id="root">
    <nav class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-no-wrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
        <div class="md:flex-col md:items-stretch md:min-h-full md:flex-no-wrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
            <button class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" type="button" onclick="toggleNavbar('example-collapse-sidebar')"> <i class="fas fa-bars"></i> </button> <a class="md:block text-left md:pb-2 text-gray-700 mr-0 inline-block whitespace-no-wrap text-sm uppercase font-bold p-4 px-0" href="{{route('admin.dashboard')}}"> {{config('app.name')}} </a>
            <ul class="md:hidden items-center flex flex-wrap list-none">
                <li class="inline-block relative"> <a class="text-gray-600 block py-1 px-3" href="#pablo" onclick="openDropdown(event,'notification-dropdown')"><i class="fas fa-bell"></i></a>
                    <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="notification-dropdown">
                        <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800">Notification 1</a>
                        <div class="h-0 my-2 border border-solid border-gray-200"></div>
                        <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800">Notification 2</a>
                    </div>
                </li>
                <li class="inline-block relative">
                    <a class="text-gray-600 block"  onclick="openDropdown(event,'user-responsive-dropdown')">
                        <div class="items-center flex">
                           <span class="w-12 h-12 text-sm text-white bg-gray-300 inline-flex items-center justify-center rounded-full" >
                               <img alt="" class="w-full rounded-full align-middle border-none shadow-lg" src="{{asset('assets/img/team-1-800x800.jpg')}}"/>
                           </span>
                        </div>
                    </a>
                    <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="user-responsive-dropdown">
{{--                        <a href="{{ route('profile.show') }}" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800">{{ __('Profile') }}</a>--}}
                        <div class="h-0 my-2 border border-solid border-gray-200"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                        <a href="#pablo" onclick="event.preventDefault(); this.closest('form').submit();" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800">{{ __('Logout') }}</a>
                        </form>
                    </div>
                </li>
            </ul>
            <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden" id="example-collapse-sidebar">
                <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-gray-300">
                    <div class="flex flex-wrap">
                        <div class="w-6/12">
                            <a class="md:block text-left md:pb-2 text-gray-700 mr-0 inline-block whitespace-no-wrap text-sm uppercase font-bold p-4 px-0" href="{{route('admin.dashboard')}}">{{config('app.name')}}</a> </div>
                        <div class="w-6/12 flex justify-end">
                            <button type="button" class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" onclick="toggleNavbar('example-collapse-sidebar')"> <i class="fas fa-times"></i> </button>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                @include('layouts.admin.navigation')

            </div>
        </div>
    </nav>
    <div class="relative md:ml-64 bg-gray-100">
        <nav class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-no-wrap md:justify-start flex items-center p-4">
            <div class="w-full mx-autp items-center flex justify-between md:flex-no-wrap flex-wrap md:px-10 px-4">
                <a class="text-white text-sm uppercase hidden lg:inline-block font-semibold">@yield('TITLE')</a>

                <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
                    <a class="text-gray-600 block" href="#pablo" onclick="openDropdown(event,'user-dropdown')">
                        <div class="items-center flex">
                           <span class="w-12 h-12 text-sm text-white bg-gray-300 inline-flex items-center justify-center rounded-full">
                               <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="{{asset('assets/img/team-1-800x800.jpg')}}"/>
                           </span>
                        </div>
                    </a>
                    <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="user-dropdown">
{{--                        <a href="{{ route('profile.show') }}" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800">Profile</a>--}}
                        <div class="h-0 my-2 border border-solid border-gray-200"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a  onclick="event.preventDefault(); this.closest('form').submit();" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800">Logout</a>
                        </form>
                    </div>
                </ul>
            </div>
        </nav>
        <!-- Header -->
        <div class="relative bg-pink-600  pb-32 pt-12">
            <div class="px-4 md:px-10 mx-auto w-full">
                <div>
                   @yield('header')
                    @include('flash::message')
                </div>
            </div>
        </div>
        <div class="px-4 md:px-10 mx-auto w-full -m-24">

            @yield('content')

            @include('layouts.admin.footer-admin')

        </div>
    </div>
</div>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
<script>
    function openDropdown(event, dropdownID) {
        let element = event.target;
        while (element.nodeName !== "A") {
            element = element.parentNode;
        }
        Popper.createPopper(element, document.getElementById(dropdownID), {
            placement: "bottom-start",
        });
        document.getElementById(dropdownID).classList.toggle("hidden");
        document.getElementById(dropdownID).classList.toggle("block");
    }
    /* Sidebar - Side navigation menu on mobile/responsive mode */
    function toggleNavbar(collapseID) {
        document.getElementById(collapseID).classList.toggle("hidden");
        document.getElementById(collapseID).classList.toggle("bg-white");
        document.getElementById(collapseID).classList.toggle("m-2");
        document.getElementById(collapseID).classList.toggle("py-3");
        document.getElementById(collapseID).classList.toggle("px-6");
    }
    /* Function for dropdowns */
</script>
<script src="{{ mix('js/app.js') }}"></script>


@yield('script')


</body>

</html>
