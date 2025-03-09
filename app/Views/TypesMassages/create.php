<h2>Ajouter un Type de Massage</h2>

<?= form_open('TypesMassages/create', ['class' => 'fade-in']) ?>
    <label for="nom_type">Nom du type de massage:</label>
    <input type="text" name="nom_type" value="<?= esc(old('nom_type')) ?>" required>
    
    <label for="description">Description:</label>
    <textarea name="description" required><?= esc(old('description')) ?></textarea>
    
    <label for="prix">Prix:</label>
    <input type="number" step="0.01" name="prix" value="<?= esc(old('prix')) ?>" required>
    
    <button type="submit" class="btn">Ajouter</button>
<?= form_close() ?>
