<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\VotableTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    use VotableTrait;

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
        return clean($this->bodyHtml());
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer(Answer $answer){
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites(){
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavorited(){
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }

    public function getExcerptAttribute(){
       return $this->excerpt(250);
    }

    public function excerpt($value){
        return \Illuminate\Support\Str::limit(strip_tags($this->bodyHtml), $value);
    }

    private function bodyHtml(){
        $markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);

        return $markdown->convertToHtml($this->body);
    }
}
