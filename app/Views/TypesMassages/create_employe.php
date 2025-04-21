<!DOCTYPE html>
<html>
<head>
    <title>Création Compte Employé</title>
</head>
<body>
    <div class="conteneur">
        <h2>Création d'un compte employé</h2>
        
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?= base_url('employee/create') ?>" method="POST">
                    <div>
                        <label for="nom_utilisateur">Nom d'utilisateur :</label>
                        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
                    </div>

                    <div>
                        <label for="mot_de_passe">Mot de passe :</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    </div>

                    <div>
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div>
                        <label for="type_employe">Type d'employé :</label>
                        <select id="type_employe" name="type_employe" required>
                            <option value="2">Masseur/Masseuse</option>
                        </select>
                    </div>

                    <input type="hidden" name="role" value="2">
                    
                    <div>
                        <button type="submit" class="btn btn-primary">Créer le compte employé</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>