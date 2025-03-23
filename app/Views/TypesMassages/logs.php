  <div class="conteneur">
      <h2>Logs système</h2>

      <div class="card mb-4">
          <div class="card-body">
              <form id="filterForm">
                  <div>
                      <label>Table</label>
                      <select name="table" id="table">
                          <option value="">Toutes</option>
                          <option value="clients">Clients</option>
                          <option value="comptes_utilisateurs">Comptes utilisateurs</option>
                          <option value="employe">Employés</option>
                          <option value="reservations">Réservations</option>
                          <option value="Salle">Salles</option>
                          <option value="types_massages">Types de massages</option>
                          <option value="panier">Panier</option>
                      </select>
                  </div>
                  <div>
                      <label>Action</label>
                      <select name="action" id="action">
                          <option value="">Toutes</option>
                          <option value="INSERT">Création</option>
                          <option value="UPDATE">Modification</option>
                          <option value="DELETE">Suppression</option>
                      </select>
                  </div>
                  <div>
                      <button type="submit" class="btn btn-primary">Filtrer</button>
                      <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                  </div>
              </form>
          </div>
      </div>

      <div class="table-responsive">
          <table class="table">
              <thead>
                  <tr>
                      <th></th>
                      <th>Table</th>
                      <th>Action</th>
                      <th>Description</th>
                      <th>Date</th>
                  </tr>
              </thead>
              <tbody id="logsTable">
                  <?php foreach ($logs as $log): ?>
                      <tr>
                          <td><?= $log['id_log'] ?? '' ?></td>
                          <td><span class="badge bg-secondary"><?= $log['table_name'] ?></span></td>
                          <td>
                              <?php
                              $actionClass = '';
                              switch($log['action']) {
                                  case 'INSERT':
                                      $actionClass = 'bg-success';
                                      break;
                                  case 'UPDATE':
                                      $actionClass = 'bg-warning';
                                      break;
                                  case 'DELETE':
                                      $actionClass = 'bg-danger';
                                      break;
                              }
                              ?>
                              <span class="badge <?= $actionClass ?>"><?= $log['action'] ?></span>
                          </td>
                          <td><?= $log['description'] ?></td>
                          <td><?= date('d/m/Y H:i:s', strtotime($log['date_log'])) ?></td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
          <?php if (empty($logs)): ?>
              <div class="alert-info">
                  Aucun log trouvé pour ces critères
              </div>
          <?php endif; ?>
      </div>
  </div>