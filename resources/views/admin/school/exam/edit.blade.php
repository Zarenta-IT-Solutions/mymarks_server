@extends('layouts.admin.school')

@section('TITLE','Exam Detail')
@section('header')
    <nav class="container mt-3">
        <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
            <li class="px-2"><a href="{{route('school.dashboard')}}" class="no-underline text-white hover:text-gray-600">Dashboard</a></li>
            <li>/</li>
            <li class="px-2"><a href="{{route('school.class.show',$exam->class_id)}}" class="no-underline text-white hover:text-gray-600">Class</a></li>
            <li>/</li>
            <li class="px-2"><a href="{{route('school.exam.show',$exam->id)}}" class="no-underline text-white hover:text-gray-600">Exam</a></li>
            <li>/</li>
            <li class="px-2">Exam Edit</li>
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
                            <h3 class="font-semibold text-base text-gray-800">Exam Detail</h3>
                        </div>
                        @if($errors->has('template'))
                            <div class="error">{{ $errors->first('template') }}</div>
                        @endif
                    </div>
                </div>
                <div class="flex-auto px-4 bg-gray-100 lg:px-10 py-10 pt-0">
                    <form action="{{route('school.exam.update',$exam->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                    <table class="items-center w-full bg-transparent border-collapse" >
                        <tr>
                            <th >Exam Name :</th>
                            <td>{{$exam->name}}</td>
                        </tr>
                        <tr>
                            <th >Class Name :</th>
                            <td>{{$exam->my_class->name}}</td>
                        </tr>
                        <tr>
                            <th >Academic :</th>
                            <td>{{$exam->academic_year->year_range}}</td>
                        </tr>
                    
                        <tr>
                            <th >Template :</th>
                            <td>
                                <input name="template"  type="file" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                            </td>
                        </tr>
                        <tr>
                            <th >Template :</th>
                            <td>
                                <input name="roll_template"  type="file" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                            </td>
                        </tr>
                        <tr>
                            <th ></th>
                            <td>
                                <input type="submit" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mt-1 mr-1 mb-1 ease-linear transition-all duration-150" value="Update">
                            </td>
                        </tr>
                        
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap mt-4">
        <div class="w-full xl:w-12/12 mb-12 xl:mb-0 px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-gray-800">Exam Detail</h3>
                        </div>

                    </div>
                </div>
                <div class="flex-auto px-4 bg-gray-100 lg:px-10 py-10 pt-0">
                    @if($exam->template!=null && Storage::get($exam->template))
                    <a href="{{Storage::url($exam->template)}}" target="_blank" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mt-1 mr-1 mb-1 ease-linear transition-all duration-150">View</a>
                    <iframe class="w-full " style="height: 500px" src="{{Storage::url($exam->template)}}' "></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('style')
    <style>thead{
            position:sticky;
            top:0
        }</style>
@endsection

@section('script')

@endsection
