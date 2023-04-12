<?php

namespace App\Imports;

use App\Models\User;
use App\Models\StudentAcademicYear;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    public $classId;

    public $sectionId;

    public $acedemicId;

    public function __construct($classId,$sectionId,$acedemicId)
    {
        $this->classId = $classId;
        $this->sectionId = $sectionId;
        $this->acedemicId = $acedemicId;
    }

    public function rules(): array
    {
        return [
            '*.email' => 'required|unique:users|max:255',
        ];
    }

//    public function onFailure(Failure ...$failures)
//    {
//        // Handle the failures how you'd like.
//    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {

        foreach($rows as $row) {
                $userData = ['name' => $row['name'], 'email' => $row['email'], 'address' => $row['address'], 'mobile' => $row['mobile'], 'date_of_birth' => Carbon::parse($row['date_of_birth'])->format('Y-m-d H:i:s'), 'gender' => $row['gender'], 'about' => $row['about'], 'blood_group' => $row['blood_group'], 'mother_name' => $row['mother_name'], 'father_name' => $row['father_name'], 'aadhar' => $row['aadhar'], 'cast' => $row['cast'], 'family_id' => $row['family_id'], 'sssm_id' => $row['sssm_id'], 'rte' => $row['rte'], 'rte_number' => $row['rte_number'], 'scholar' => $row['scholar'], 'bank_name' => $row['bank_name'], 'bank_ifsc' => $row['bank_ifsc'], 'bank_account' => $row['bank_account'], 'enrollment' => $row['enrollment']];
                $user = User::firstOrCreate($userData);
                $user->assignRole('student');
                $acedemicData = ['user_id' => $user->id, 'class_id' => $this->classId, 'roll_number' => $row['roll_number'], 'section_id' => $this->sectionId, 'academic_id' => $this->acedemicId];
                $student = StudentAcademicYear::firstOrCreate($acedemicData);
                session(['student[]' => $student]);
        }

    }

}
