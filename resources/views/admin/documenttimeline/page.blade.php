<div class="timeline-wrapper">
    @include('admin.documenttimeline.styles')

    <h4 class="timeline-title">
        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Document Approval Path & History
    </h4>

    <div class="timeline-steps">
        <!-- Step 0: Submission -->
        <div class="timeline-step">
            <div class="timeline-icon approved">
                <svg style="width:10px;height:10px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="timeline-content">
                <div class="timeline-header">
                    <span class="timeline-stage-name">Document Submitted</span>
                    <span class="timeline-date">{{ $document->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="timeline-actor">Submitted by: {{ $document->submittedBy->full_name }}</div>
                <span class="timeline-badge approved">Submitted</span>
            </div>
        </div>

        <!-- Approvals History -->
        @foreach ($document->approvals as $approval)
            <div class="timeline-step">
                <div class="timeline-icon {{ $approval->status === 'approved' ? 'approved' : 'rejected' }}">
                    @if($approval->status === 'approved')
                        <svg style="width:10px;height:10px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    @else
                        <svg style="width:10px;height:10px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    @endif
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <span class="timeline-stage-name">{{ $approval->workflowStep?->step_name ?? 'Workflow Stage' }}</span>
                        <span class="timeline-date">{{ $approval->acted_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="timeline-actor">Acted by: {{ $approval->user->full_name }} ({{ $approval->workflowStep?->role?->name ?? 'Approver' }})</div>
                    <span class="timeline-badge {{ $approval->status === 'approved' ? 'approved' : 'rejected' }}">
                        {{ ucfirst($approval->status) }}
                    </span>
                    @if ($approval->remarks)
                        <div class="timeline-remarks {{ $approval->status === 'approved' ? 'approved' : 'rejected' }}">
                            "{{ $approval->remarks }}"
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Current Pending Step (if not final) -->
        @if ($document->currentStep)
            <div class="timeline-step">
                <div class="timeline-icon current">
                    <svg style="width:10px;height:10px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <span class="timeline-stage-name">{{ $document->currentStep->step_name }}</span>
                        <span class="timeline-date">Pending</span>
                    </div>
                    <div class="timeline-actor">Assigned Role: {{ $document->currentStep->role?->name }}</div>
                    <span class="timeline-badge current">Current Stage</span>
                </div>
            </div>
        @elseif($document->status === 'approved')
            <div class="timeline-step">
                <div class="timeline-icon approved">
                    <svg style="width:12px;height:12px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <span class="timeline-stage-name">Workflow Fully Approved</span>
                        <span class="timeline-date">{{ $document->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="timeline-actor">Final status: Completed</div>
                    <span class="timeline-badge approved">Approved</span>
                </div>
            </div>
        @elseif($document->status === 'rejected')
            <div class="timeline-step">
                <div class="timeline-icon rejected">
                    <svg style="width:10px;height:10px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <span class="timeline-stage-name">Workflow Rejected</span>
                        <span class="timeline-date">{{ $document->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="timeline-actor">Final status: Rejected</div>
                    <span class="timeline-badge rejected">Rejected</span>
                </div>
            </div>
        @endif
    </div>
</div>
