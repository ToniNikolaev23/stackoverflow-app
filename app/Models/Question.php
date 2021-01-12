<?php

namespace App\Models;

use App\Models\Answer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute(){
        return route("questions.show", $this->slug);
    }
    
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){
        if($this->answers_count > 0){
            if($this->best_answer_id){
                return "answered_accepted";
            }
            return "answered";
        }

        return "unanswered";
    }

    public function getBodyHtmlAttribute(){
        $markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);

        return $markdown->convertToHtml($this->body);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
