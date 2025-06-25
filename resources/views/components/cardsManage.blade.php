<div class="modal fade" id="manageCardsModal" tabindex="-1" aria-labelledby="manageCardsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageCardsModalLabel">Gérer les cartes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Numéro partiel</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cards as $card)
                            <tr>
                                <td>{{ $card->name }}</td>
                                <td>{{ $card->last_digits }}</td>
                                <td>
                                    <form method="POST" action="{{ route('cards.destroy', $card) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette carte ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Ligne de création -->
                        <tr>
                            <form method="POST" action="{{ route('cards.store') }}">
                                @csrf
                                <td><input type="text" name="name" class="form-control" placeholder="Nom" required></td>
                                <td><input type="text" name="last_digits" class="form-control" placeholder="XXXX" required></td>
                                <td><button type="submit" class="btn btn-success btn-sm">Créer</button></td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>