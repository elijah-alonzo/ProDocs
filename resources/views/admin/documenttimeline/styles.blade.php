<style>
    .timeline-wrapper {
        font-family: 'Figtree', sans-serif;
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        max-width: 600px;
        margin: 0 auto;
    }

    .timeline-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .timeline-steps {
        position: relative;
        padding-left: 32px;
    }

    .timeline-steps::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background-color: #cbd5e1;
    }

    .timeline-step {
        position: relative;
        margin-bottom: 24px;
        animation: fadeIn 0.3s ease-out;
    }

    .timeline-step:last-child {
        margin-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: -32px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #ffffff;
        z-index: 1;
        box-shadow: 0 0 0 1px #cbd5e1;
        transition: all 0.2s ease;
    }

    .timeline-icon.approved {
        background-color: #10b981;
        box-shadow: 0 0 0 1px #10b981;
    }

    .timeline-icon.rejected {
        background-color: #ef4444;
        box-shadow: 0 0 0 1px #ef4444;
    }

    .timeline-icon.current {
        background-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }

    .timeline-content {
        background: #f8fafc;
        border-radius: 12px;
        padding: 14px 18px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .timeline-content:hover {
        transform: translateX(2px);
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .timeline-stage-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1e293b;
    }

    .timeline-date {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .timeline-actor {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .timeline-remarks {
        background-color: #ffffff;
        border-left: 3px solid #cbd5e1;
        padding: 8px 12px;
        font-size: 0.825rem;
        color: #475569;
        border-radius: 4px;
        margin-top: 8px;
        font-style: italic;
    }

    .timeline-remarks.approved {
        border-left-color: #10b981;
    }

    .timeline-remarks.rejected {
        border-left-color: #ef4444;
    }

    .timeline-badge {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 2px 6px;
        border-radius: 4px;
        background-color: #e2e8f0;
        color: #475569;
    }

    .timeline-badge.approved {
        background-color: #ecfdf5;
        color: #047857;
    }

    .timeline-badge.rejected {
        background-color: #fef2f2;
        color: #b91c1c;
    }

    .timeline-badge.current {
        background-color: #eff6ff;
        color: #1d4ed8;
    }
</style>
