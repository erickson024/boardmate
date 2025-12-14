<div>
    <h5>Pending Host Requests</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
            <tr>
                <td>{{ $req->user->firstName }} {{ $req->user->lastName }}</td>
                <td>{{ $req->user->email }}</td>
                <td>
                    <button wire:click="approve({{ $req->id }})" class="btn btn-success btn-sm">Approve</button>
                    <button wire:click="deny({{ $req->id }})" class="btn btn-danger btn-sm">Deny</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
