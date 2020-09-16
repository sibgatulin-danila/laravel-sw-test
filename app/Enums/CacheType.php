<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CacheType extends Enum
{
    const UserIndex = 'user:index';

    const EmployeeIndex  = 'employee:index';

    const GradeIndex = 'grade:index';
    const GradeStat  = 'grade:stat';

    const SchoolClassIndex = 'school-class:index';

    const SchoolIndex = 'school:index';

    const StudentIndex = 'student:index';

    const SubjectIndex = 'subject:index';
}