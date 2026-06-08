<div class="analytics-dashboard">
    @include('admin.analytics.styles')

    <div class="analytics-header">
        <h2 class="analytics-title">Workflow Execution Analytics</h2>
        <p class="analytics-subtitle">Real-time oversight of document pipelines, routing efficiency, and pending queues.</p>
    </div>

    <!-- Metrics Cards Grid -->
    <div class="metrics-grid">
        <div class="metric-card primary">
            <div>
                <span class="metric-label">Total Submissions</span>
                <div class="metric-value">{{ $totalDocuments ?? 0 }}</div>
            </div>
            <span class="metric-desc">All document workflows initiated</span>
        </div>

        <div class="metric-card success">
            <div>
                <span class="metric-label">Approved Documents</span>
                <div class="metric-value">{{ $approvedDocuments ?? 0 }}</div>
            </div>
            <span class="metric-desc">Successfully completed workflows</span>
        </div>

        <div class="metric-card danger">
            <div>
                <span class="metric-label">Rejected / Returned</span>
                <div class="metric-value">{{ $rejectedDocuments ?? 0 }}</div>
            </div>
            <span class="metric-desc">Documents returned to initiator</span>
        </div>

        <div class="metric-card warning">
            <div>
                <span class="metric-label">Pending Review</span>
                <div class="metric-value">{{ $pendingDocuments ?? 0 }}</div>
            </div>
            <span class="metric-desc">Currently in active routing</span>
        </div>
    </div>

    <!-- Tables & Details Grid -->
    <div class="charts-grid">
        <div class="chart-card">
            <h3 class="chart-title">Documents by Workflow Template</h3>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Workflow</th>
                        <th>Documents</th>
                        <th>Progress Ratio</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentsByWorkflow ?? [] as $workflowName => $count)
                        @php
                            $percentage = ($totalDocuments > 0) ? round(($count / $totalDocuments) * 100) : 0;
                        @endphp
                        <tr>
                            <td style="font-weight:600;">{{ $workflowName }}</td>
                            <td>{{ $count }}</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="progress-bar-container" style="flex:1;">
                                        <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                    <span style="font-size:11px; font-weight:700; color:#475569;">{{ $percentage }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; color:#94a3b8;">No workflow activity recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="chart-card">
            <h3 class="chart-title">Pending Tasks by Approver Role</h3>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Assigned Role</th>
                        <th>Pending Action</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingByRole ?? [] as $roleName => $count)
                        <tr>
                            <td style="font-weight:600;">{{ $roleName }}</td>
                            <td>{{ $count }} pending</td>
                            <td>
                                <span class="timeline-badge current" style="font-size:10px;">Awaiting Review</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; color:#94a3b8;">No pending tasks. All systems clear!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
