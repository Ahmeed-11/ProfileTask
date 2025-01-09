<div style="display: flex; justify-content:space-around">
    <div class="right">

        {{-- form using livewire --}}
        <form wire:submit='update'>
            <h2>Edit Profile</h2>

            <input type="text" wire:model='name'><br><br>
            <input type="email" wire:model='email'><br><br>
            <input type="file" wire:model='image'><br><br>
            <input type="submit" value="Update"><br><br>
        </form>

    </div>


    <div class="left">

         {{-- show profile details if exist --}}
        @if ($profile)
            <img style="border-radius:25%; width:250px;"
                src="{{ asset('storage/profile_images/' . $profile->image) }}">
            <li>{{ $profile->name }}</li>
            <li> {{ $profile->email }}</li>
        @endif


    </div>
</div>
