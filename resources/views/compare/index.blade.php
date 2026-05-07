@extends('layouts.app')

@section('title', 'Comparador de Jugadores - NBA Simulator')

@section('styles')
<style>
    .player-card-select {
        background: #1a1a2e;
        border: 2px solid #2a2a4a;
        border-radius: 12px;
        transition: border-color 0.2s;
        cursor: pointer;
    }
    .player-card-select:hover {
        border-color: #f8c200;
    }
    .avatar-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #f8c200;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: bold;
        color: #000;
        margin: 0 auto;
    }
    .select-dark option {
        background: #1a1a2e;
        color: #fff;
    }
</style>
@endsection

@section('content')

<div class="text-center mb-5">
    <h2 class="text-warning fw-bold">
        <i class="bi bi-arrows-angle-expand me-2"></i>Comparador de Jugadores
    </h2>
    <p class="text-secondary">Selecciona dos jugadores y compara sus estadísticas cara a cara.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card p-4 mb-4">
            <form method="POST" action="{{ route('compare.compare') }}">
                @csrf

                @error('player1_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('player2_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="row align-items-center g-4">

                    {{-- Jugador 1 --}}
                    <div class="col-md-5 text-center">
                        <label class="form-label text-warning fw-bold d-block mb-3">
                            <i class="bi bi-person-fill me-1"></i> Jugador 1
                        </label>
                        <div style="height:80px;" class="d-flex align-items-center justify-content-center mb-3">
                            <div id="avatar1" class="avatar-circle" style="display:none!important;">
                                <span id="avatar1-text"></span>
                            </div>
                            <i id="placeholder1" class="bi bi-person-circle fs-1 text-warning opacity-25"></i>
                        </div>
                        <select name="player1_id" id="player1_id"
                                class="form-select bg-dark text-white border-warning select-dark"
                                required>
                            <option value="">Selecciona jugador...</option>
                            @foreach($players as $player)
                                <option value="{{ $player->id }}"
                                        data-name="{{ $player->full_name }}"
                                        data-initial="{{ strtoupper(substr($player->first_name, 0, 1)) }}"
                                        {{ old('player1_id') == $player->id ? 'selected' : '' }}>
                                    {{ $player->full_name }}
                                    @if($player->team) ({{ $player->team->abbreviation }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <div id="player1-info" class="mt-2 small text-secondary" style="display:none;">
                            <span id="player1-team"></span>
                        </div>
                    </div>

                    {{-- VS --}}
                    <div class="col-md-2 text-center">
                        <div style="background:#f8c200;color:#000;font-weight:bold;border-radius:50%;
                                    width:50px;height:50px;display:flex;align-items:center;
                                    justify-content:center;margin:0 auto;font-size:0.9rem;">
                            VS
                        </div>
                    </div>

                    {{-- Jugador 2 --}}
                    <div class="col-md-5 text-center">
                        <label class="form-label text-info fw-bold d-block mb-3">
                            <i class="bi bi-person-fill me-1"></i> Jugador 2
                        </label>
                        <div style="height:80px;" class="d-flex align-items-center justify-content-center mb-3">
                            <div id="avatar2" class="avatar-circle"
                                 style="display:none!important;background:#0dcaf0;">
                                <span id="avatar2-text"></span>
                            </div>
                            <i id="placeholder2" class="bi bi-person-circle fs-1 text-info opacity-25"></i>
                        </div>
                        <select name="player2_id" id="player2_id"
                                class="form-select bg-dark text-white border-info select-dark"
                                required>
                            <option value="">Selecciona jugador...</option>
                            @foreach($players as $player)
                                <option value="{{ $player->id }}"
                                        data-name="{{ $player->full_name }}"
                                        data-initial="{{ strtoupper(substr($player->first_name, 0, 1)) }}"
                                        {{ old('player2_id') == $player->id ? 'selected' : '' }}>
                                    {{ $player->full_name }}
                                    @if($player->team) ({{ $player->team->abbreviation }}) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-nba btn-lg px-5">
                        <i class="bi bi-bar-chart-fill me-2"></i>Comparar jugadores
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateAvatar(selectId, avatarId, avatarTextId, placeholderId) {
        const select      = document.getElementById(selectId);
        const avatar      = document.getElementById(avatarId);
        const avatarText  = document.getElementById(avatarTextId);
        const placeholder = document.getElementById(placeholderId);
        const option      = select.options[select.selectedIndex];

        if (select.value !== '') {
            avatarText.textContent    = option.getAttribute('data-initial');
            avatar.style.display      = 'flex';
            placeholder.style.display = 'none';
        } else {
            avatar.style.display      = 'none';
            placeholder.style.display = 'inline';
        }
    }

    document.getElementById('player1_id').addEventListener('change', function() {
        updateAvatar('player1_id', 'avatar1', 'avatar1-text', 'placeholder1');
    });

    document.getElementById('player2_id').addEventListener('change', function() {
        updateAvatar('player2_id', 'avatar2', 'avatar2-text', 'placeholder2');
    });
</script>
@endsection