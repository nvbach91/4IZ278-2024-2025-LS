<h5 class="mt-4">Concept(s)</h5>
<table class="table table-bordered align-middle mt-2">
    <thead class="table-light">
        <tr>
            <th>Concept</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($concepts as $concept): ?>
            <tr>
                <td><?php echo htmlspecialchars($concept['name']); ?></td>
                <td><?php echo htmlspecialchars($concept['description']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>