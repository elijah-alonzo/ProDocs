<?php

namespace App\Features\DocumentProcesses\Models;

use App\Features\DocumentCategories\Models\DocumentCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentProcess extends Model
{
    protected $table = 'document_processes';

    protected $fillable = [
        'name',
        'description',
    ];

    public function stages(): HasMany
    {
        return $this->hasMany(DocumentProcessStage::class, 'document_process_id')->orderBy('stage_order');
    }

    public function documentCategories(): HasMany
    {
        return $this->hasMany(DocumentCategory::class, 'document_process_id');
    }
}