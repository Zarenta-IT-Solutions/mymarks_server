@extends('thames.aislin.layout')


@section('content')




    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex flex-wrap">
                <img alt="" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="https://mymarks.s3.ap-south-1.amazonaws.com/files/NE7BJKF35Gubi8hEG7vh3wab1lw2fCL5Lpch2tSH.png">
                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">



                    <div class="relative overflow-hidden bg-white">
                        <div class="pt-16 pb-80 sm:pt-24 sm:pb-40 lg:pt-40 lg:pb-48">
                            <div class="w-full  justify-self-center">
                                <form method="post" action="{{url('result')}}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username"> Select Academic <Year></Year></label>
                                        <select name="academic_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                            <option selected disabled>Select</option>
                                            @foreach($sessions as $session)
                                                <option value="{{$session->id}}">{{$session->year_range}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username"> Select Class </label>
                                        <select onchange="selectClass(this.value)" name="class_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                            <option selected disabled>Select</option>
                                            @foreach($classes as $class)
                                                <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username"> Select Class </label>
                                        <select id="exams" name="exam_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                            <option selected disabled>Select</option>

                                        </select>
                                    </div>
                                    <div class="mb-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Enter Roll Number</label>
                                        <input name="roll_number" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"  type="text" placeholder="******************">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit"> Get Result </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </section>












































    <div class="relative overflow-hidden bg-white">
        <div class="pt-16 pb-80 sm:pt-24 sm:pb-40 lg:pt-40 lg:pb-48">

            <table class="table-auto">
                <tr>
                    <th>Name : </th>
                    <td>{{$mark->user->name}}</td>
                </tr>
                <tr>
                    <th>Father's Name : </th>
                    <td>{{$mark->user->father_name}}</td>
                </tr>
                @foreach($keys as $key)
                    <tr>
                        <th>{{ucfirst($key)}}</th>
                        <td>{{$mark->calculate_data[$key]}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function selectClass(id)
        {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("exams").innerHTML = this.responseText;
            }
            xhttp.open("GET", "{{url('result')}}/"+id+"/edit", true);
            xhttp.send();
        }
    </script>

@endsection
