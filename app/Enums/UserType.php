<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Student = 0; // Учащийся
    const Teacher = 1; // Обычный сотрудник школы
    const HeadTeacher = 2; // Завуч
    const Principal = 3; // Директор
    const Admin = 4; // Админ
}