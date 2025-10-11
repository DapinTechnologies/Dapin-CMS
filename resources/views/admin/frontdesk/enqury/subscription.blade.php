@extends('admin.layouts.master')

@section('content')

<style>
    .btn-icon {
        margin-right: 5px;
    }
</style>

<!-- Start Content -->
<div class="main-body">
    <div class="page-wrapper">

        <div class="table-responsive">
            <h4>Subscriptions</h4>
            <form action="{{ route('admin.admin.subscriptions.sendBulkEmail') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="message_content">Bulk Email Message</label>
                    <textarea id="message_content" name="message_content" class="form-control" rows="4" placeholder="Enter message to send to all subscribers" required></textarea>
                    <div class="invalid-feedback">
                        Please provide a message for the bulk email.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Send Bulk Email</button>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Subscribed Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->email }}</td>
                            <td>{{ $subscription->created_at->diffForHumans() }}</td>
                            <td>
                                <!-- Delete Button -->
                                <form action="{{ route('admin.admin.subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $subscriptions->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
