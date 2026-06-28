<?php

namespace App\Features\DocumentProcesses\Models;

use App\Features\Roles\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentProcessStage extends Model
{
    protected $table = 'document_process_stages';

    protected $fillable = [
        'document_process_id',
        'stage_order',
        'stage_name',
        'assigned_role_id',
        'action_label',
        'approve_status',
        'reject_status',
    ];

    public function documentProcess(): BelongsTo
    {
        return $this->belongsTo(DocumentProcess::class, 'document_process_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'assigned_role_id');
    }
}