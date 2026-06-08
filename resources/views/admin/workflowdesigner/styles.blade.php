<style>
    .workflow-designer-container {
        font-family: 'Figtree', sans-serif;
        background: radial-gradient(circle at 10% 20%, rgba(244, 246, 249, 1) 0%, rgba(238, 242, 247, 1) 90%);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(226, 232, 240, 0.8);
        margin-top: 16px;
        animation: fadeIn 0.4s ease-out;
    }

    .designer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        border-bottom: 2px dashed rgba(226, 232, 240, 1);
        padding-bottom: 16px;
    }

    .designer-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .designer-subtitle {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 4px;
    }

    .steps-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 24px;
    }

    .step-node-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .step-node {
        flex: 1;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        display: grid;
        grid-template-columns: auto 1fr 1fr 1fr 1fr auto;
        align-items: center;
        gap: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .step-node::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #4f46e5, #6366f1);
        opacity: 0.8;
    }

    .step-node:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .step-badge {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }

    .step-input-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .step-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .step-field {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.875rem;
        color: #334155;
        outline: none;
        transition: border-color 0.2s, background-color 0.2s;
    }

    .step-field:focus {
        border-color: #6366f1;
        background: white;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .step-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        color: #64748b;
    }

    .action-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #cbd5e1;
    }

    .action-btn.delete:hover {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fca5a5;
    }

    .add-step-btn-container {
        display: flex;
        justify-content: center;
        margin-top: 12px;
    }

    .designer-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .designer-btn.primary {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .designer-btn.primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
    }

    .designer-btn.secondary {
        background: white;
        border: 1px solid #d1d5db;
        color: #374151;
    }

    .designer-btn.secondary:hover {
        background: #f9fafb;
    }

    .footer-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        border-top: 2px dashed rgba(226, 232, 240, 1);
        padding-top: 20px;
    }

    .alert-success {
        background-color: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
