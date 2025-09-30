@extends('layouts.admin')

@section('content')

<style>
.notifications-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

.notifications-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
}

.notifications-title {
    color: #043306;
    font-size: 28px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.notifications-title i {
    color: #007bff;
    font-size: 24px;
}

.notifications-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.action-btn {
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: Verdana, sans-serif;
}

.mark-all-read-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.mark-all-read-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.delete-all-btn {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.delete-all-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.notifications-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}

.stat-item {
    background: white;
    padding: 15px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    text-align: center;
    flex: 1;
    border-left: 4px solid #05aa29;
}

.stat-number {
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.notifications-list {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 30px;
}

.notification-item {
    position: relative;
    padding: 20px 25px;
    border-bottom: 1px solid #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background: linear-gradient(90deg, #f0f8ff 0%, #ffffff 100%);
    border-left: 4px solid #007bff;
}

.notification-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 5px;
}


.notification-icon.info { background: linear-gradient(135deg, #17b875, #e8f3f5); color: #05aa29; }
.notification-icon.success { background: linear-gradient(135deg, #28a745, #1e7e34); color: white; }
.notification-icon.warning { background: linear-gradient(135deg, #ffc107, #e0a800); color: #333; }
.notification-icon.danger { background: linear-gradient(135deg, #dc3545, #c82333); color: white; }


.notification-icon.new_student  { background-color: #e6f4ff; color: #0b66c3; }
.notification-icon.new_company  { background-color: #fff6e6; color: #b36b00; }
.notification-icon.override_schedule { background-color: #fff9e6; color: #b07a00; }
.notification-icon.default_time { background-color: #e6fff7; color: #007a5a; }
.notification-icon.security_alert { background-color: #ffecec; color: #c53030; }

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 6px;
    line-height: 1.4;
}

.notification-message {
    font-size: 14px;
    color: #6c757d;
    line-height: 1.5;
    margin-bottom: 8px;
}

.notification-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 10px;
}

.notification-time {
    font-size: 12px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 4px;
}

.notification-type {
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

/* small badge classes */
.type-info { background-color: #d1ecf1; color: #0c5460; }
.type-new_student { background-color: #e6f4ff; color: #0b66c3; border: 1px solid #bfe1ff; }
.type-new_company { background-color: #fff6e6; color: #b36b00; border: 1px solid #ffd8a8; }
.type-override_schedule { background-color: #fff9e6; color: #b07a00; border: 1px solid #ffe2a8; }
.type-default_time { background-color: #e6fff7; color: #007a5a; border: 1px solid #bfeee0; }
.type-security_alert { background-color: #ffecec; color: #c53030; border: 1px solid #ffc6c6; }

.unread-indicator {
    position: absolute;
    top: 20px;
    right: 60px;
    width: 8px;
    height: 8px;
    background: #007bff;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

/* Notification Actions (hover) */
.notification-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 8px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.notification-item:hover .notification-actions {
    opacity: 1;
    visibility: visible;
}

.notification-action-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: all 0.2s ease;
}

.mark-read-btn {
    background: #28a745;
    color: white;
}

.delete-btn {
    background: #dc3545;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 48px;
    color: #dee2e6;
    margin-bottom: 20px;
}

.empty-state h4 {
    color: #495057;
    margin-bottom: 10px;
    font-weight: 500;
}

.empty-state p {
    font-size: 14px;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.6;
}


@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(0,123,255,0.7); }
    70% { box-shadow: 0 0 0 10px rgba(0,123,255,0); }
    100% { box-shadow: 0 0 0 0 rgba(0,123,255,0); }
}

.pagination-wrapper {
    text-align: center;
    margin-top: 30px;
    font-family: Verdana, sans-serif;
}

.pagination {
    list-style: none;
    padding: 0;
    margin: 0;
    display: inline-flex;
    align-items: center;
    gap: 15px;
}

.pagination .page-item {
    display: inline-block;
}


.page-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #14532d;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
}


.page-link:hover {
    background-color: #1e7c43;
    transform: translateY(-1px);
}


.page-item.disabled .page-link {
    background-color: #5c7f6e;
    color: #ccc;
    cursor: not-allowed;
}


.page-indicator .page-link.static {
    background-color: transparent;
    color: #98afa2;
    font-weight: bold;
    cursor: default;
    padding: 10px 0;
    border: none;
    opacity: 0.5;
}


</style>

<div class="notifications-container">
    <div class="notifications-header">
        <h1 class="notifications-title">
            <i class="fas fa-bell"></i>
            Admin Notifications
        </h1>

        <div class="notifications-actions">
            <div class="notifications-actions">
                <form id="deleteAllForm" action="{{ route('admin.notifications.deleteAll') }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete-all-btn">
                        <i class="fas fa-trash-alt"></i> Delete All
                    </button>
                </form>
            </div>

        </div>
    </div>

    <div class="notifications-stats">
        <div class="stat-item">
            <div class="stat-number">{{ $notifications->where('is_read', 0)->count() }}</div>
            <div class="stat-label">Unread</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $notifications->total() }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $notifications->where('created_at', '>=', now()->subDay())->count() }}</div>
            <div class="stat-label">Today</div>
        </div>
    </div>

    <div class="notifications-list">
        @forelse($notifications as $notification)
            <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" id="notification-{{ $notification->id }}">
                @if(!$notification->is_read)
                    <div class="unread-indicator"></div>
                @endif


                <div class="notification-icon
                    {{ $notification->type ?? 'info' }}">
                    @switch($notification->type ?? 'info')
                        @case('new_student')
                            <i class="fas fa-user-plus"></i>
                            @break
                        @case('new_company')
                            <i class="fas fa-building"></i>
                            @break

                        @case('override_schedule')
                            <i class="fas fa-clock"></i>
                            @break
                        @case('default_time')
                            <i class="fas fa-calendar-check"></i>
                            @break
                        @case('security_alert')
                            <i class="fas fa-exclamation-triangle"></i>
                            @break
                        @default
                            <i class="fas fa-info-circle"></i>
                    @endswitch
                </div>

                <div class="notification-content">
                    <div class="notification-title">
                        {{ $notification->title }}
                    </div>

                    <div class="notification-message">{{ $notification->message }}</div>

                    <div class="notification-meta">
                        <div class="notification-time">
                            <i class="far fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                        <span class="notification-type type-{{ $notification->type ?? 'info' }}">
                            {{ str_replace('_', ' ', ucfirst($notification->type ?? 'info')) }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="far fa-bell-slash"></i>
                <h4>No Notifications Yet</h4>
                <p>You're all caught up! New notifications will appear here when you receive them.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $notifications->withQueryString()->links('vendor.pagination.prev-next-only') }}
    </div>
</div>

<script>
function getCsrf() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

function markAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': getCsrf(),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    }).then(response => {
        if (response.ok) {
            const item = document.getElementById(`notification-${notificationId}`);
            if (item) {
                item.classList.remove('unread');
                const indicator = item.querySelector('.unread-indicator');
                if (indicator) indicator.remove();

                // remove mark-read button
                const markReadBtn = item.querySelector('.mark-read-btn');
                if (markReadBtn) markReadBtn.remove();
            }
            updateStats();
        }
    }).catch(console.error);
}



function updateStats() {
    const unreadItems = document.querySelectorAll('.notification-item.unread').length;
    const totalItems = document.querySelectorAll('.notification-item').length;
    document.querySelectorAll('.stat-number')[0].textContent = unreadItems;
    document.querySelectorAll('.stat-number')[1].textContent = totalItems;
}


function markAsRead(id) {
    fetch(`/admin/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            const item = document.getElementById(`notification-${id}`);
            if (item) {
                item.classList.remove('unread');
                const dot = item.querySelector('.unread-indicator');
                if (dot) dot.remove();
                // also hide "mark as read" button
                const markBtn = item.querySelector('.mark-read-btn');
                if (markBtn) markBtn.remove();
            }
        }
    });
}





</script>


@endsection
