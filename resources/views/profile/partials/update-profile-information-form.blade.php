<section class="card p-4">
    <div class="card-body">
        <h5 class="card-title">Profile Information</h5>
        <p class="text-muted">Update your account's profile information and email address.</p>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mb-3">
                    <p class="text-warning small">
                        Your email address is unverified. 
                        <button form="send-verification" class="btn btn-link p-0">Click here to resend verification.</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small">A new verification link has been sent to your email address.</p>
                    @endif
                </div>
            @endif

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</section>
