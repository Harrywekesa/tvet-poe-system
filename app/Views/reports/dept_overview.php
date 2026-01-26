<?php require_once __DIR__ . '/../partials/header.php'; ?>
<style>
    @media print {

        header,
        nav,
        .btn,
        .no-print {
            display: none !important;
        }

        body {
            background: white;
            color: black;
        }

        .container {
            max-width: 100%;
            margin: 0;
            padding: 0;
            border: none;
        }
    }
</style>

<div class="container" style="margin-top: 40px;">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print Report</button>
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline" style="margin-left: 10px;">Back</a>
    </div>

    <h1>
        <?= $title ?>
    </h1>
    <p>Generated:
        <?= date('d M Y H:i') ?>
    </p>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #000;">
                    <th style="padding: 10px; text-align: left;">Class</th>
                    <th style="padding: 10px; text-align: left;">Unit Code</th>
                    <th style="padding: 10px; text-align: left;">Unit Title</th>
                    <th style="padding: 10px; text-align: left;">Trainer</th>
                    <th style="padding: 10px; text-align: center;">✅ Approved</th>
                    <th style="padding: 10px; text-align: center;">❌ Rejected</th>
                    <th style="padding: 10px; text-align: center;">⏳ Pending</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr style="border-bottom: 1px solid #ccc;">
                        <td style="padding: 10px; font-weight: bold;">
                            <?= htmlspecialchars($row['class_code']) ?>
                        </td>
                        <td style="padding: 10px;">
                            <?= htmlspecialchars($row['unit_code']) ?>
                        </td>
                        <td style="padding: 10px;">
                            <?= htmlspecialchars($row['unit_title']) ?>
                        </td>
                        <td style="padding: 10px;">
                            <?= htmlspecialchars($row['trainer_name']) ?>
                        </td>
                        <td style="padding: 10px; text-align: center; color: green; font-weight: bold;">
                            <?= $row['approved_count'] ?>
                        </td>
                        <td style="padding: 10px; text-align: center; color: red;">
                            <?= $row['rejected_count'] ?>
                        </td>
                        <td style="padding: 10px; text-align: center; color: orange;">
                            <?= $row['pending_count'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="7" style="padding: 20px; text-align: center;">No data found for this department.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 50px;">
        <p><strong>Head of Department Signature:</strong> __________________________________________</p>
        <p><strong>Date:</strong> ______________________</p>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>