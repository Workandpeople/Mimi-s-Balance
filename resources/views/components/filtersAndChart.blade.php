<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">Analyse des dépenses</h2>
        <div>
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#manageCardsModal">
                Gérer les cartes
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadInvoiceModal">
                + Ajouter une facture
            </button>
        </div>
    </div>

    <form id="filters-form" class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label">Carte bancaire</label>
            <select class="form-select" name="card_id" id="card_id">
                <option value="">Toutes</option>
                @foreach(\App\Models\Card::all() as $card)
                    <option value="{{ $card->id }}">{{ $card->name }} ({{ $card->last_digits }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Date de début</label>
            <input type="date" name="date_from" id="date_from" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date de fin</label>
            <input type="date" name="date_to" id="date_to" class="form-control">
        </div>
    </form>

    <div class="d-flex justify-content-center">
        <div style="width: 300px;">
            <canvas id="expenses-chart"></canvas>
        </div>
    </div>

    <div class="container py-5">
    <h3 class="mb-3 text-center">Évolution mensuelle des dépenses</h3>

        <div class="row justify-content-center mb-3">
            <div class="col-auto">
                <select id="year-select" class="form-select">
                    @for ($year = now()->year; $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <canvas id="monthly-expenses-chart" height="200"></canvas>
    </div>
</div>