<div>
    <div wire:poll-5000ms="$refresh">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-1 fw-medium">User Management</h5>
                    <p class="text-secondary mb-0 small">Manage and monitor all users.</p>
                </div>

            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="row g-2 mb-4">
            @foreach($this->roles as $role)
            <div class="col-6 col-md-3">
                <button
                    wire:click="filterByRole({{ json_encode($role['value']) }})"
                    class="w-100 text-start border-0 rounded-2 overflow-hidden role-card"
                    style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
                        backdrop-filter: blur(10px);
                        padding: 1rem;
                        cursor: pointer;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        border: 1px solid rgba(255,255,255,0.2);
                        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                        {{ (is_null($role['value']) && is_null($roleFilter)) || $roleFilter === $role['value']
                            ? 'transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.12); ' . $role['bgActive']
                            : $role['bgInactive'] . ' opacity-70' }}"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.12)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">

                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="flex-grow-1">
                            <small class="d-block fw-semibold text-uppercase" style="font-size: 0.65rem; opacity: 0.8; letter-spacing: 0.5px;">{{ $role['label'] }}</small>
                            <h4 class="mb-0 fw-bold mt-1" style="font-size: 1.5rem;">{{ $this->{$role['countProperty']} }}</h4>
                        </div>
                        <div style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 8px; opacity: 0.8; flex-shrink: 0;">
                            <i class="bi {{ $role['icon'] }} fs-5"></i>
                        </div>
                    </div>
                </button>
            </div>
            @endforeach
        </div>


        <!-- Search Section -->
        <div class="mb-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search text-secondary" style="font-size: 0.9rem;"></i>
                </span>
                <input
                    type="text"
                    class="form-control form-control-sm bg-light border-0 rounded-end-2"
                    placeholder="Search by name, email..."
                    wire:model.live="search"
                    style="padding: 0.5rem 0.75rem; font-size: 0.9rem;">
            </div>
        </div>

        <!-- Users Table -->
        <div class="card border-0 shadow-sm rounded-2 overflow-hidden">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #f0f1f3 100%); border-bottom: 1px solid #e9ecef; position: sticky; top: 0;">
                        <tr>
                            <th class="fw-semibold text-secondary ps-3 py-2" style="font-size: 0.85rem;">
                                Name
                            </th>
                            <th class="fw-semibold text-secondary py-2" style="font-size: 0.85rem;">
                                Email
                            </th>
                            <th class="fw-semibold text-secondary py-2" style="font-size: 0.85rem;">
                                Role
                            </th>
                            <th class="fw-semibold text-secondary text-center py-2" style="font-size: 0.85rem;">
                                Status
                            </th>
                            <th class="fw-semibold text-secondary py-2" style="font-size: 0.85rem;">
                                Joined
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr style="transition: all 0.2s ease; border-bottom: 1px solid #f0f1f3;">
                            <td class="ps-3 py-2">
                                <div class="d-flex align-items-center gap-2">
                                    <x-profile-image
                                        :firstName="$user->firstName"
                                        :lastName="$user->lastName"
                                        :image="$user->profileImage"
                                        :size="30" />
                                    <div style="min-width: 0;">
                                        <div class="fw-medium" style="font-size: 0.9rem;">{{ substr($user->firstName, 0, 15) }} {{ substr($user->lastName, 0, 15) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">
                                <span class="text-secondary" style="font-size: 0.85rem; word-break: break-word;">{{ substr($user->email, 0, 25) }}</span>
                            </td>
                            <td class="py-2">
                                @php
                                $roleBadgeConfig = [
                                'admin' => ['bg' => 'bg-warning', 'text' => 'text-dark', 'icon' => 'bi-shield-lock-fill'],
                                'host' => ['bg' => 'bg-success', 'text' => 'text-white', 'icon' => 'bi-house-door-fill'],
                                'tenant' => ['bg' => 'bg-info', 'text' => 'text-white', 'icon' => 'bi-door-closed'],
                                ];
                                $config = $roleBadgeConfig[$user->role] ?? ['bg' => 'bg-secondary', 'text' => 'text-white', 'icon' => 'bi-person'];
                                @endphp
                                <span class="badge {{ $config['bg'] }} {{ $config['text'] }} rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                    <i class="bi {{ $config['icon'] }} me-1" style="font-size: 0.65rem;"></i>{{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-2 text-center">
                                @if(Cache::has('user-is-online-' . $user->id))
                                <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                    <span class="spinner-grow spinner-grow-sm me-1" role="status" style="width: 4px; height: 4px;"></span>
                                    Online
                                </span>
                                @else
                                <span class="badge bg-secondary rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                    <i class="bi bi-circle me-1" style="font-size: 0.5rem;"></i>Offline
                                </span>
                                @endif
                            </td>
                            <td class="py-2">
                                <small class="text-secondary" style="font-size: 0.8rem;">{{ $user->created_at->format('M d, Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div style="opacity: 0.5;">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    <p class="text-secondary fw-500 mb-0" style="font-size: 0.9rem;">No users found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center" style="font-size: 0.85rem;">
                {{ $users->links() }}
            </div>
        </div>


        <style>
            .role-card:hover {
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12) !important;
            }

            .table tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.03) !important;
            }

            .form-control:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.15);
            }

            .badge {
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            .fw-600 {
                font-weight: 600;
            }
        </style>
    </div>
</div>