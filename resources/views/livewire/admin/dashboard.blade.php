<div>
    <div class="container mt-4">
        <div class="bg-white shadow-sm border rounded p-3">
            <div class="d-flex flex-column">
                <small>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</small>
                <small class="text-muted">admin</small>
            </div>
        </div>
        <h4 class="fw-bold mb-3 mt-3">Admin Dashboard</h4>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-dark text-capitalize">{{ $user->type }}</span>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>