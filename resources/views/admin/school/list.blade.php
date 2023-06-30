<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-left">{{$key+1}}</td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-left">{{$domain->id}}</td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-left">{{$domain->data}}</td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-left">
        <a href="{{route('admin.school.edit',$domain->id)}}"><i class="fa fa-eye"></i></a>
    </td>
</tr>
