<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardiacItem extends Model
{
    protected $table = 'cardiac_item';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'duration',
        'cardiac_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'duration' => 'integer',
        ];
    }

    public function cardiac_id(): BelongsTo
    {

        return $this->belongsTo(Cardiac::class);

    }
}
