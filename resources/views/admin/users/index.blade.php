@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<style>
    .user-management {
        max-width: 1250px;
        margin: 0 auto;
    }

    .page-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-heading h1 {
        margin: 0 0 6px;
        color: #172033;
        font-size: 28px;
    }

    .page-heading p {
        margin: 0;
        color: #667085;
        font-size: 14px;
    }

    .user-count {
        padding: 9px 14px;
        border: 1px solid #d9e0ea;
        border-radius: 999px;
        background: #ffffff;
        color: #344054;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .management-card {
        overflow: hidden;
        border: 1px solid #e1e6ef;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(23, 32, 51, 0.07);
    }

    .management-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid #e8ecf2;
    }

    .search-form {
        display: flex;
        width: min(100%, 430px);
        gap: 10px;
    }

    .search-input {
        width: 100%;
        min-width: 0;
        padding: 11px 13px;
        border: 1px solid #d0d7e2;
        border-radius: 9px;
        outline: none;
        background: #ffffff;
        color: #172033;
    }

    .search-input:focus {
        border-color: #356ae6;
        box-shadow: 0 0 0 3px rgba(53, 106, 230, 0.12);
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 15px;
        border: 0;
        border-radius: 9px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .button-primary {
        background: #2859c5;
        color: #ffffff;
    }

    .button-primary:hover {
        background: #1f49a7;
    }

    .button-light {
        border: 1px solid #d0d7e2;
        background: #ffffff;
        color: #344054;
    }

    .button-light:hover {
        background: #f7f9fc;
    }

    .message {
        margin: 18px 20px 0;
        padding: 12px 14px;
        border-radius: 9px;
        font-size: 14px;
    }

    .message-success {
        border: 1px solid #abefc6;
        background: #ecfdf3;
        color: #067647;
    }

    .message-error {
        border: 1px solid #fecdca;
        background: #fef3f2;
        color: #b42318;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table th {
        padding: 13px 20px;
        border-bottom: 1px solid #e1e6ef;
        background: #f8fafc;
        color: #475467;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-align: left;
        text-transform: uppercase;
    }

    .users-table td {
        padding: 18px 20px;
        border-bottom: 1px solid #edf0f5;
        color: #344054;
        vertical-align: top;
    }

    .users-table tbody tr:hover {
        background: #fbfcfe;
    }

    .users-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .user-details {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 220px;
    }

    .user-avatar {
        display: grid;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        place-items: center;
        border-radius: 50%;
        background: #e8efff;
        color: #2859c5;
        font-size: 14px;
        font-weight: 800;
    }

    .user-name {
        margin-bottom: 3px;
        color: #172033;
        font-size: 14px;
        font-weight: 800;
    }

    .user-email {
        color: #667085;
        font-size: 13px;
    }

    .current-user-label {
        display: inline-block;
        margin-top: 5px;
        padding: 3px 7px;
        border-radius: 999px;
        background: #eef4ff;
        color: #3538cd;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .role-form {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 300px;
    }

    .role-select {
        min-width: 190px;
        padding: 10px 34px 10px 11px;
        border: 1px solid #d0d7e2;
        border-radius: 9px;
        background: #ffffff;
        color: #344054;
        outline: none;
    }

    .role-select:focus {
        border-color: #356ae6;
        box-shadow: 0 0 0 3px rgba(53, 106, 230, 0.12);
    }

    .permission-list {
        display: flex;
        min-width: 270px;
        flex-wrap: wrap;
        gap: 7px;
    }

    .permission-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border: 1px solid #dbe5ff;
        border-radius: 999px;
        background: #f3f6ff;
        color: #284a94;
        font-size: 11px;
        font-weight: 700;
    }

    .permission-admin {
        border-color: #fedf89;
        background: #fffaeb;
        color: #b54708;
    }

    .permission-empty {
        color: #98a2b3;
        font-size: 13px;
        font-style: italic;
    }

    .empty-state {
        padding: 48px 20px !important;
        color: #667085 !important;
        text-align: center;
    }

    .pagination-area {
        padding: 18px 20px;
        border-top: 1px solid #e8ecf2;
    }

    @media (max-width: 720px) {
        .page-heading,
        .management-toolbar,
        .search-form,
        .role-form {
            align-items: stretch;
            flex-direction: column;
        }

        .user-count {
            align-self: flex-start;
        }

        .search-form {
            width: 100%;
        }

        .role-form {
            min-width: 220px;
        }

        .role-select {
            width: 100%;
        }
    }
</style>

<div class="user-management">
    <div class="page-heading">
        <div>
            <h1>User Management</h1>
            <p>Manage system users, their assigned roles, and role permissions.</p>
        </div>

        <div class="user-count">
            {{ $users->total() }} {{ Str::plural('user', $users->total()) }}
        </div>
    </div>

    <div class="management-card">
        <div class="management-toolbar">
            <form method="GET"
                  action="{{ route('admin.users.index') }}"
                  class="search-form">

                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    class="search-input"
                    placeholder="Search by name or email"
                    aria-label="Search users"
                >

                <button type="submit" class="button button-primary">
                    Search
                </button>

                @if($search !== '')
                    <a href="{{ route('admin.users.index') }}"
                       class="button button-light">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        @if(session('status'))
            <div class="message message-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="message message-error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="table-wrapper">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>List of Users</th>
                        <th>User Roles</th>
                        <th>User Permissions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        @php
                            $initials = collect(explode(' ', $user->name))
                                ->filter()
                                ->take(2)
                                ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                ->implode('');

                            $isSystemAdministrator =
                                $user->role?->slug === 'system-administrator';
                        @endphp

                        <tr>
                            <td>
                                <div class="user-details">
                                    <div class="user-avatar">
                                        {{ $initials ?: 'U' }}
                                    </div>

                                    <div>
                                        <div class="user-name">
                                            {{ $user->name }}
                                        </div>

                                        <div class="user-email">
                                            {{ $user->email }}
                                        </div>

                                        @if(auth()->id() === $user->id)
                                            <span class="current-user-label">
                                                Your account
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                <form
                                    method="POST"
                                    action="{{ route('admin.users.update-role', $user) }}"
                                    class="role-form"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="role_id"
                                        class="role-select"
                                        aria-label="Role for {{ $user->name }}"
                                    >
                                        @foreach($roles as $role)
                                            <option
                                                value="{{ $role->id }}"
                                                @selected($user->role_id === $role->id)
                                            >
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button
                                        type="submit"
                                        class="button button-primary"
                                    >
                                        Save
                                    </button>
                                </form>
                            </td>

                            <td>
                                @if($isSystemAdministrator)
                                    <div class="permission-list">
                                        <span class="permission-badge permission-admin">
                                            Full system access
                                        </span>
                                    </div>
                                @else
                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.update-permissions', $user) }}"
                                        class="permission-form"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <div class="permission-checkboxes">
                                                                                        @foreach($permissions as $permission)
                                                @php
                                                    $assignedDirectly = $user->permissions
                                                        ->contains('id', $permission->id);

                                                    $inheritedFromRole = $user->role
                                                        ? $user->role->permissions->contains('id', $permission->id)
                                                        : false;

                                                    $userAlreadyHasPermission =
                                                        $assignedDirectly || $inheritedFromRole;
                                                @endphp

                                                <label
                                                    class="permission-option
                                                    {{ $inheritedFromRole ? 'permission-inherited' : '' }}"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        {{ $userAlreadyHasPermission ? 'checked' : '' }}
                                                        {{ $inheritedFromRole ? 'disabled' : '' }}
                                                        {{ $inheritedFromRole ? 'onclick=return false;' : '' }}
                                                    >

                                                    <span>
                                                        {{ $permission->name }}

                                                        @if($inheritedFromRole)
                                                            <small>
                                                                Already included in {{ $user->role?->name }}
                                                            </small>
                                                        @elseif($assignedDirectly)
                                                            <small>Direct permission</small>
                                                        @else
                                                            <small>Not assigned</small>
                                                        @endif
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>

                                        <button
                                            type="submit"
                                            class="button button-primary permission-save-button"
                                        >
                                            Save Permissions
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty-state">
                                No users were found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="pagination-area">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection