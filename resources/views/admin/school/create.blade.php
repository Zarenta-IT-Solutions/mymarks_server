@extends('layouts.admin.page')

@section('TITLE','School Create')

@section('header')
    <nav class="container mt-3">
        <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
            <li class="px-2"><a href="{{route('admin.dashboard')}}" class="no-underline text-white hover:text-gray-600">Dashboard</a></li>
            <li>/</li>
            <li class="px-2"><a href="{{route('admin.school.index')}}" class="no-underline text-white hover:text-gray-600">Schools</a></li>
            <li>/</li>
            <li class="px-2">Create</li>
        </ol>
    </nav>
@endsection

@section('content')


    <div class="flex flex-wrap">
        <div class="w-full lg:w-8/12 px-4">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-200 border-0">
                <div class="rounded-t bg-white mb-0 px-6 py-6">
                    <div class="text-center flex justify-between">
                        <h6 class="text-gray-800 text-xl font-bold">Create School</h6>
                    </div>
                </div>
                <form action="{{route('admin.school.store')}}" method="post">
                    @csrf
                <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <h6 class="text-gray-500 text-sm mt-3 mb-6 font-bold uppercase">Admin Information</h6>
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2">Full Name</label>
                                    <input name="name" required placeholder="jasse" type="text" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('name')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" >Email address</label>
                                    <input name="email" required placeholder="jesse@example.com" type="email" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('email')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" >Password</label>
                                    <input name="password" required type="password" placeholder="password" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('password')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" >Confirm Password</label>
                                    <input name="password_confirmation" required type="password" placeholder="password" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('password_confirmation')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <hr class="mt-6 border-b-1 border-gray-400" />

                        <h6 class="text-gray-500 text-sm mt-3 mb-6 font-bold uppercase">School Information</h6>
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2">Name</label>
                                    <input type="text" name="school_name" placeholder="DPS" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('school_name')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full lg:w-6/12 px-6">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2">SubDomain</label>
                                    <input type="text" name="id" required placeholder="dps" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('id')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full lg:w-6/12 px-6">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2">Contact</label>
                                    <input type="number" name="contact_number" required maxlength="10" placeholder="Contact Number" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150"/>
                                </div>
                                @error('contact_number')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2">Medium</label>
                                    <select name="mediums[]" multiple class="js-example-basic-single px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                                        <option value="hindi">Hindi</option>
                                        <option value="english">English</option>
                                        <option value="sanskrit">Sanskrit</option>
                                        <option value="urdu">Urdu</option>
                                    </select>
                                </div>
                                @error('mediums')
                                <div class="text-xs text-red-500 font-normal  max-w-full flex-initial">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="rounded-b bg-white mb-0 px-6 py-6">
                    <div class="text-center flex justify-between">
                        <input type="submit" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" value="Save"/>
                    </div>
                </div>
                </form>
            </div>
        </div>

    </div>


@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                tags:true,

            });
        });
    </script>
@endsection

