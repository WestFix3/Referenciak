<x-guest-layout>
    <x-slot name="title">Új dolgozó</x-slot>
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3">
            <label for="name" class="form-label" style="color: white;">Név</label>
            <input type="text" class="form-control" id="name" name="name" required style="color: black;">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label" style="color: white;">Email</label>
            <input type="email" class="form-control" id="email" name="email" required style="color: black;">
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label" style="color: white;">Telefonszám</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required style="color: black;">
        </div>
        <div class="mb-3">
            <label for="card_number" class="form-label" style="color: white;">Kártyaszám</label>
            <input type="text" class="form-control" id="card_number" name="card_number" required style="color: black;">
        </div>
        <div class="mb-3">
            <label for="position_id" class="form-label" style="color: white;">Pozíció ID</label>
            <input type="text" class="form-control" id="position_id" name="position_id" required style="color: black;">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label" style="color: white;">Jelszó</label>
            <input type="password" class="form-control" id="password" name="password" required style="color: black;">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label" style="color: white;">Jelszó megerősítés</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required style="color: black;">
        </div>
        <div class="mb-3">
            <label for="admin" class="form-label" style="color: white;">Adminisztrátor?</label>
            <input type="checkbox" class="form-check-input" id="admin" name="admin">
        </div>

        <button type="submit" class="btn btn-success">Mentés</button>
    </form>
</x-guest-layout>
