@extends('layouts.student')

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

.notification-item:hover .notification-actions {
    opacity: 1;
    visibility: visible;
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

.notification-icon.info {
    background: linear-gradient(135deg, #17b875, #e8f3f5);
    color: #05aa29;
}

.notification-icon.success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
    color: white;
}

.notification-icon.warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: #333;
}

.notification-icon.danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

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

.type-info {
    background-color: #cce7f0;
    color: #0c5460;
}

.type-success {
    background-color: #d4edda;
    color: #155724;
}

.type-warning {
    background-color: #fff3cd;
    color: #856404;
}

.type-danger {
    background-color: #f8d7da;
    color: #721c24;
}

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

/* Notification Actions */
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

.mark-read-btn:hover {
    background: #218838;
    transform: scale(1.05);
}

.delete-btn {
    background: #dc3545;
    color: white;
}

.delete-btn:hover {
    background: #c82333;
    transform: scale(1.05);
}

.delete-btn:active {
    transform: scale(0.95);
}

/* Delete confirmation modal */
.delete-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(2px);
}

.delete-modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    text-align: center;
    max-width: 400px;
    width: 90%;
}

.delete-modal h3 {
    color: #dc3545;
    margin-bottom: 15px;
    font-size: 20px;
}

.delete-modal p {
    color: #6c757d;
    margin-bottom: 25px;
    line-height: 1.5;
}

.delete-modal-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.modal-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.confirm-delete-btn {
    background: #dc3545;
    color: white;
}

.confirm-delete-btn:hover {
    background: #c82333;
}

.cancel-delete-btn {
    background: #6c757d;
    color: white;
}

.cancel-delete-btn:hover {
    background: #5a6268;
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
    0% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
    }
}

/* Loading state */
.notification-item.deleting {
    opacity: 0.5;
    pointer-events: none;
}

.notification-item.deleting::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .notifications-container {
        padding: 0 15px;
    }

    .notifications-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .notifications-title {
        font-size: 24px;
    }

    .notifications-stats {
        flex-direction: column;
        gap: 10px;
    }

    .notification-item {
        padding: 15px 20px;
        padding-right: 50px;
    }

    .notification-actions {
        position: static;
        opacity: 1;
        visibility: visible;
        margin-top: 10px;
        align-self: flex-start;
    }

    .notification-icon {
        width: 35px;
        height: 35px;
        align-self: flex-start;
    }

    .notification-meta {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
    }

    .unread-indicator {
        right: 20px;
    }
}

@media (max-width: 480px) {
    .notification-item {
        padding: 12px 15px;
        flex-direction: column;
        gap: 10px;
    }

    .notifications-title {
        font-size: 20px;
    }

    .stat-number {
        font-size: 20px;
    }

    .notifications-actions {
        flex-direction: column;
        width: 100%;
    }

    .action-btn {
        width: 100%;
        justify-content: center;
    }
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

.notification-type {
  font-weight: 600;
  padding: 2px 8px;
  border-radius: 12px;
  font-size: 0.85rem;
  display: inline-block;
  text-transform: capitalize;
}


.type-reject {
  background-color: #ffffff;
  color: #0f0700;
  border: 1px solid #ff0000;
  border-left: 5px solid #d84400;
}

.type-journal_reminder {
  background-color: #ffffff;
  color: #0f0700;
  border: 1px solid #ff9cf7;
  border-left: 5px solid #ff9cf7;
}

.type-approve {
  background-color: #ffffff;
  color: #0f0700;
  border: 1px solid #005a1e;
  border-left: 5px solid #005a1e;
}

.type-company_feedback {
  background-color: #ffffff;
  color: #8a5200;
  border: 1px solid #ffb347;
  border-left: 4px solid #ff9500;
}

.type-summary_report {
  background-color: #fef0f0;
  color: #a82a2a;
  border: 1px solid #e67e7e;
  border-left: 4px solid #c0392b;
}


.type-info {
  background-color: #d1ecf1;
  color: #0c5460;
  border: 1px solid #0c5460;
}


.notification-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  font-size: 18px;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow:
    0 2px 4px rgba(0, 0, 0, 0.4),
    inset 0 1px 2px rgba(255, 255, 255, 0.4);
}


.notification-icon.journal i {
  color: #3a75d1;
  background-color: #dfecfd;
}


.notification-icon.company_feedback i {
  color: #d47a00;
  background-color: #fff0e0;
}


.notification-icon.summary_report i {
  color: #d63031;
  background-color: #ffebee;
}


.notification-icon.info i {
  color: #5f6c7b;
  background-color: #f0f4f8;
}


.notification-icon:hover {
  transform: translateY(-2px);
  box-shadow:
    0 4px 8px rgba(0, 0, 0, 0.15),
    inset 0 1px 3px rgba(255, 255, 255, 0.4);
}

.notification-icon .icon-circle {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: white;
    font-size: 20px;
}

    .notification-icon.approve {
        background-color: #28a745;
        color: rgb(253, 253, 253);
    }

    .notification-icon.reject {
        background-color: #dc3545;
        color: rgb(253, 253, 253);

    }
    .notification-icon.journal_reminder{
        background-color: #ff9cf7;
        color: rgb(0, 0, 0);
    }

    .badge-due-today {
    background-color: #e53935;
    color: white;
    font-size: 11px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 12px;
    margin-left: 6px;
}




</style>

<div class="notifications-container">
    <div class="notifications-header">
        <h1 class="notifications-title">
            <i class="fas fa-bell"></i>
            Notifications
        </h1>
        <div class="notifications-actions">
            {{-- <button class="action-btn mark-all-read-btn" onclick="markAllAsRead()">
                <i class="fas fa-check-double"></i>
                Mark All Read
            </button> --}}
            <form id="deleteAllForm" action="{{ route('student.notifications.deleteAll') }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn delete-all-btn" onclick="return confirm('Are you sure you want to delete all notifications? This action cannot be undone.')">
                    <i class="fas fa-trash-alt"></i>
                    Delete All
                </button>
</form>

        </div>
    </div>

    <div class="notifications-stats">
        <div class="stat-item">
            <div class="stat-number">{{ $notifications->where('is_read', 0)->count() }}</div>
            <div class="stat-label">Unread</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $notifications->count() }}</div>
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

                <!-- Notification Actions -->
                <div class="notification-actions">
                    @if(!$notification->is_read)
                        {{-- <button class="notification-action-btn mark-read-btn" onclick="markAsRead({{ $notification->id }})" title="Mark as read">
                            <i class="fas fa-check"></i>
                        </button> --}}
                    @endif
                    {{-- <button class="notification-action-btn delete-btn" onclick="showDeleteModal({{ $notification->id }})" title="Delete notification">
                        <i class="fas fa-trash"></i>
                    </button> --}}
                </div>



                <div class="notification-icon {{ $notification->type ?? 'info' }}">
                @switch($notification->type ?? 'info')
                    @case('approve')
                        <i class="fas fa-check-circle"></i>
                    @break
                    @case('reject')
                        <i class="fas fa-times-circle"></i>
                    @break


                    @case('company_feedback')
                        <i class="fas fa-briefcase"></i>
                        @break
                    @case('summary_report')
                        <i class="fas fa-file-pdf"></i>
                        @break
                    @case('journal_reminder')
                        <i class="fas fa-pen text-purple-500"></i>
                        @break
                    @default
                        <i class="fas fa-info-circle"></i>
                @endswitch
            </div>


                                <div class="notification-content">
                    <div class="notification-title">
                        {{ $notification->title }}
                        @if($notification->type === 'journal_reminder')
                            <span class="badge-due-today">Due 11:59pm</span>
                        @endif
                    </div>
                    <div class="notification-message">{{ $notification->message }}</div>

                    <div class="notification-meta">
                        <div class="notification-time">
                            <i class="far fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                        <span class="notification-type type-{{ $notification->type ?? 'info' }}">
                            {{ ucfirst($notification->type ?? 'info') }}
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
</div>

<div class="pagination-wrapper">
    {{ $notifications->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>



<script>
let currentNotificationId = null;

function markAsRead(notificationId) {
    fetch(`/student/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    }).then(response => {
        if (response.ok) {
            const item = document.getElementById(`notification-${notificationId}`);
            item.classList.remove('unread');
            const indicator = item.querySelector('.unread-indicator');
            if (indicator) {
                indicator.remove();
            }

            // Hide the mark as read button
            const markReadBtn = item.querySelector('.mark-read-btn');
            if (markReadBtn) {
                markReadBtn.remove();
            }

            updateStats();
        }
    }).catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead() {
    fetch('/student/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    }).then(response => {
        if (response.ok) {
            document.querySelectorAll('.notification-item.unread').forEach(item => {
                item.classList.remove('unread');
                const indicator = item.querySelector('.unread-indicator');
                if (indicator) {
                    indicator.remove();
                }


                const markReadBtn = item.querySelector('.mark-read-btn');
                if (markReadBtn) {
                    markReadBtn.remove();
                }
            });

            updateStats();
        }
    }).catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}




function updateStats() {
    const unreadItems = document.querySelectorAll('.notification-item.unread').length;
    const totalItems = document.querySelectorAll('.notification-item').length;

    document.querySelectorAll('.stat-number')[0].textContent = unreadItems;
    document.querySelectorAll('.stat-number')[1].textContent = totalItems;
}


window.onclick = function(event) {
    const deleteModal = document.getElementById('deleteModal');
    const deleteAllModal = document.getElementById('deleteAllModal');

    if (event.target === deleteModal) {
        hideDeleteModal();
    }
    if (event.target === deleteAllModal) {
        hideDeleteAllModal();
    }
}


document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideDeleteModal();
        hideDeleteAllModal();
    }
});
</script>

@endsection
