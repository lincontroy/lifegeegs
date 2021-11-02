<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    // Relation To TermsMeta
    public function user()
    {
        return $this->belongsTo("App\Models\User", "featured", 'id');
    }
    public function termMeta()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'service_meta');
    }
    public function quickStart()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'quick_start_meta');
    }

    // Relation To TermsMeta
    public function page()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'page');
    }

    // Relation to Termsmeta
    public function meta()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'content');
    }

    // Relation To TermsMeta
    public function excerpt()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'excerpt');
    }

    // Relation To TermsMeta
    public function thum_image()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'thum_image');
    }

    // Relation To TermsMeta
    public function description()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'description');
    }

}
