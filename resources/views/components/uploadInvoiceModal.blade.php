<!-- Modal Ajouter une Facture -->
<div class="modal fade" id="uploadInvoiceModal" tabindex="-1" aria-labelledby="uploadInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="upload-invoice-form" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadInvoiceModalLabel">Ajouter une facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Carte bancaire</label>
                    <select name="card_id" class="form-select" required>
                        @foreach(\App\Models\Card::all() as $card)
                            <option value="{{ $card->id }}">{{ $card->name }} ({{ $card->last_digits }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fichier PDF</label>
                    <input type="file" name="invoice_file" class="form-control" accept=".pdf" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catégories détectées</label>
                    <div id="categories-table-container" class="table-responsive d-none">
                        <table class="table table-sm table-bordered">
                            <small class="text-muted">Vous pouvez modifier les catégories ou les montants si nécessaire.</small>
                            <thead>
                                <tr>
                                    <th>Catégorie</th>
                                    <th>Montant (€)</th>
                                </tr>
                            </thead>
                            <tbody id="categories-table-body">
                                <!-- rempli dynamiquement -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de facture détectée</label>
                        <input type="text" id="invoice-date" name="invoice_date" class="form-control" readonly placeholder="Non détectée">
                    </div>
                    <p id="no-categories" class="text-muted">Non analysée</p>
                </div>

                <button type="button" class="btn btn-secondary w-100" id="analyze-btn" disabled>Analyser la facture</button>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="validate-btn" disabled>Valider</button>
            </div>
        </form>
    </div>
</div>