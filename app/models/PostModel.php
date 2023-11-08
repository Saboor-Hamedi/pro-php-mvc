<?php

namespace Framework\Models;
use Framework\Models\Model;
use Framework\config\Dump;

class PostModel extends Model
{
    

    use Dump;
    protected $title;
    protected $content;
    protected $user_id;
    protected $published;
    protected $created_at;
    public $table = 'posts';
    public function __construct(){
        parent::__construct();
        $this->table;
    }
    protected $fillable = [
        'id', 
        'user_id', 
        'title', 
        'content',
        'published', 
        'created_at'
    ];

    // public function __get($property)
    // {
    //     if (in_array($property, $this->fillable)) {
    //         $this->dd($property);
    //         return $this->$property;
    //     } else {
    //         throw new \Exception("Property '$property' is not accessible.");
    //     }
    // }
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @return mixed
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }
}
