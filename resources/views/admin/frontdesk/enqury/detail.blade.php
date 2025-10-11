@extends('admin.layouts.master')

@section('title', 'Inquiry Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Inquiry Details</h5>
                </div>
                <div class="card-body">
                    <!-- Inquiry Details -->
                    <div class="mb-4">
                        <strong>Name:</strong> {{ $inquiry->name }} <br>
                        <strong>Email:</strong> {{ $inquiry->email }} <br>
                        <strong>Phone:</strong> {{ $inquiry->phone }} <br>
                        <strong>Message:</strong> <pre>{{ $inquiry->message }}</pre> <br>
                        <strong>Date:</strong> {{ $inquiry->created_at->diffForHumans() }} <br>
                    </div>

                    <!-- Reply Form -->
                    <h5 class="mt-4">Reply to Inquiry</h5>
                    <form action="{{ route('admin.admin.inquiry.reply', $inquiry->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="replyMessage">Your Reply:</label>
                            <textarea class="form-control" id="replyMessage" name="reply_message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </form>

                    <!-- Send WhatsApp Link -->
                    <h5 class="mt-4">Send WhatsApp Message</h5>
                    <p>If you want to message this user on WhatsApp, click below to open WhatsApp.</p>
                    <a href="https://wa.me/{{ '254' . substr($inquiry->phone, -9) }}" class="btn btn-success" target="_blank">
                        Send WhatsApp Message
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
