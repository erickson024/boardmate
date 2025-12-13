<div>
    <input type="text" class="form-control mb-3" placeholder="Search users..." wire:model.live="search">

    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->firstName }} {{ $user->lastName }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    @if(Cache::has('user-is-online-' . $user->id))
                        <span class="badge bg-success">Online</span>
                    @else
                        <span class="badge bg-secondary">Offline</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
