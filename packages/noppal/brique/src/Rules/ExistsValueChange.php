<?php

namespace Npl\Brique\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;
use DB;

class ExistsValueChange implements Rule
{
    use DatabaseRule;


              
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table)
    {
        $this->table=$table;
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
        $query=DB::table($this->table);
        foreach($this->wheres as $where){
            $query->where($where['column'],$where['value']);
        }
        DB::enableQueryLog();
        $query->exists();
        dd(DB::getQueryLog());
        return $query->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'l\':attribute est invalide';
    }
}
