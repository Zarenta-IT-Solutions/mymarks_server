@extends('layouts.admin.school')

@section('TITLE','User Edit')

@section('header')
    <nav class="container mt-3">
        <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
            <li class="px-2"><a href="{{route('admin.dashboard')}}" class="no-underline text-white hover:text-gray-600">Dashboard</a></li>
            <li>/</li>
            <li class="px-2"><a href="{{route('school.users.index')}}" class="no-underline text-white hover:text-gray-600">User</a></li>
            <li>/</li>
            <li class="px-2">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')


    <div class="flex flex-wrap">
        <div class="w-full lg:w-8/12 px-4">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-200 border-0">
                <div class="rounded-t bg-white mb-0 px-6 py-6">
                    <div class="text-center flex justify-between">
                        <h6 class="text-gray-800 text-xl font-bold">Edit User</h6>
                    </div>
                </div>
                <form action="{{route('school.users.update',$user->id)}}" method="post">
                    @csrf @method('put')
                <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <h6 class="text-gray-500 text-sm mt-3 mb-6 font-bold uppercase">User Information</h6>
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2">Full Name</label>
                                    <input name="name" value="{{$user->name}}" required placeholder="jasse" type="text" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('name')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" >Email address</label>
                                    <input name="email" value="{{$user->email}}" required placeholder="jesse@example.com" type="email" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-gray-100 rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('email')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            @role('super')
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" >Password</label>
                                    <input name="password"   placeholder="**********" type="password" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-gray-100 rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('password')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" >Confirm Password</label>
                                    <input name="password_confirmation"   placeholder="**********" type="password" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-gray-100 rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('password_confirmation')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" >Roles  /label>
                                        <select multiple name="roles[]" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-gray-100 rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                                            @foreach($roles as $role)
                                                <option {{$user->hasRole($role->name)?'selected':''}} value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            @endrole

                        </div>


                </div>
                <div class="rounded-b bg-white mb-0 px-6 py-6">
                    <div class="text-center flex justify-between">
                        <input type="submit" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" value="Update"/>
                    </div>
                </div>
                </form>
            </div>
        </div>

    </div>


@endsection

@section('style')

@endsection

@section('script')


@endsection

