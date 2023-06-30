@extends('layouts.admin.school')

@section('TITLE','Class List')
@section('header')
    <nav class="container mt-3">
        <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
            <li class="px-2"><a href="{{route('school.dashboard')}}" class="no-underline text-white hover:text-gray-600">Dashboard</a></li>
            <li>/</li>
            <li class="px-2"><a href="{{route('school.class.index')}}" class="no-underline text-white hover:text-gray-600">Class</a></li>
            <li>/</li>
            <li class="px-2">Detail</li>
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
                            <h3 class="font-semibold text-base text-gray-800">Class Detail</h3>
                        </div>
{{--                        <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">--}}
{{--                            <a href="{{route('admin.users.create')}}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Create</a>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="flex-auto px-4 bg-gray-100 lg:px-10 py-10 pt-0">
                    <table class="items-center w-full bg-transparent border-collapse" id="dataTable">
                        <thead>
                        <tr>
                            <th class="px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">#</th>
                            <th class="px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Name</th>
                            <th class="px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Created At</th>
                            <th class="px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($exams as $k=>$exam)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$exam->name}}</td>
                                <td>{{$exam->created_at->format('d-m-Y')}}</td>
                                <td>
                                    <a href="{{route('school.exam.show',$exam->id)}}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"><i class="fa fa-eye"></i> View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('style')

@endsection

@section('script')

@endsection
