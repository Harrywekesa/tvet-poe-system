<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/academic/class/<?= $class['id'] ?>" class="btn btn-outline">&larr; Back to Class</a>
    </div>

    <h1>Professional Documents</h1>
    <p class="text-secondary">
        Class: <strong><?= htmlspecialchars($class['class_code']) ?></strong> | 
        Unit: <strong><?= htmlspecialchars($unit['unit_title']) ?></strong>
    </p>

    <!-- Upload Form -->
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Upload New Document</h3>
        <form action="<?= APP_URL ?>/documents/store" method="POST" enctype="multipart/form-data" class="form-grid-3" style="margin-top: 15px;">
            <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
            <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
            
            <div>
                <label style="display: block; margin-bottom: 5px;">Document Type</label>
                <select name="type" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="Course Outline">Course Outline</option>
                    <option value="Class Attendance">Class Attendance</option>
                    <option value="Marksheet">Marksheet</option>
                    <option value="Curriculum">Curriculum</option>
                    <option value="PC Weighting">PC Weighting</option>
                    <option value="Occupational Standards">Occupational Standards</option>
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 5px;">File (PDF, Docx, Images)</label>
                <input type="file" name="doc_file" required accept=".pdf,.doc,.docx,.jpg,.png" style="width: 100%; padding: 5px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <!-- History -->
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Upload History</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="background: #f8fafc; text-align: left;">
                    <th style="padding: 10px;">Type</th>
                    <th style="padding: 10px;">Date</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px;">Comments</th>
                    <th style="padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($docs as $d): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 500;"><?= htmlspecialchars($d['type']) ?></td>
                    <td style="padding: 10px; color: #64748b; font-size: 0.9rem;"><?= $d['created_at'] ?></td>
                    <td style="padding: 10px;">
                        <?php 
                            $color = $d['status'] === 'Approved' ? 'green' : ($d['status'] === 'Rejected' ? 'red' : 'orange');
                        ?>
                        <span style="color: <?= $color ?>; font-weight: 600;"><?= $d['status'] ?></span>
                    </td>
                    <td style="padding: 10px; font-style: italic; color: #475569;"><?= htmlspecialchars($d['comments'] ?? '-') ?></td>
                    <td style="padding: 10px;">
                        <a href="<?= APP_URL ?>/preview/download?file=docs/<?= $d['file_path'] ?>" target="_blank" style="color: #2563eb;">Download</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($docs)): ?>
                    <tr><td colspan="5" style="padding: 20px; text-align: center; color: #94a3b8;">No documents uploaded yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
