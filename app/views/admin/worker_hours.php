<h1 class="mb-4">Dolgozó munkaidő beállítása</h1>

<div class="card shadow-sm">
    <div class="card-body">

        <form method="post" action="?c=admin&m=saveWorkerHours&workerId=<?= $workerId ?>">

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nap</th>
                        <th>Kezdés</th>
                        <th>Befejezés</th>
                        <th>OFF</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($days as $dayNumber => $dayName): ?>

                        <?php
                            // Ha van munkaidő erre a napra
                            $start = $hours[$dayNumber]['start'] ?? '';
                            $end   = $hours[$dayNumber]['end'] ?? '';
                            $isOff = empty($start) || empty($end);
                        ?>

                        <tr>
                            <td><strong><?= $dayName ?></strong></td>

                            <td>
                                <input type="time"
                                       name="day[<?= $dayNumber ?>][start]"
                                       class="form-control"
                                       value="<?= $isOff ? '' : $start ?>"
                                       <?= $isOff ? 'disabled' : '' ?>>
                            </td>

                            <td>
                                <input type="time"
                                       name="day[<?= $dayNumber ?>][end]"
                                       class="form-control"
                                       value="<?= $isOff ? '' : $end ?>"
                                       <?= $isOff ? 'disabled' : '' ?>>
                            </td>

                            <td class="text-center">
                                <input type="checkbox"
                                       name="day[<?= $dayNumber ?>][off]"
                                       class="form-check-input off-toggle"
                                       data-day="<?= $dayNumber ?>"
                                       <?= $isOff ? 'checked' : '' ?>>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">
                Mentés
            </button>

        </form>

    </div>
</div>

<script>
    // OFF checkbox → tiltja/engedi az idő inputokat
    document.querySelectorAll('.off-toggle').forEach(cb => {
        cb.addEventListener('change', function () {
            const day = this.dataset.day;

            const start = document.querySelector(`input[name="day[${day}][start]"]`);
            const end   = document.querySelector(`input[name="day[${day}][end]"]`);

            if (this.checked) {
                start.disabled = true;
                end.disabled = true;
                start.value = '';
                end.value = '';
            } else {
                start.disabled = false;
                end.disabled = false;
            }
        });
    });
</script>
