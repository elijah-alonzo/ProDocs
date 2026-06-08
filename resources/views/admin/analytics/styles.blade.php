<style>
    .analytics-dashboard {
        font-family: 'Figtree', sans-serif;
        display: flex;
        flex-direction: column;
        gap: 24px;
        background: #f8fafc;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .analytics-header {
        margin-bottom: 8px;
    }

    .analytics-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .analytics-subtitle {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 4px;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .metric-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: #e2e8f0;
    }

    .metric-card.primary::before { background: linear-gradient(90deg, #4f46e5, #6366f1); }
    .metric-card.success::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .metric-card.danger::before { background: linear-gradient(90deg, #ef4444, #f87171); }
    .metric-card.warning::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

    .metric-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        margin: 12px 0 4px;
    }

    .metric-desc {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        min-height: 300px;
    }

    .chart-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 12px;
    }

    .stats-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .stats-table th {
        text-align: left;
        padding: 10px 12px;
        font-weight: 600;
        color: #475569;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .stats-table td {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .stats-table tr:hover {
        background: #f8fafc;
    }

    .progress-bar-container {
        width: 100%;
        background: #e2e8f0;
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: #4f46e5;
        border-radius: 4px;
    }
</style>
