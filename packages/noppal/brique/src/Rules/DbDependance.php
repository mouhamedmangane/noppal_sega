<?php

namespace Npl\Brique\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class DbDependance implements Rule
{

    private const DEFAULT_NAME_CLAUSE="where";
    private const DEFAULT_OP="=";

    public $table,$clauses=[],$attr;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table,$attr,$clauses=[])
    {
        $this->table=$table;
        $this->attr=$attr;
        foreach($clauses as $clause){
            $op=(isset($clause[3]))? $clause[3] : self::DEFAULT_OP;
            $nameClause=(isset($clause[2]))? $clause[2] : self::DEFAULT_NAME_CLAUSE;
            $this->addClause($clause[0],$clause[1],$nameClause,$op);
        }

    }

    public function addClause($attr,$value,$nameClause=self::DEFAULT_NAME_CLAUSE,$op=self::DEFAULT_OP){
        $this->clauses[]=[$attr,$value,$nameClause,$op];
        return $this;
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
        $this->addClause($this->attr,$value);
        $model= DB::table($this->table);
        foreach($this->clauses as $clause){
            $nameClause=$clause[2];
            $model->$nameClause($clause[0],$clause[3],$clause[1]);
        }
        // DB::enableQueryLog(); // Enable query log
        // $model->exists();
        // dd(DB::getQueryLog());

        return !$model->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("validation.custom.db_dependance");
    }
}
