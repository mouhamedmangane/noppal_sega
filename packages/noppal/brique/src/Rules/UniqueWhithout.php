<?php

namespace Npl\Brique\Rules;
use DB;

use Illuminate\Contracts\Validation\Rule;

class UniqueWhithout implements Rule
{
    public $table,$attr,$idName,$idValue;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table,$attr,$idValue,$idName='id')
    {
        $this->table=$table;
        $this->attr=$attr;
        $this->idName=$idName;
        $this->idValue=$idValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table($table)->where($idName,'<>',$idValue)->where($attr,$value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'eCe attrobites existe deja';
    }
}
