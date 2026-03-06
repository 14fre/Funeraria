<x-form-section submit="updateProfileInformation">
    <x-slot name="title">Datos del perfil</x-slot>
    <x-slot name="description">Nombre, correo y foto.</x-slot>

    <x-slot name="form">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />
                <x-label for="photo" value="Foto" />
                @php
                    $photoUrl = $this->user->profile_photo_path
                        ? asset('storage/' . $this->user->profile_photo_path) . '?v=' . ($this->user->updated_at?->timestamp ?? time())
                        : $this->user->profile_photo_url;
                    $photoFallback = 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&color=5C0E2B&background=EBF4FF';
                @endphp
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $photoUrl }}" alt="{{ $this->user->name }}" class="rounded-full size-20 object-cover bg-gray-200"
                         onerror="this.onerror=null; this.src='{{ $photoFallback }}';" loading="lazy">
                </div>
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                </div>
                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    Cambiar foto
                </x-secondary-button>
                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">Quitar foto</x-secondary-button>
                @endif
                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="Nombre" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="Correo electrónico" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-gray-600">
                    Correo sin verificar.
                    <button type="button" class="underline text-[#5C0E2B] hover:text-[#7a1a3d]" wire:click.prevent="sendEmailVerification">Reenviar enlace</button>
                </p>
                @if ($this->verificationLinkSent)
                    <p class="mt-2 text-sm text-green-600">Enlace enviado a tu correo.</p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">Guardado.</x-action-message>
        <x-button wire:loading.attr="disabled" wire:target="photo">Guardar</x-button>
    </x-slot>
</x-form-section>
