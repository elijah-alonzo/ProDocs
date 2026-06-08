<div class="workflow-designer-container">
    @include('admin.workflowdesigner.styles')

    <div class="designer-header">
        <div>
            <h3 class="designer-title">Workflow Design Studio: {{ $workflow->name }}</h3>
            <p class="designer-subtitle">Define the stages, authorization roles, labels, and transition states for this approval process.</p>
        </div>
        <div>
            <button type="button" class="designer-btn secondary" onclick="window.history.back()">Back</button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="steps-list">
            @foreach ($steps as $index => $step)
                <div class="step-node-wrapper" wire:key="step-{{ $index }}">
                    <div class="step-node">
                        <div class="step-badge">
                            {{ $step['step_order'] }}
                        </div>

                        <div class="step-input-group">
                            <span class="step-label">Stage Name</span>
                            <input type="text" 
                                   wire:model.defer="steps.{{ $index }}.step_name" 
                                   class="step-field" 
                                   placeholder="e.g., Dean Endorsement">
                            @error("steps.{$index}.step_name") <span style="color:#ef4444; font-size:11px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="step-input-group">
                            <span class="step-label">Authorized Role</span>
                            <select wire:model.defer="steps.{{ $index }}.assigned_role_id" class="step-field">
                                <option value="">Select Role...</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endforeach
                            </select>
                            @error("steps.{$index}.assigned_role_id") <span style="color:#ef4444; font-size:11px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="step-input-group">
                            <span class="step-label">Action Label</span>
                            <input type="text" 
                                   wire:model.defer="steps.{{ $index }}.action_label" 
                                   class="step-field" 
                                   placeholder="e.g., Approve / Endorse">
                            @error("steps.{$index}.action_label") <span style="color:#ef4444; font-size:11px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="step-input-group">
                            <span class="step-label">Approve Status</span>
                            <input type="text" 
                                   wire:model.defer="steps.{{ $index }}.approve_status" 
                                   class="step-field" 
                                   placeholder="e.g., to_verify">
                            @error("steps.{$index}.approve_status") <span style="color:#ef4444; font-size:11px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="step-input-group">
                            <span class="step-label">Reject Status</span>
                            <input type="text" 
                                   wire:model.defer="steps.{{ $index }}.reject_status" 
                                   class="step-field" 
                                   placeholder="e.g., disapproved">
                            @error("steps.{$index}.reject_status") <span style="color:#ef4444; font-size:11px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="step-actions">
                            <button type="button" 
                                    wire:click="moveStepUp({{ $index }})" 
                                    class="action-btn" 
                                    title="Move Up"
                                    @if($index === 0) disabled style="opacity:0.3;cursor:not-allowed;" @endif>
                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                            <button type="button" 
                                    wire:click="moveStepDown({{ $index }})" 
                                    class="action-btn" 
                                    title="Move Down"
                                    @if($index === count($steps) - 1) disabled style="opacity:0.3;cursor:not-allowed;" @endif>
                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <button type="button" 
                                    wire:click="removeStep({{ $index }})" 
                                    class="action-btn delete" 
                                    title="Delete Stage"
                                    @if(count($steps) <= 1) disabled style="opacity:0.3;cursor:not-allowed;" @endif>
                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="add-step-btn-container">
            <button type="button" wire:click="addStep" class="designer-btn secondary">
                <svg style="width:16px;height:16px;margin-right:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Next Approval Stage
            </button>
        </div>

        <div class="footer-actions">
            <button type="submit" class="designer-btn primary">
                Save Workflow Stages
            </button>
        </div>
    </form>

    @include('admin.workflowdesigner.scripts')
</div>
