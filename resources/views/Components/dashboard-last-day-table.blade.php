<div class="mb-3 col-xl-6 col-md-12">
    <div class="card">
        <h5 class="card-header"><?php echo $league; ?>. Bundesliga - <?php echo $days[$league]-1; ?>. Spieltag Ergebnisse</h5>
        <div class="card-body">
            <?php if ($finished[$league]["hasFinished"] == 0) echo '<h5 class="card-title text-danger">Achtung, es sind noch nicht alle Ergebnisse da. Es fehlen noch '.$finished[$league]["missing"].' Spielergebnisse.</h5>'; ?>
            <p class="card-text">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Name</th>
                    <th>Richtig</th>
                    <th>Falsch</th>
                    <th>Zu Behzahlen</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $platz = 1;
                foreach($leagueResult as $userResult) {
                    echo "<tr>\n";

                    echo '<th scope="row">'. $platz ."</th>\n";
                    echo "<td>". $userResult["name"] ."</td>\n";
                    echo "<td>". $userResult["right"] ."</td>\n";
                    echo "<td>". $userResult["wrong"] ."</td>\n";
                    echo "<td>". number_format($userResult["toPay"], 2, ",", ".") ." €</td>\n";

                    echo "</tr>\n\n";
                    $platz++;
                }
                ?>
                </tbody>
            </table>
            </p>
        </div>
    </div>
</div>
