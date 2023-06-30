@extends('layouts.admin.school')

@section('TITLE','Users')

@section('header')
    <nav class="container mt-3">
        <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
            <li class="px-2"><a href="{{route('school.dashboard')}}" class="no-underline text-white hover:text-gray-600">Dashboard</a></li>
            <li>/</li>
            <li class="px-2">Files</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="flex flex-wrap mt-4">
        <div class="w-full xl:w-12/12 mb-12 xl:mb-0 px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-gray-800">Files</h3>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-4 bg-gray-100 lg:px-10 py-10 pt-0">
                    <form action="{{route('school.files.store')}}" method="post" class="dropzone" id="my-great-dropzone">
                        {{csrf_field()}}
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-gray-100">
        <h2 class="text-2xl font-bold text-gray-900">Collections</h2>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-2xl py-16 sm:py-24 lg:max-w-none lg:py-32">
                <div class="mt-6   space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-4 lg:space-y-0">
                    @foreach($files as $file)
                    <div class="group relative mb-2">
                        <form action="{{route('school.files.destroy',Crypt::encryptString($file->url))}}" method="post">
                            @csrf @method('delete')
                        <div class="p-2 border-green-200 h-80 w-full overflow-hidden rounded-lg bg-white group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1 border-black">
                            <button type="submit" class="bg-red-400 float-right text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"><i class="fa fa-trash"></i></button>
                            <img src="{{Storage::url($file->url)}}" style="width: 50%" alt="Desk with leather p-1 desk pad, walnut desk organizer, wireless keyboard and mouse, and porcelain mug." class="h-full w-full object-cover object-center">
                            <h3 class="mt-6 text-sm text-gray-500">
                                <a href="{{Storage::url($file->url)}}" target="_blank"><span class="absolute inset-0"></span>View</a>
                            </h3>
                            <p class="text-base font-semibold text-gray-900 mb-2">{{Storage::url($file->url)}}</p>
                        </div>
                        </form>
                    </div>
                    @endforeach

                </div>
            </div>
            {!! $files !!}
        </div>
    </div>



@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css" integrity="sha512-MeagJSJBgWB9n+Sggsr/vKMRFJWs+OUphiDV7TJiYu+TNQD9RtVJaPDYP8hA/PAjwRnkdvU+NsTncYTKlltgiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        Dropzone.options.myGreatDropzone = { // camelized version of the `id`
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                }
                else { done(); }
            }
        };
    </script>
@endsection