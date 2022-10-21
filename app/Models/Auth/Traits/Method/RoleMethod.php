<?php

namespace App\Models\Auth\Traits\Method;

/**
 * Trait RoleMethod.
 */
trait RoleMethod
{
    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->name === config('access.users.admin_role');
    }
    /**
     * @return mixed
     */
    public function isTeacher()
    {
        return $this->name === 'teacher';
    }
    /**
     * @return mixed
     */
    public function isStudent()
    {
        return $this->name === 'student';
    }
}
