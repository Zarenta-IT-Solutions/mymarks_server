@extends('layouts.admin.school')

@section('TITLE','Exam Detail')
@section('header')
    <nav class="container mt-3">
        <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
            <li class="px-2"><a href="{{route('school.dashboard')}}" class="no-underline text-white hover:text-gray-600">Dashboard</a></li>
            <li>/</li>
            <li class="px-2"><a href="{{route('school.class.show',$exam->class_id)}}" class="no-underline text-white hover:text-gray-600">Class</a></li>
            <li>/</li>
            <li class="px-2">Exam</li>
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
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                            <a href="{{route('school.exam.edit',$exam->id)}}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Edit</a>
                            <a href="{{route('school.exam.create',['class_id'=>$exam->class_id,'exam_id'=>$exam->id])}}"  class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Calculate</a>
                            @if($exam->excel)
                            <a href="{{Storage::url($exam->excel)}}" target="_blank" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Download Old Sheet</a>
                            @endif
                            <a onclick="document.getElementById('defaultModal').style.display='block'"  class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Upload Calculate</a>
                            <a href="{{route('school.exam.index',['id'=>$exam->id])}}" target="_blank" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Print All</a>
                            <a href="{{route('school.exam.index',['id'=>$exam->id])}}" target="_blank" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Print Roll</a>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-4 bg-gray-100 lg:px-10 py-10 pt-0">
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
                    </table>
                </div>
                <div class="text-center bg-gray">
                    <p>
                          "medium_id",
                          "name",
                          "email",
                          "mobile",
                          "address",
                          "date_of_birth",
                          "date_of_join",
                          "gender",
                          "blood_group",
                          "avatar",
                          "mother_name",
                          "father_name",
                          "aadhar",
                          "cast",
                          "family_id",
                          "sssm_id",
                          "rte",
                          "rte_number",
                          "enrollment",
                          "scholar",
                          "sambal",
                          "bank_name",
                          "bank_ifsc",
                          "bank_account",
                          "about",
                          "roll_number",
                          "medium",
                          "dobw",
                          "session",
                          "class_name"
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="flex flex-wrap mt-4" >
        <div class="w-full xl:w-12/12 mb-12 xl:mb-0 px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-center text-gray-800">Students</h3>
                        </div>
                    </div>
                </div>
                <form action="{{route('school.exam.destroy',$exam->id)}}" method="post">
                    @csrf @method('delete')
                <div class="flex-auto px-4 overflow-x-auto bg-gray-100 lg:px-10 py-10 pt-0">
                    <table class="items-center min-w-full bg-transparent border-collapse" >
                        <thead class="bg-white border-b sticky top-0">
                        <tr>
                            <th class="sticky top-0 px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">#</th>
                            <th class="sticky top-0 px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Select</th>
                            <th class="sticky top-0 px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Print</th>
                            
                            <th class="sticky top-0 px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Name</th>
                            <th class="sticky top-0 px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">Roll Number</th>
                            @if($marks->first() && $marks->first()->calculate_data!=null)
                            @foreach(array_keys($marks->first()->calculate_data) as $mk)
                            <th class="sticky top-0 px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left bg-gray-100 text-gray-600 border-gray-200">{{$mk}}</th>
                            @endforeach
                            @endif
                        
                        </tr>
                        </thead >
                        <tbody class="divide-y bg-red-100">
                            @foreach($marks as $k=>$mark)
                               <tr>
                                     <td>{{$k+1}}</td>
                                   <td>
                                       {{$mark->user?->id}}
                                       <input type="checkbox" name="ids[]" value="{{$mark->user?->id}}" />
                                        {{$mark->user?'':'*'}}
                                    </td>
                                    <td>
                                    <a href="{{route('school.exam.index',['id'=>$exam->id,'mark_id'=>$mark->id])}}" target="_blank" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Print</a>
                                </td>
                              
                                <td>{{$mark->user?$mark->user->name:''}}</td>
                                <td>{{$mark->roll_number}}</td>
                                @if($mark->calculate_data!=null)
                                @foreach(array_keys($mark->calculate_data) as $m)
                                    <td>{{$mark->calculate_data[$m]}}</td>
                                @endforeach
                                   @endif
                               
                               </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="bg-red-500 text-white active:bg-red-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" value="Delete Selected" />
                </form>
            </div>
        </div>

    </div>


    <!-- Main modal -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true" style="width: 30%;top:10%; left: 40%;" class="fixed top-5 left-0 right-0 z-50 hidden w-500 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <form action="{{route('school.exam.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{$exam->id}}">
                <div class="flex items-start justify-between p-4 bg-green-200 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Upload Excel Data</h3>
                    <button type="button" onclick="document.getElementById('defaultModal').style.display='none'" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 space-y-6">
                    <div class="relative w-full  mb-3">
                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2">Please select excel file</label>
                        <input name="file" required="" id="file_upload" onchange="upload()" accept="xlsx" placeholder="jasse" type="file" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                    </div>
                </div>
                <div  class="p-4 space-y-6" >
                    <textarea id="json-result" style="display: none" name="data" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 space-x-2 bg-green-200 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button  type="submit" style="float: right" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Upload</button>
                </div>
                </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.min.js"></script>
    <script>
        // Method to upload a valid excel file
        function upload() {
            var files = document.getElementById('file_upload').files;
            if(files.length==0){
                alert("Please choose any file...");
                return;
            }
            var filename = files[0].name;
            var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
            if (extension == '.XLS' || extension == '.XLSX') {
                excelFileToJSON(files[0]);
            }else{
                alert("Please select a valid excel file.");
            }
        }

        //Method to read excel file and convert it into JSON
        function excelFileToJSON(file){
            try {
                var reader = new FileReader();
                reader.readAsBinaryString(file);
                reader.onload = function(e) {

                    var data = e.target.result;
                    var workbook = XLSX.read(data, {
                        type : 'binary'
                    });
                    var result = XLSX.utils.sheet_to_row_object_array(workbook.Sheets['Sheet1']);;
                    var resultEle=document.getElementById("json-result");
                    resultEle.value=JSON.stringify(result, null, 4);
                    resultEle.style.display='block';
                }
            }catch(e){
                console.error(e);
            }
        }
    </script>
@endsection
