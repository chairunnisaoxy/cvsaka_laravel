<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Penggajian CV Saka Pratama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --gray: #6c757d;
            --border: #e9ecef;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
            --saw-primary: #673ab7;
            --saw-secondary: #9c27b0;
            --saw-light: #f3e5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Layout with Sidebar */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar-wrapper {
            width: 280px;
            background: linear-gradient(180deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .sidebar-header p {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .user-profile {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile small {
            font-size: 0.75rem;
            opacity: 0.7;
            display: block;
            margin-top: 0.5rem;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        .user-profile h3 {
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .user-profile p {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent);
        }

        .menu-item i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .menu-item span {
            font-weight: 500;
        }

        .menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 1.5rem;
        }

        /* Main Content Area */
        .main-content-wrapper {
            flex: 1;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navigation */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary) !important;
        }

        .navbar-brand i {
            color: var(--secondary);
        }

        .user-dropdown .dropdown-toggle {
            color: var(--dark);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .user-dropdown .dropdown-toggle:hover {
            background: var(--light);
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff" fill-opacity="0.05" points="0,800 1000,400 1000,1000 0,1000"/></svg>');
            background-size: cover;
        }

        .welcome-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }

        .welcome-content p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .welcome-icon {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.2);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--secondary));
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--accent), #2980b9);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.3rem;
        }

        .stat-content h3 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-content .number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }

        .stat-details {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: var(--gray);
        }

        /* Progress Section */
        .progress-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .progress-large {
            height: 30px;
            border-radius: 15px;
            overflow: hidden;
        }

        .progress-large .progress-bar {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .target-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .target-stat-item {
            text-align: center;
            padding: 1rem;
            background: var(--light);
            border-radius: 8px;
        }

        .target-stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .target-stat-label {
            font-size: 0.8rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 2rem;
            height: 400px;
        }

        /* SAW Section */
        .saw-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 2rem;
            border-top: 4px solid var(--saw-primary);
        }

        .saw-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .saw-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .saw-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--saw-primary), var(--saw-secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .saw-title-text h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .saw-title-text p {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 0;
        }

        .saw-info-badges {
            display: flex;
            gap: 1rem;
        }

        .saw-badge {
            background: var(--saw-light);
            border: 1px solid rgba(103, 58, 183, 0.2);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            text-align: center;
        }

        .saw-badge-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--saw-primary);
        }

        .saw-badge-label {
            font-size: 0.75rem;
            color: var(--gray);
            text-transform: uppercase;
        }

        .saw-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 992px) {
            .saw-content {
                grid-template-columns: 1fr;
            }
        }

        .saw-ranking {
            background: var(--saw-light);
            border-radius: 10px;
            padding: 1.5rem;
        }

        .saw-ranking-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--saw-primary);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .saw-ranking-title i {
            color: var(--saw-primary);
        }

        .saw-ranking-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .saw-rank-item {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            border: 1px solid rgba(103, 58, 183, 0.1);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .saw-rank-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: rgba(103, 58, 183, 0.3);
        }

        .saw-rank-item.top-rank {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.05), rgba(255, 193, 7, 0.02));
            border-color: #ffc107;
        }

        .saw-rank-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .saw-rank-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .rank-1 .saw-rank-badge {
            background: linear-gradient(135deg, #FFD700, #FFA000);
            color: #000;
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.3);
        }

        .rank-2 .saw-rank-badge {
            background: linear-gradient(135deg, #C0C0C0, #9E9E9E);
            color: white;
            box-shadow: 0 2px 6px rgba(158, 158, 158, 0.3);
        }

        .rank-3 .saw-rank-badge {
            background: linear-gradient(135deg, #CD7F32, #8D6E63);
            color: white;
            box-shadow: 0 2px 6px rgba(141, 110, 99, 0.3);
        }

        .rank-4 .saw-rank-badge,
        .rank-5 .saw-rank-badge {
            background: linear-gradient(135deg, var(--saw-primary), var(--saw-secondary));
            color: white;
            box-shadow: 0 2px 6px rgba(103, 58, 183, 0.3);
        }

        .saw-rank-name {
            flex: 1;
        }

        .saw-rank-name h6 {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .saw-rank-score {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--saw-primary);
        }

        .saw-rank-details {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.75rem;
        }

        .saw-detail-item {
            flex: 1;
        }

        .saw-detail-label {
            font-size: 0.75rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .saw-detail-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--primary);
        }

        .saw-criteria {
            background: white;
            border: 1px solid rgba(103, 58, 183, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
        }

        .saw-criteria-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--saw-primary);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .saw-criteria-title i {
            color: var(--saw-primary);
        }

        .saw-criteria-details {
            margin-bottom: 1.5rem;
        }

        .criteria-item {
            margin-bottom: 1rem;
        }

        .criteria-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .criteria-name {
            font-weight: 600;
            color: var(--primary);
        }

        .criteria-weight {
            font-weight: 600;
            color: var(--saw-primary);
        }

        .criteria-bar {
            height: 8px;
            background: var(--light);
            border-radius: 4px;
            overflow: hidden;
        }

        .criteria-progress {
            height: 100%;
            border-radius: 4px;
        }

        .criteria-info {
            font-size: 0.85rem;
            color: var(--gray);
            margin-top: 0.25rem;
        }

        .saw-formula {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            border-left: 3px solid var(--saw-primary);
        }

        .formula-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--saw-primary);
            margin-bottom: 0.5rem;
        }

        .formula-text {
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.4;
        }

        /* KPI Performance */
        .kpi-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.75rem;
            color: var(--accent);
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .kpi-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .kpi-header {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            padding: 1.25rem;
            display: flex;
            align-items: center;
        }

        .kpi-header i {
            font-size: 1.5rem;
            margin-right: 0.75rem;
        }

        .kpi-header h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0;
        }

        .kpi-body {
            padding: 1.5rem;
        }

        .ranking-badge {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 0.8rem;
        }

        .rank-1 {
            background-color: #FFD700;
            color: #000 !important;
        }

        .rank-2 {
            background-color: #C0C0C0;
        }

        .rank-3 {
            background-color: #CD7F32;
        }

        .rank-4 {
            background-color: #28a745;
        }

        .rank-5 {
            background-color: #17a2b8;
        }

        .performance-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--light);
            border-radius: 8px;
            margin-bottom: 0.75rem;
            border-left: 4px solid var(--accent);
            transition: all 0.3s ease;
        }

        .performance-item:hover {
            transform: translateX(3px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        }

        .performance-content {
            flex: 1;
            margin-left: 1rem;
        }

        .performance-content h6 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--primary);
        }

        .performance-content small {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .performance-stats {
            text-align: right;
        }

        .performance-stats .badge {
            font-size: 0.75rem;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        /* Activity Sections */
        .activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .activity-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .section-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }

        .section-header h3 i {
            margin-right: 0.75rem;
            color: var(--accent);
        }

        .section-header a {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .section-header a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--light);
            border-radius: 8px;
            border-left: 4px solid var(--accent);
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            transform: translateX(3px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--accent);
            font-size: 1rem;
            border: 1px solid var(--border);
        }

        .activity-content {
            flex: 1;
        }

        .activity-content strong {
            display: block;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .activity-content .details {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .activity-badge {
            background: var(--accent);
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-hadir {
            background: #28a745;
        }

        .badge-cuti {
            background: #ffc107;
            color: #212529;
        }

        .badge-tidak-hadir {
            background: #dc3545;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Mobile Sidebar Toggle */
        .mobile-sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 9999;
            display: none;
            background: var(--primary);
            border: none;
            border-radius: 10px;
            width: 45px;
            height: 45px;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .mobile-sidebar-toggle:hover {
            background: var(--secondary);
            transform: scale(1.05);
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 1.5rem;
            text-align: center;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-content-wrapper {
                margin-left: 280px;
            }

            .activity-grid,
            .kpi-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .sidebar-wrapper {
                transform: translateX(-100%);
            }

            .sidebar-wrapper.mobile-open {
                transform: translateX(0);
            }

            .main-content-wrapper {
                margin-left: 0;
            }

            .mobile-sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .saw-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .saw-info-badges {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .welcome-content h1 {
                font-size: 1.5rem;
            }

            .welcome-section {
                padding: 1.5rem;
            }

            .target-stats {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 300px;
            }

            .saw-content {
                grid-template-columns: 1fr;
            }

            .saw-info-badges {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .activity-grid,
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .welcome-section {
                padding: 1.25rem;
            }

            .main-content {
                padding: 1rem;
            }

            .saw-header {
                align-items: stretch;
            }

            .saw-info-badges {
                flex-direction: column;
                gap: 0.5rem;
            }

            .saw-badge {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Sidebar Toggle -->
    <button class="mobile-sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar-wrapper" id="sidebar">
            <div class="sidebar-header">
                <h2>Sistem Penggajian</h2>
                <p>CV Saka Pratama</p>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3>{{ session('karyawan_nama') ?? Auth::guard('karyawan')->user()->nama_karyawan }}</h3>
                <p>{{ ucfirst(session('karyawan_jabatan') ?? Auth::guard('karyawan')->user()->jabatan) }}</p>
                <small>{{ session('karyawan_email') ?? Auth::guard('karyawan')->user()->email }}</small>
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <div class="menu-divider"></div>

                @php
                    $jabatan =
                        session('karyawan_jabatan') ??
                        (Auth::guard('karyawan')->check() ? Auth::guard('karyawan')->user()->jabatan : '');
                @endphp

                @if (in_array($jabatan, ['pemilik', 'supervisor']))
                    <a href="{{ route('karyawan.index') }}" class="menu-item">
                        <i class="fas fa-users"></i>
                        <span>Karyawan</span>
                    </a>
                @endif

                @if ($jabatan == 'supervisor')
                    <a href="{{ route('absensi.index') }}" class="menu-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Absensi</span>
                    </a>
                @endif

                @if (in_array($jabatan, ['pemilik', 'supervisor']))
                    <a href="{{ route('produk.index') }}" class="menu-item">
                        <i class="fas fa-cube"></i>
                        <span>Produk</span>
                    </a>
                @endif

                <a href="#" class="menu-item">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Laporan Penggajian</span>
                </a>

                <div class="menu-divider"></div>

                <a href="{{ route('logout') }}" class="menu-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="main-content-wrapper">
            <!-- Navigation -->
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <a class="navbar-brand" href="{{ route('dashboard') }}">
                            <i class="fas fa-cash-register me-2"></i>Sistem Penggajian CV Saka Pratama
                        </a>
                        <div class="user-dropdown">
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="me-2 text-end">
                                        <div class="fw-bold">
                                            {{ session('karyawan_nama') ?? Auth::guard('karyawan')->user()->nama_karyawan }}
                                        </div>
                                        <small style="opacity: 0.8;">
                                            {{ ucfirst(session('karyawan_jabatan') ?? Auth::guard('karyawan')->user()->jabatan) }}
                                        </small>
                                    </div>
                                    <div class="avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Welcome Section -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="welcome-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="welcome-content">
                                <h1>Selamat Datang,
                                    {{ session('karyawan_nama') ?? Auth::guard('karyawan')->user()->nama_karyawan }}!
                                </h1>
                                <p>Sistem Penggajian Terintegrasi CV Saka Pratama</p>
                                <div class="mt-3">
                                    <small class="opacity-75">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Sistem ini mengelola data karyawan, absensi, produksi, dan penggajian
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="fas fa-chart-line welcome-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Total Karyawan</h3>
                            <div class="number">{{ $totalKaryawan }}</div>
                            <div class="stat-details">
                                @php
                                    $jabatanStats = DB::table('m_karyawan')
                                        ->where('status_karyawan', 'aktif')
                                        ->select('jabatan', DB::raw('COUNT(*) as total'))
                                        ->groupBy('jabatan')
                                        ->get();
                                    $jabatanText = [];
                                    foreach ($jabatanStats as $stat) {
                                        $jabatanText[] = $stat->jabatan . ': ' . $stat->total;
                                    }
                                    echo implode(' • ', $jabatanText);
                                @endphp
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Hadir Hari Ini</h3>
                            <div class="number">{{ $hadirHariIni }}</div>
                            <div class="stat-details">
                                {{ date('d F Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Total Produksi</h3>
                            <div class="number">{{ number_format($total_aktual, 0, ',', '.') }}</div>
                            <div class="stat-details">
                                Total produksi operator
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Target Perusahaan -->
                <div class="progress-section">
                    <h3 class="section-title mb-4">
                        <i class="fas fa-chart-bar"></i>Progress Target Perusahaan
                    </h3>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <h5 class="mb-3">Total Progress Produksi Perusahaan</h5>
                            <div class="progress progress-large mb-3">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ min($persentase_selesai, 100) }}%;"
                                    aria-valuenow="{{ $persentase_selesai }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ number_format($persentase_selesai, 1) }}%
                                </div>
                            </div>
                            <div class="d-flex justify-content-between text-sm">
                                <span class="text-muted">Total Aktual:
                                    <strong>{{ number_format($total_aktual_target, 0, ',', '.') }} pcs</strong></span>
                                <span class="text-muted">Total Target:
                                    <strong>{{ number_format($total_target, 0, ',', '.') }} pcs</strong></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="p-3 bg-light rounded">
                                <h2 class="text-success mb-0">{{ number_format($persentase_selesai, 1) }}%</h2>
                                <small class="text-muted">Pencapaian Target</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SAW Section - HANYA UNTUK PEMILIK -->
                @php
                    $currentJabatan =
                        session('karyawan_jabatan') ??
                        (Auth::guard('karyawan')->check() ? Auth::guard('karyawan')->user()->jabatan : '');
                @endphp

                @if ($currentJabatan == 'pemilik')
                    <div class="saw-section">
                        <div class="saw-header">
                            <div class="saw-title">
                                <div class="saw-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="saw-title-text">
                                    <h3>Analisis SAW - Karyawan Terbaik</h3>
                                    <p>Metode Simple Additive Weighting berdasarkan Produksi & Kehadiran</p>
                                </div>
                            </div>
                            <div class="saw-info-badges">
                                <div class="saw-badge">
                                    <div class="saw-badge-value">{{ $alternatives ? count($alternatives) : 0 }}</div>
                                    <div class="saw-badge-label">Karyawan</div>
                                </div>
                                <div class="saw-badge">
                                    <div class="saw-badge-value">
                                        {{ $saw_stats['avg_score'] ? round($saw_stats['avg_score'] * 100, 1) . '%' : '0%' }}
                                    </div>
                                    <div class="saw-badge-label">Rata-rata</div>
                                </div>
                                <div class="saw-badge">
                                    <div class="saw-badge-value">
                                        {{ $saw_stats['max_score'] ? round($saw_stats['max_score'] * 100, 1) . '%' : '0%' }}
                                    </div>
                                    <div class="saw-badge-label">Tertinggi</div>
                                </div>
                                <div class="saw-badge">
                                    <div class="saw-badge-value">60/40</div>
                                    <div class="saw-badge-label">Bobot</div>
                                </div>
                            </div>
                        </div>

                        @if (!empty($top_saw))
                            <div class="saw-content">
                                <!-- Ranking Section -->
                                <div class="saw-ranking">
                                    <div class="saw-ranking-title">
                                        <i class="fas fa-trophy"></i>
                                        Top 5 Karyawan Berdasarkan SAW
                                    </div>

                                    <div class="saw-ranking-grid">
                                        @foreach ($top_saw as $index => $karyawan)
                                            <div
                                                class="saw-rank-item rank-{{ $index + 1 }} {{ $index == 0 ? ' top-rank' : '' }}">
                                                <div class="saw-rank-header">
                                                    <span class="saw-rank-badge">{{ $index + 1 }}</span>
                                                    <div class="saw-rank-name">
                                                        <h6>{{ $karyawan['nama'] }}</h6>
                                                    </div>
                                                    <div class="saw-rank-score">
                                                        {{ $karyawan['percentage'] }}%
                                                    </div>
                                                </div>
                                                <div class="saw-rank-details">
                                                    <div class="saw-detail-item">
                                                        <div class="saw-detail-label">Produksi</div>
                                                        <div class="saw-detail-value">
                                                            {{ number_format($karyawan['produksi'], 0, ',', '.') }} pcs
                                                        </div>
                                                    </div>
                                                    <div class="saw-detail-item">
                                                        <div class="saw-detail-label">Kehadiran</div>
                                                        <div class="saw-detail-value">{{ $karyawan['kehadiran'] }}
                                                            hari</div>
                                                    </div>
                                                    <div class="saw-detail-item">
                                                        <div class="saw-detail-label">Target</div>
                                                        <div class="saw-detail-value">
                                                            {{ number_format($karyawan['target'], 0, ',', '.') }} pcs
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Criteria Section -->
                                <div class="saw-criteria">
                                    <div class="saw-criteria-title">
                                        <i class="fas fa-balance-scale"></i>
                                        Kriteria dan Bobot SAW
                                    </div>

                                    <div class="saw-criteria-details">
                                        <!-- Kriteria Produksi -->
                                        <div class="criteria-item">
                                            <div class="criteria-header">
                                                <span class="criteria-name">Produksi (C1)</span>
                                                <span class="criteria-weight">60%</span>
                                            </div>
                                            <div class="criteria-bar">
                                                <div class="criteria-progress"
                                                    style="width: 60%; background: linear-gradient(90deg, #673ab7, #9c27b0);">
                                                </div>
                                            </div>
                                            <div class="criteria-info">
                                                Total hasil produksi dalam pcs (Benefit - semakin tinggi semakin baik)
                                            </div>
                                        </div>

                                        <!-- Kriteria Kehadiran -->
                                        <div class="criteria-item">
                                            <div class="criteria-header">
                                                <span class="criteria-name">Kehadiran (C2)</span>
                                                <span class="criteria-weight">40%</span>
                                            </div>
                                            <div class="criteria-bar">
                                                <div class="criteria-progress"
                                                    style="width: 40%; background: linear-gradient(90deg, #2196f3, #03a9f4);">
                                                </div>
                                            </div>
                                            <div class="criteria-info">
                                                Jumlah kehadiran dalam 14 hari terakhir (Benefit - semakin tinggi
                                                semakin baik)
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Formula Section -->
                                    <div class="saw-formula">
                                        <div class="formula-title">Rumus SAW yang Digunakan:</div>
                                        <div class="formula-text">
                                            Normalisasi = (nilai - min) / (max - min)<br>
                                            Skor = (C1_normal × 0.6) + (C2_normal × 0.4)<br>
                                            <small class="text-muted">* Semua kriteria adalah benefit criteria</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-chart-bar"></i>
                                <p>Belum ada data yang cukup untuk perhitungan SAW</p>
                                <small class="opacity-75">Data minimal: 1 karyawan dengan produksi atau
                                    kehadiran</small>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- KPI Performance -->
                <div class="kpi-section">
                    <h3 class="section-title">
                        <i class="fas fa-trophy"></i>Performance Metrics
                    </h3>
                    <div class="kpi-grid">
                        <!-- Operator Terproduktif -->
                        <div class="kpi-card">
                            <div class="kpi-header">
                                <i class="fas fa-trophy"></i>
                                <h5>Operator Terproduktif</h5>
                            </div>
                            <div class="kpi-body">
                                @if ($rankingProduksi->count() > 0)
                                    @php $rank = 1; @endphp
                                    @foreach ($rankingProduksi as $karyawan)
                                        <div class="performance-item">
                                            <span class="ranking-badge rank-{{ $rank }}">
                                                {{ $rank }}
                                            </span>
                                            <div class="performance-content">
                                                <h6>{{ $karyawan->nama_karyawan }}</h6>
                                                <small>{{ ucfirst($karyawan->jabatan) }}</small>
                                            </div>
                                            <div class="performance-stats">
                                                <span class="badge bg-primary">
                                                    {{ number_format($karyawan->total_aktual, 0, ',', '.') }} pcs
                                                </span>
                                                <br>
                                                <small style="color: var(--gray); font-size: 0.7rem;">
                                                    {{ $karyawan->total_keranjang }} keranjang
                                                </small>
                                            </div>
                                        </div>
                                        @php $rank++; @endphp
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-cogs"></i>
                                        <p>Belum ada data produksi</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Top Kehadiran -->
                        <div class="kpi-card">
                            <div class="kpi-header">
                                <i class="fas fa-calendar-check"></i>
                                <h5>Top Kehadiran (14 Hari)</h5>
                            </div>
                            <div class="kpi-body">
                                @if ($topKehadiran->count() > 0)
                                    @php $rank = 1; @endphp
                                    @foreach ($topKehadiran as $hadir)
                                        <div class="performance-item">
                                            <span class="ranking-badge rank-{{ $rank }}">
                                                {{ $rank }}
                                            </span>
                                            <div class="performance-content">
                                                <h6>{{ $hadir->nama_karyawan }}</h6>
                                                <small>{{ ucfirst($hadir->jabatan) }}</small>
                                            </div>
                                            <div class="performance-stats">
                                                <span class="badge badge-success">
                                                    {{ $hadir->total_hadir }} hari
                                                </span>
                                            </div>
                                        </div>
                                        @php $rank++; @endphp
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-user-clock"></i>
                                        <p>Belum ada data kehadiran</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Sections -->
                <div class="activity-grid">
                    <!-- Absensi Terbaru -->
                    <div class="activity-section">
                        <div class="section-header">
                            <h3><i class="fas fa-user-clock"></i>Absensi Terbaru</h3>
                            <a href="#">Lihat Semua</a>
                        </div>
                        <div class="activity-list">
                            @if ($absensiTerbaru->count() > 0)
                                @foreach ($absensiTerbaru as $absensi)
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="activity-content">
                                            <strong>{{ $absensi->nama_karyawan }}</strong>
                                            <div class="details">
                                                {{ date('d/m/Y', strtotime($absensi->tanggal)) }} |
                                                {{ !empty($absensi->jam_masuk) ? substr($absensi->jam_masuk, 0, 5) : '-' }}
                                                -
                                                {{ !empty($absensi->jam_keluar) ? substr($absensi->jam_keluar, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                        <span
                                            class="activity-badge badge-{{ str_replace(' ', '-', $absensi->status_absensi) }}">
                                            {{ ucfirst($absensi->status_absensi) }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-user-clock"></i>
                                    <p>Tidak ada data absensi terbaru</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Produksi Terbaru -->
                    <div class="activity-section">
                        <div class="section-header">
                            <h3><i class="fas fa-cogs"></i>Produksi Terbaru</h3>
                            <a href="#">Lihat Semua</a>
                        </div>
                        <div class="activity-list">
                            @if ($produksiTerbaru->count() > 0)
                                @foreach ($produksiTerbaru as $produksi)
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-cube"></i>
                                        </div>
                                        <div class="activity-content">
                                            <strong>{{ $produksi->nama_produk }}</strong>
                                            <div class="details">
                                                {{ $produksi->nama_karyawan }} |
                                                Keranjang: {{ $produksi->jml_keranjang }}
                                            </div>
                                        </div>
                                        <span class="activity-badge">
                                            {{ number_format($produksi->jml_aktual, 0, ',', '.') }} pcs
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-cogs"></i>
                                    <p>Tidak ada data produksi terbaru</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>&copy; {{ date('Y') }} CV Saka Pratama - Sistem Penggajian. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 992 &&
                !sidebar.contains(event.target) &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Animate SAW items on load
        document.addEventListener('DOMContentLoaded', function() {
            const sawItems = document.querySelectorAll('.saw-rank-item');
            sawItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });

        // Logout confirmation
        document.querySelectorAll('a[href*="logout"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('Anda yakin ingin logout?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
