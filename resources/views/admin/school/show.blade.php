@extends('layouts.admin.school')

@section('TITLE','School Details')

@section('header')
    <nav class="container mt-3">
        <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
            <li class="px-2"><a href="{{route('admin.dashboard')}}" class="no-underline text-white hover:text-gray-600">Dashboard</a></li>
            <li>/</li>
            <li class="px-2"><a href="{{route('admin.school.index')}}" class="no-underline text-white hover:text-gray-600">Schools</a></li>
            <li>/</li>
            <li class="px-2">Detail</li>
        </ol>
    </nav>
@endsection

@section('content')


    <div class="flex flex-wrap mt-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-lg text-gray-800">
                            Schools
                        </h3>
                    </div>
                </div>
            </div>
            <div class="block w-full overflow-x-auto">
                <!-- Projects table -->
                <table class="items-center w-full bg-transparent border-collapse" id="dataTable">
                    <tr>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Id</th>
                        <td class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">{{$domain->id}}</td>
                    </tr>
                    <tr>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Database Name</th>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">{{$domain->tenancy_db_name}}</th>
                    </tr>
                    <tr>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">School Name</th>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">{{$domain->domains->first()->school_name}}</th>
                    </tr>
                    <tr>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Contact Number</th>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">{{$domain->domains->first()->contact_number}}</th>
                    </tr>
                    <tr>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Medums</th>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">@foreach($mediums as $m) {{$m->name}},&nbsp; @endforeach</th>
                    </tr>
                    <tr>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Created At</th>
                        <th class="px-3 align-middle border border-solid py-3 text-xs  border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">{{$domain->created_at}}</th>
                    </tr>
                </table>
            </div>
        </div>

    </div>



@endsection
