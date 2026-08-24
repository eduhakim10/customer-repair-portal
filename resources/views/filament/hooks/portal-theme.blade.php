<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

<style>
    /* ── Filament shell overrides ── */
    .fi-body.fi-panel-customer {
        background: #f9fafb !important;
        font-family: Inter, system-ui, sans-serif !important;
    }

    .fi-main {
        max-width: 100% !important;
    }

    .fi-page > section {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
        gap: 1.25rem !important;
    }

    .fi-page .fi-header:has(.fi-header-heading:empty) {
        display: none !important;
    }

    .fi-sidebar {
        background: #fff !important;
        border-right: 1px solid rgba(15, 23, 42, 0.07) !important;
        box-shadow: none !important;
        width: 16rem !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .fi-layout {
        display: flex !important;
        min-height: 100vh;
    }

    .fi-main-ctn {
        display: flex !important;
        flex: 1 !important;
        flex-direction: column !important;
        opacity: 1 !important;
        min-width: 0;
    }

    .fi-main-sidebar {
        position: sticky !important;
        top: 0;
        height: 100vh !important;
        flex-shrink: 0;
    }

    .fi-sidebar-nav-groups {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .fi-sidebar-group-items {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .fi-sidebar-header {
        height: 3.5rem !important;
        border-bottom: 1px solid rgba(15, 23, 42, 0.07) !important;
        box-shadow: none !important;
        padding-inline: 1rem !important;
    }

    .fi-sidebar-nav {
        padding-inline: 0.75rem !important;
        gap: 1rem !important;
    }

    .fi-sidebar-group-label {
        font-size: 10.5px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.06em !important;
        color: #9ca3af !important;
        padding-inline: 0.5rem !important;
    }

    .fi-sidebar-item-button {
        border-radius: 8px !important;
        padding: 0.5rem 0.75rem !important;
    }

    .fi-sidebar-item.fi-active .fi-sidebar-item-button {
        background: #fff1f2 !important;
    }

    .fi-sidebar-item.fi-active .fi-sidebar-item-label,
    .fi-sidebar-item.fi-active .fi-sidebar-item-icon {
        color: #c8102e !important;
        font-weight: 600 !important;
    }

    .fi-sidebar-item-icon svg,
    .fi-topbar svg,
    .fi-dropdown-list-item-icon svg,
    .fi-icon-btn svg {
        width: 1.125rem !important;
        height: 1.125rem !important;
        max-width: 1.125rem !important;
        max-height: 1.125rem !important;
    }

    .fi-sidebar-item-icon {
        width: 1rem !important;
        height: 1rem !important;
    }

    .fi-avatar,
    .fi-user-avatar,
    .fi-user-avatar img {
        width: 2rem !important;
        height: 2rem !important;
        max-width: 2rem !important;
        max-height: 2rem !important;
        font-size: 0.7rem !important;
    }

    .fi-topbar {
        height: 3.5rem !important;
        background: #fff !important;
        border-bottom: 1px solid rgba(15, 23, 42, 0.07) !important;
        box-shadow: none !important;
    }

    .fi-topbar nav {
        font-size: 13px;
        color: #9ca3af;
    }

    .fi-topbar nav .fi-breadcrumbs-item:last-child {
        color: #111827 !important;
        font-weight: 600;
    }

    .portal-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .portal-brand-mark {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #c8102e 0%, #8b0b1f 100%);
        color: #fff;
        font-weight: 800;
        font-size: 9px;
        letter-spacing: 0.04em;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .portal-brand-name {
        font-size: 12.5px;
        font-weight: 700;
        line-height: 1.2;
        color: #111827;
    }

    .portal-brand-sub {
        font-size: 10px;
        color: #9ca3af;
        line-height: 1.2;
    }

    /* Sidebar footer (prototype) */
    .portal-sidebar-footer {
        margin-top: auto;
        padding: 12px;
        border-top: 1px solid rgba(15, 23, 42, 0.07);
    }

    .portal-sb-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border-radius: 8px;
    }

    .portal-sb-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #c8102e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .portal-sb-user-info {
        flex: 1;
        min-width: 0;
    }

    .portal-sb-uname {
        font-size: 12.5px;
        font-weight: 600;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .portal-sb-uemail {
        font-size: 11px;
        color: #9ca3af;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .portal-sb-logout-form {
        margin: 0;
    }

    .portal-sb-logout {
        display: flex;
        align-items: center;
        gap: 7px;
        width: 100%;
        font-size: 12.5px;
        color: #9ca3af;
        padding: 6px 8px;
        margin-top: 2px;
        border-radius: 8px;
        border: none;
        background: none;
        cursor: pointer;
        font-family: inherit;
    }

    .portal-sb-logout:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .fi-sidebar-nav {
        flex: 1;
    }

    .fi-sidebar-group-collapse-button {
        display: none !important;
    }

    /* ── Portal page content (prototype) ── */
    .portal-page {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #c8102e 0%, #8b0b1f 100%);
        border-radius: 14px;
        padding: 22px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #fff;
    }

    .wb-greeting { font-size: 15px; opacity: 0.85; }
    .wb-name { font-size: 22px; font-weight: 800; margin-top: 2px; }
    .wb-sub { font-size: 12.5px; opacity: 0.7; margin-top: 4px; }
    .wb-icon { font-size: 48px; opacity: 0.15; }

    .dash-period {
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.07);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 14px 18px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dash-period-error {
        width: 100%;
        font-size: 12px;
        color: #dc2626;
        margin-top: -4px;
    }

    .dash-period-title {
        font-size: 13px;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dash-period-title i { color: #c8102e; }
    .dash-period-hint { font-size: 12px; color: #6b7280; margin-top: 4px; }

    .dash-period-controls {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        flex-wrap: wrap;
    }

    .dash-period-field span {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .dash-period-field input[type=date] {
        height: 34px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0 10px;
        font-size: 13px;
        color: #111827;
        background: #fff;
        font-family: inherit;
    }

    .dash-period-field input[type=date]:focus {
        outline: none;
        border-color: #c8102e;
        box-shadow: 0 0 0 2px rgba(200, 16, 46, 0.1);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
    }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.07);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 18px 20px;
    }

    .stat-desc {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
        line-height: 1.35;
    }

    .stat-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 8px;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #111827;
        line-height: 1;
    }

    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .widget {
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.07);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .widget-hd {
        padding: 14px 20px;
        border-bottom: 1px solid rgba(15, 23, 42, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .widget-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #111827;
    }

    .widget-body {
        padding: 20px;
    }

    .cols-3-2 {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 16px;
    }

    @media (max-width: 1024px) {
        .cols-3-2 { grid-template-columns: 1fr; }
    }

    table.mtable {
        width: 100%;
        border-collapse: collapse;
    }

    .mtable th {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 8px 16px;
        background: #f9fafb;
        border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        text-align: left;
    }

    .mtable td {
        padding: 10px 16px;
        border-bottom: 1px solid rgba(15, 23, 42, 0.04);
        font-size: 12.5px;
        color: #374151;
        vertical-align: middle;
    }

    .mtable tr:last-child td { border-bottom: none; }
    .mtable tr:hover td { background: #f9fafb; }

    .tfoot-link {
        padding: 10px 16px;
        border-top: 1px solid rgba(15, 23, 42, 0.05);
        text-align: center;
    }

    .tfoot-link a {
        font-size: 12.5px;
        color: #c8102e;
        font-weight: 600;
        text-decoration: none;
    }

    .tfoot-link a:hover { color: #a80d25; text-decoration: underline; }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.6;
    }

    .badge-success { background: #f0fdf4; color: #15803d; }
    .badge-warning { background: #fefce8; color: #92400e; }
    .badge-danger { background: #fef2f2; color: #b91c1c; }
    .badge-info { background: #eff6ff; color: #1d4ed8; }
    .badge-gray { background: #f3f4f6; color: #374151; }
    .badge-primary { background: #fff1f2; color: #c8102e; }

    .btn-portal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #d1d5db;
        background: #fff;
        color: #374151;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
    }

    .btn-portal:hover { background: #f9fafb; color: #374151; }

    .btn-portal-primary {
        background: #c8102e;
        border-color: #c8102e;
        color: #fff;
    }

    .btn-portal-primary:hover { background: #a80d25; color: #fff; }

    .btn-portal-icon {
        width: 30px;
        height: 30px;
        padding: 0;
        justify-content: center;
        border-radius: 6px;
    }

    .service-card {
        padding: 14px 0;
        border-bottom: 1px solid rgba(15, 23, 42, 0.06);
    }

    .service-card:last-child { border-bottom: none; padding-bottom: 0; }
    .service-card:first-child { padding-top: 0; }

    .service-hd {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .service-vehicle { font-size: 13px; font-weight: 700; color: #111827; }
    .service-plat { font-size: 11.5px; color: #6b7280; margin-top: 1px; }
    .service-spk { font-size: 11px; font-weight: 600; color: #c8102e; white-space: nowrap; }

    .progress-steps {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        position: relative;
    }

    .progress-steps::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 12%;
        right: 12%;
        height: 2px;
        background: #e5e7eb;
        z-index: 0;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .step-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #9ca3af;
    }

    .progress-step.done .step-dot {
        background: #16a34a;
        border-color: #16a34a;
        color: #fff;
    }

    .progress-step.active .step-dot {
        background: #fff1f2;
        border-color: #c8102e;
        color: #c8102e;
        box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.12);
    }

    .step-label {
        font-size: 9.5px;
        font-weight: 600;
        color: #9ca3af;
        line-height: 1.3;
        max-width: 72px;
    }

    .progress-step.done .step-label { color: #16a34a; }
    .progress-step.active .step-label { color: #c8102e; }

    .progress-step-btn {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font: inherit;
    }

    .progress-step-btn:hover .step-dot {
        border-color: #c8102e;
        color: #c8102e;
    }

    .progress-step-btn:hover .step-label {
        color: #c8102e;
        text-decoration: underline;
    }

    .portal-photo-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .portal-photo-modal {
        background: #fff;
        border-radius: 12px;
        max-width: 900px;
        width: 100%;
        max-height: 90vh;
        overflow: auto;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    }

    .portal-photo-modal-hd {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 700;
        color: #111827;
    }

    .portal-photo-modal-close {
        background: none;
        border: none;
        font-size: 18px;
        color: #6b7280;
        cursor: pointer;
        padding: 4px 8px;
    }

    .portal-photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
        padding: 16px 20px 20px;
    }

    .portal-photo-item {
        display: block;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .portal-photo-item img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        display: block;
    }

    .service-meta {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .portal-empty {
        padding: 24px;
        text-align: center;
        color: #9ca3af;
        font-size: 13px;
    }

    .ref-link { font-weight: 700; color: #c8102e; text-decoration: none; }
    .ref-link:hover { color: #a80d25; text-decoration: underline; }
    .cell-sub { font-size: 11px; color: #9ca3af; }
    .cell-muted { font-size: 12px; color: #6b7280; }

    /* Quotations list */
    .page-hd { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 4px; }
    .page-title { font-size: 20px; font-weight: 800; color: #111827; }
    .page-sub { font-size: 13px; color: #6b7280; margin-top: 2px; }

    .resource-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.07);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .portal-tabs { display: flex; border-bottom: 1px solid rgba(15, 23, 42, 0.07); padding: 0 20px; overflow-x: auto; }
    .portal-tab {
        display: inline-flex; align-items: center; gap: 6px; padding: 11px 12px; font-size: 13px; font-weight: 600;
        color: #6b7280; cursor: pointer; border: none; background: none; border-bottom: 2px solid transparent;
        margin-bottom: -1px; font-family: inherit; white-space: nowrap;
    }
    .portal-tab:hover { color: #374151; }
    .portal-tab.active { color: #c8102e; border-bottom-color: #c8102e; }
    .tab-count { background: #f3f4f6; color: #374151; font-size: 10.5px; padding: 1px 6px; border-radius: 999px; font-weight: 600; }
    .portal-tab.active .tab-count { background: #fff1f2; color: #c8102e; }

    .tbl-toolbar { display: flex; align-items: center; gap: 8px; padding: 12px 16px; border-bottom: 1px solid rgba(15, 23, 42, 0.06); flex-wrap: wrap; }
    .search-box { position: relative; }
    .search-box input {
        padding: 6px 10px 6px 32px; border: 1px solid #d1d5db; border-radius: 7px; font-size: 13px; outline: none;
        width: 240px; font-family: inherit; color: #374151;
    }
    .search-box input:focus { border-color: #c8102e; box-shadow: 0 0 0 2px rgba(200, 16, 46, 0.1); }
    .search-box i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 12px; pointer-events: none; }
    .tbl-toolbar-right { margin-left: auto; display: flex; gap: 8px; align-items: center; }
    .filter-dropdown { position: relative; }
    .filter-panel {
        position: absolute; top: calc(100% + 6px); right: 0; background: #fff; border: 1px solid rgba(15, 23, 42, 0.09);
        border-radius: 10px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); padding: 16px; min-width: 300px; z-index: 200; display: none;
    }
    .filter-panel.open { display: block; }
    .filter-panel-hd { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; font-size: 13px; font-weight: 700; }
    .filter-field { margin-bottom: 12px; }
    .filter-field label { display: block; font-size: 12px; font-weight: 500; color: #374151; margin-bottom: 4px; }
    .filter-field select, .filter-field input {
        width: 100%; padding: 6px 10px; border: 1px solid #d1d5db; border-radius: 7px; font-size: 13px; outline: none; font-family: inherit;
    }

    table.ftable { width: 100%; border-collapse: collapse; }
    .ftable thead th {
        padding: 9px 14px; font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;
        background: #f9fafb; border-bottom: 1px solid rgba(15, 23, 42, 0.07); text-align: left; white-space: nowrap;
    }
    .ftable tbody td { padding: 11px 14px; border-bottom: 1px solid rgba(15, 23, 42, 0.04); font-size: 13px; color: #374151; vertical-align: middle; }
    .ftable tbody tr:hover td { background: #f9fafb; }
    .ftable input[type=checkbox] { accent-color: #c8102e; width: 14px; height: 14px; cursor: pointer; }

    .row-actions { display: flex; gap: 4px; align-items: center; flex-wrap: wrap; }
    .btn-portal-sm { padding: 5px 9px; font-size: 11px; }
    .btn-portal-success { background: #16a34a; border-color: #16a34a; color: #fff; }
    .btn-portal-success:hover { background: #15803d; color: #fff; }
    .btn-portal-danger-outline { color: #dc2626; border-color: #fca5a5; background: #fff; }
    .btn-portal-danger-outline:hover { background: #fef2f2; }
    .btn-portal-block { width: 100%; justify-content: center; }
    .badge-purple { background: #f5f3ff; color: #6d28d9; }

    .portal-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 4px;
    }

    .portal-alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .portal-alert-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .portal-alert i { margin-top: 2px; flex-shrink: 0; }

    .bulk-bar {
        position: sticky; bottom: 0; background: #1e293b; padding: 10px 20px; display: flex; align-items: center; gap: 12px;
        font-size: 13px; color: #fff; border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    .bulk-count { font-weight: 700; }
    .bulk-actions { margin-left: auto; display: flex; gap: 8px; }
    .bulk-btn { padding: 5px 12px; border-radius: 6px; font-size: 12.5px; font-weight: 600; cursor: pointer; border: 1.5px solid; font-family: inherit; }
    .bulk-btn-approve { background: rgba(22, 163, 74, 0.2); color: #86efac; border-color: rgba(22, 163, 74, 0.4); }
    .bulk-btn-reject { background: rgba(220, 38, 38, 0.2); color: #fca5a5; border-color: rgba(220, 38, 38, 0.4); }
    .bulk-close { background: none; border: none; color: #94a3b8; cursor: pointer; margin-left: 8px; font-size: 14px; }

    .pagination { display: flex; align-items: center; justify-content: space-between; padding: 10px 16px; border-top: 1px solid rgba(15, 23, 42, 0.06); font-size: 12.5px; color: #6b7280; }

    /* Loading overlay (quotations list, tabs, pagination) */
    .portal-loading-host { position: relative; }
    .portal-loading-overlay {
        display: none;
        position: absolute;
        inset: 0;
        z-index: 20;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.72);
        backdrop-filter: blur(2px);
        border-radius: inherit;
    }
    .portal-loading-overlay.is-visible { display: flex; }
    .portal-loading-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 16px 22px;
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }
    .portal-spinner {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 3px solid #fecaca;
        border-top-color: #c8102e;
        animation: portal-spin 0.7s linear infinite;
    }
    @keyframes portal-spin {
        to { transform: rotate(360deg); }
    }

    /* Quotation detail */
    .record-header {
        background: #fff; border: 1px solid rgba(15, 23, 42, 0.07); border-radius: 12px; padding: 16px 20px; margin-bottom: 16px;
        display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }
    .rh-id { font-size: 18px; font-weight: 800; color: #111827; }
    .rh-sub { font-size: 12.5px; color: #6b7280; margin-top: 2px; }
    .rh-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

    .view-layout { display: grid; grid-template-columns: 1fr 320px; gap: 16px; }
    @media (max-width: 1024px) { .view-layout { grid-template-columns: 1fr; } }

    .portal-card { background: #fff; border-radius: 12px; border: 1px solid rgba(15, 23, 42, 0.07); box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04); overflow: hidden; margin-bottom: 16px; }
    .portal-card-hd { padding: 14px 20px; border-bottom: 1px solid rgba(15, 23, 42, 0.06); }
    .portal-card-title { font-size: 13.5px; font-weight: 700; color: #111827; }
    .portal-card-body { padding: 20px; }

    .ilist { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    @media (max-width: 768px) { .ilist { grid-template-columns: 1fr; } }
    .il-label { font-size: 10.5px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px; }
    .il-value { font-size: 13.5px; font-weight: 500; color: #111827; }
    .il-value.primary { color: #c8102e; font-weight: 700; }

    table.itable { width: 100%; border-collapse: collapse; }
    .itable th { font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; padding: 8px 14px; background: #f9fafb; border-bottom: 1px solid rgba(15, 23, 42, 0.07); text-align: left; }
    .itable th.num, .itable td.num { text-align: right; }
    .itable td { padding: 10px 14px; border-bottom: 1px solid rgba(15, 23, 42, 0.04); font-size: 12.5px; color: #374151; vertical-align: middle; }

    .total-area { border-top: 2px solid rgba(15, 23, 42, 0.1); padding: 12px 14px; }
    .total-row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 13px; }
    .total-row.grand { font-size: 15px; font-weight: 800; color: #c8102e; border-top: 1px dashed #e5e7eb; padding-top: 10px; margin-top: 6px; }

    .side-section { background: #fff; border-radius: 12px; border: 1px solid rgba(15, 23, 42, 0.07); overflow: hidden; margin-bottom: 12px; }
    .side-hd { padding: 12px 16px; border-bottom: 1px solid rgba(15, 23, 42, 0.06); font-size: 12.5px; font-weight: 700; color: #111827; }
    .side-body { padding: 14px 16px; }
    .side-actions { display: flex; flex-direction: column; gap: 8px; }

    .timeline { display: flex; flex-direction: column; }
    .tl-item { display: flex; gap: 12px; padding-bottom: 16px; position: relative; }
    .tl-item:last-child { padding-bottom: 0; }
    .tl-left { display: flex; flex-direction: column; align-items: center; width: 22px; flex-shrink: 0; }
    .tl-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; margin-top: 3px; }
    .tl-dot.done { background: #16a34a; box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15); }
    .tl-dot.active { background: #c8102e; box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.15); }
    .tl-dot.pending { background: #e5e7eb; }
    .tl-line { flex: 1; width: 1.5px; background: #e5e7eb; margin: 4px 0; }
    .tl-item:last-child .tl-line { display: none; }
    .tl-title { font-size: 13px; font-weight: 600; color: #111827; }
    .tl-title.pending { color: #9ca3af; }
    .tl-title.active { color: #c8102e; }
    .tl-time { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }
    .tl-note { font-size: 12px; color: #4b5563; margin-top: 5px; background: #f9fafb; border-radius: 6px; padding: 6px 9px; }

    .filter-panel-ft {
        display: flex; gap: 6px; justify-content: flex-end;
        border-top: 1px solid #f3f4f6; padding-top: 12px; margin-top: 4px;
    }

    .ftable thead th.sortable { cursor: pointer; user-select: none; }
    .ftable thead th.sortable:hover { color: #374151; }
    .sort-icon { color: #d1d5db; margin-left: 4px; font-size: 10px; }
    .sort-icon.active { color: #c8102e; }
    .ftable tbody tr:last-child td { border-bottom: none; }

    .page-btns { display: flex; gap: 3px; }
    .page-btn {
        min-width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
        border-radius: 6px; border: 1px solid #e5e7eb; background: #fff; color: #374151;
        cursor: pointer; font-size: 12.5px; padding: 0 6px; font-family: inherit;
    }
    .page-btn.active { background: #c8102e; border-color: #c8102e; color: #fff; }
    .page-btn:hover:not(.active):not(:disabled) { background: #f9fafb; }
    .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    .itable tr.group-hd td {
        background: #f9fafb; font-size: 11px; font-weight: 700; color: #6b7280;
        text-transform: uppercase; letter-spacing: 0.04em; padding: 8px 14px;
    }
    .itable tr.subtotal td { background: #fafafa; border-bottom: 1px solid rgba(15, 23, 42, 0.06); }

    /* Prototype modals */
    .portal-modal-overlay {
        position: fixed; inset: 0; background: rgba(0, 0, 0, 0.4);
        display: flex; align-items: center; justify-content: center;
        z-index: 9999; padding: 20px;
    }
    .portal-modal {
        background: #fff; border-radius: 14px; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        width: 100%; max-width: 480px; overflow: hidden;
    }
    .portal-modal-hd {
        padding: 18px 20px; border-bottom: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
    }
    .portal-modal-title { font-size: 15px; font-weight: 700; color: #111827; }
    .portal-modal-close {
        width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
        border-radius: 6px; cursor: pointer; color: #9ca3af; background: none; border: none; font-size: 14px;
    }
    .portal-modal-close:hover { background: #f3f4f6; color: #374151; }
    .portal-modal-bd { padding: 20px; }
    .portal-modal-ft {
        padding: 14px 20px; border-top: 1px solid #e5e7eb;
        display: flex; gap: 8px; justify-content: flex-end;
    }

    .portal-field { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
    .portal-field:last-child { margin-bottom: 0; }
    .portal-field label { font-size: 12.5px; font-weight: 500; color: #374151; }
    .portal-field label .req { color: #c8102e; }
    .portal-field input,
    .portal-field select,
    .portal-field textarea {
        padding: 7px 11px; border: 1px solid #d1d5db; border-radius: 7px;
        font-size: 13px; color: #111827; background: #fff; outline: none; font-family: inherit; width: 100%;
    }
    .portal-field input:focus,
    .portal-field select:focus,
    .portal-field textarea:focus {
        border-color: #c8102e; box-shadow: 0 0 0 2px rgba(200, 16, 46, 0.1);
    }
    .field-error { font-size: 11.5px; color: #dc2626; margin-top: 2px; }

    .upload-zone {
        border: 2px dashed #d1d5db; border-radius: 8px; padding: 20px;
        text-align: center; cursor: pointer; background: #f9fafb; display: block; position: relative;
    }
    .upload-zone:hover { border-color: #c8102e; background: #fff8f8; }
    .upload-zone i { font-size: 22px; color: #9ca3af; margin-bottom: 6px; display: block; }
    .upload-zone p { font-size: 12.5px; color: #6b7280; margin: 0; }
    .upload-hint { font-size: 11px; color: #9ca3af; }
    .upload-zone input[type=file] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
</style>
