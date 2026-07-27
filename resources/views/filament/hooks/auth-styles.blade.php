<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

<style>
    /* Force light mode on login */
    html.fi, html.fi body {
        background: #f9fafb !important;
        font-family: Inter, system-ui, sans-serif !important;
    }

    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: #f9fafb;
    }

    .auth-container {
        width: 100%;
        max-width: 400px;
    }

    .auth-brand {
        text-align: center;
        margin-bottom: 28px;
    }

    .auth-logo-mark {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #c8102e 0%, #8b0b1f 100%);
        color: #fff;
        font-weight: 800;
        font-size: 15px;
        letter-spacing: 0.04em;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(200, 16, 46, 0.25);
    }

    .auth-brand-name {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin-top: 10px;
    }

    .auth-brand-sub {
        font-size: 13px;
        color: #6b7280;
        margin-top: 2px;
    }

    .auth-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .auth-card-header {
        padding: 24px 28px 0;
    }

    .auth-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .auth-card-desc {
        font-size: 13px;
        color: #6b7280;
        margin: 4px 0 0;
    }

    .auth-card-body {
        padding: 24px 28px;
    }

    .demo-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 16px;
        font-size: 12.5px;
        color: #14532d;
    }

    .demo-box strong {
        display: block;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #15803d;
        margin-bottom: 4px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 16px;
    }

    .field label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
    }

    .field input[type="email"],
    .field input[type="password"],
    .field input[type="text"] {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        color: #111827;
        background: #fff;
        outline: none;
        font-family: inherit;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
    }

    .field input:focus {
        border-color: #c8102e;
        box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.1);
    }

    .field-error {
        font-size: 12px;
        color: #dc2626;
        margin-top: 2px;
    }

    .password-wrap {
        position: relative;
    }

    .password-wrap input {
        padding-right: 38px !important;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 0;
    }

    .password-toggle:hover {
        color: #6b7280;
    }

    .remember-row {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .remember-label {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        color: #374151;
        cursor: pointer;
        user-select: none;
    }

    .remember-label input {
        accent-color: #c8102e;
        width: 14px;
        height: 14px;
    }

    .btn-signin {
        width: 100%;
        padding: 9px 14px;
        background: #c8102e;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.15s;
    }

    .btn-signin:hover:not(:disabled) {
        background: #a80d25;
    }

    .btn-signin:disabled {
        opacity: 0.7;
        cursor: wait;
    }

    .auth-divider {
        height: 1px;
        background: #f3f4f6;
        margin: 20px 0;
    }

    .auth-help {
        text-align: center;
        font-size: 12.5px;
        color: #9ca3af;
        margin: 0;
    }

    .auth-help a {
        color: #c8102e;
        text-decoration: none;
        font-weight: 500;
    }

    .auth-help a:hover {
        color: #a80d25;
        text-decoration: underline;
    }

    .auth-footer {
        text-align: center;
        margin-top: 28px;
        font-size: 12px;
        color: #9ca3af;
    }

    .auth-footer strong {
        color: #374151;
    }
</style>
