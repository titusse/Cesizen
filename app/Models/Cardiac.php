<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cardiac extends Model
{
    protected $table = 'cardiac';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'difficulty',
    ];

    public function cardiacItem(): HasMany
    {
        return $this->hasMany(CardiacItem::class);
    }
}
