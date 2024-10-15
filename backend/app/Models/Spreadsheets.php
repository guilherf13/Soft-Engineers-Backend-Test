<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spreadsheets extends Model
{
    use HasFactory;

    // Definindo os campos que podem ser preenchidos
    protected $fillable = [
        'name',
        'hash',
        'path',
        'uploaded_at'
    ];

    // Definindo o campo de data de maneira automática
    protected array $dates = ['uploaded_at'];

    public function contents(): \Illuminate\Database\Eloquent\Relations\HasMany|\MongoDB\Laravel\Relations\HasMany
    {
        return $this->hasMany(FileContent::class);
    }
}