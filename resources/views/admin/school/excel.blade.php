<table>
    <thead>
    <tr>
        
        
    @foreach($keys as $k)
        <th>{{$k}}</th>
    @endforeach
    <td>Scholar</td>
        <td>Name</td>
        <td>father name</td>
        <td>mother name</td>
        <td>dob</td>
        <td>sssmid</td>
        <td>familyID</td>
        <td>aadhar</td>
        <td>cast</td>
        <td>gender</td>
    </tr>
    </thead>
    <tbody>
    @foreach($marks as $mark)
    <tr>
       <?php $user = DB::table('users')->find($mark['id']); ?>
       
        @foreach($keys as $k)
            <td>{{isset($mark[$k])?$mark[$k]:''}}</td>
        @endforeach
         <td>{{$user?->scholar}}</td>
        <td>{{$user?->name}}</td>
        <td>{{$user?->father_name}}</td>
        <td>{{$user?->mother_name}}</td>
        <td>{{Carbon\Carbon::parse($user?->date_of_birth)->format('d.m.Y')}}</td>
        <td>{{$user?->sssm_id}}</td>
        <td>{{$user?->family_id}}</td>
        <td>{{$user?->aadhar}}</td>
        <td>{{$user?->cast}}</td>
        <td>{{$user?->gender}}</td>
    </tr>
    @endforeach
    </tbody>
</table>