<section class="card p-4">
    <div class="card-body">
        <h5 class="card-title">Update Password</h5>
        <p class="text-muted">Ensure your account is using a long, random password to stay secure.</p>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control" autocomplete="current-password">
                @error('updatePassword.current_password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                @error('updatePassword.password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                @error('updatePassword.password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
                @if (session('status') === 'password-updated')
                    <p class="text-success small mt-2">Saved.</p>
                @endif
            </div>
        </form>
    </div>
</section>
