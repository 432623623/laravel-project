<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    //
    use Searchable;
    protected $fillable = ['title','body','user_id','image'];

    public function toSearchableArray(){
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    protected static function booted(){
        static::deleting(function ($post){
            if($post->image){
                Storage::disk('public')->delete($post->image);
            }
            preg_match_all('/storage\/trix-images\/(full|thumb)\/(.*?)"/', 
                html_entity_decode($post->body),
                $matches
            );
            foreach($matches[2] as $filename){
                Storage::disk('public')->delete("trix-images/full/$filename");
                Storage::disk('public')->delete("trix-images/thumb/$filename");
            }
        });
    }
}
