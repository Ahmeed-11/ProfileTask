<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Profile Image -->
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('storage/profile_images/' . $profile->image) }}" alt="Profile Image"
                                class="img-fluid rounded-circle mb-3">
                            <ul class="list-unstyled">
                                <li><strong>{{ $profile->name }}</strong></li>
                                <li>{{ $profile->email }}</li>
                            </ul>
                        </div>

                        <!-- Profile Form -->
                        <div class="col-md-8">
                            <form wire:submit='update'>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Enter your name" wire:model='name'>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email"
                                        placeholder="Enter your email" wire:model='email'>
                                </div>
                                <div class="mb-3">
                                    <label for="profile-image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="profile-image" wire:model='image'>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
