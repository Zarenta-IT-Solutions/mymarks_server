<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.ico')}}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/styles/tailwind.css')}}" />
    <title>{{config('app.name')}} - @yield('TITLE')</title>
    @yield('style')
</head>

<body class="text-gray-800 antialiased">
<noscript>You need to enable JavaScript to run this app.</noscript>
<div id="root">
    <nav class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-no-wrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
        <div class="md:flex-col md:items-stretch md:min-h-full md:flex-no-wrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
            <button class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" type="button" onclick="toggleNavbar('example-collapse-sidebar')"> <i class="fas fa-bars"></i> </button> <a class="md:block text-left md:pb-2 text-gray-700 mr-0 inline-block whitespace-no-wrap text-sm uppercase font-bold p-4 px-0" href="{{route('admin.dashboard')}}"> {{config('app.name')}}  - {{request()->session()->get('slug')}}</a>
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
                            <a class="md:block text-left md:pb-2 text-gray-700 mr-0 inline-block whitespace-no-wrap text-sm uppercase font-bold p-4 px-0" href="{{route('admin.dashboard')}}">{{config('app.name')}} - {{request()->session()->get('slug')}}</a> </div>
                        <div class="w-6/12 flex justify-end">
                            <button type="button" class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" onclick="toggleNavbar('example-collapse-sidebar')"> <i class="fas fa-times"></i> </button>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                    <li class="items-center">
                        <a href="{{route('admin.school.index')}}" class="text-xs uppercase py-3 {{ (request()->is('admin/school*')) ? 'text-green-500' : 'text-gray-800' }} font-bold block  hover:text-green-500">
                            <i class="fas fa-tv mr-2 text-sm opacity-75"></i> Dashboard
                        </a>
                    </li>
                    <li class="items-center">
                        <a href="{{route('school.files.index')}}" class="{{ (request()->is('school/files*')) ? 'text-green-500' : 'text-gray-800' }} text-xs uppercase py-3 font-bold block  hover:text-green-500">
                            <i class="fas fa-file mr-2 text-sm text-gray-400"></i> Files
                        </a>
                    </li>
                    <li class="items-center">
                        <a href="{{route('school.class.index')}}" class="{{ (request()->is('school/class*')) ? 'text-green-500' : 'text-gray-800' }} text-xs uppercase py-3 font-bold block  hover:text-green-500">
                            <i class="fas fa-users mr-2 text-sm text-gray-400"></i> Classes
                        </a>
                    </li>
                    <li class="items-center">
                        <a href="{{route('school.users.index')}}" class="{{ (request()->is('school/users*')) ? 'text-green-500' : 'text-gray-800' }} text-xs uppercase py-3 font-bold block  hover:text-green-500">
                            <i class="fas fa-user mr-2 text-sm text-gray-400"></i> Users
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="relative md:ml-64 bg-gray-100">
        <nav class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-no-wrap md:justify-start flex items-center p-4">
            <div class="w-full mx-autp items-center flex justify-between md:flex-no-wrap flex-wrap md:px-10 px-4">
                <a class="text-white text-sm uppercase hidden lg:inline-block font-semibold">@yield('TITLE')</a>

                <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
                    <a class="text-gray-600 block bg-white rounded p-2 m-2" href="#pablo" onclick="openDropdown(event,'user-dropdown')">
                        <div class="items-center text-gray-500 flex">
                           Select Session
                        </div>
                    </a>
                    <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="user-dropdown">
                        @foreach(getAcedmic() as $acedmic)
                            <a href="{{route('school.class.edit',$acedmic->id)}}" class="text-sm {{getSettingVal('academic_year_id')==$acedmic->id?'text-green-500':''}} py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800">{{$acedmic->year_range}}</a>
                        @endforeach
                    </div>
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
        <div class="relative bg-green-500 pb-32 pt-12">
            <div class="px-4 md:px-10 mx-auto w-full">
                <div>
                    @yield('header')
                    @include('flash::message')
                </div>
            </div>
        </div>
        <div class="px-4 md:px-10 mx-auto w-full -m-24">

            @yield('content')

            <footer class="block py-4">
                <div class="container mx-auto px-4">
                    <hr class="mb-4 border-b-1 border-gray-300"/>
                    <div class="flex flex-wrap items-center md:justify-between justify-center">
                        <div class="w-full md:w-4/12 px-4">
                            <div class="text-sm text-gray-600 font-semibold py-1 text-center md:text-left">
                                Copyright © {{date('Y')}}
                                <a  class="text-gray-600 hover:text-gray-800 text-sm font-semibold py-1">
                                    Mymarks
                                </a>
                            </div>
                        </div>
                        <div class="w-full md:w-8/12 px-4">
                            <ul class="flex flex-wrap list-none md:justify-end justify-center">
                                <li><a href="" class="text-gray-700 hover:text-gray-900 text-sm font-semibold block py-1 px-3">
                                        Developed By  Zarenta
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>
</div>

@if(Session::has('message'))
    <div id="toast-default" class="absolute top-5 right-5 flex items-center z-index-99 w-64 max-w-xs p-4 text-black-500 {{ Session::get('alert-class', 'bg-white') }} rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">check icon</span>
        </div>
        <div class="ml-3 text-sm font-normal">{{ Session::get('message') }}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5  text-black-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-default" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
@endif

@if($errors->any())
    <div id="toast-default" class="absolute flex items-center z-index-99 w-64 max-w-xs p-4 space-x-4 text-black-500 bg-red-500 divide-x divide-gray-200 rounded-lg shadow top-5 right-5 dark:text-black-400 dark:divide-gray-700 space-x dark:bg-gray-800" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Fire icon</span>
        </div>
        <div class="ml-3 text-sm font-normal">{!! implode('', $errors->all('<div>:message</div>')) !!}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5  text-black-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-default" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
@endif


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
