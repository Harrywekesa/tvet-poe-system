<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 600px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/institution/course/<?= $unit['course_id'] ?>" class="btn btn-outline">&larr; Cancel</a>
    </div>

    <h1>Edit Unit</h1>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <form action="<?= APP_URL ?>/institution/unit/update" method="POST">
    <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $unit['id'] ?>">
            <input type="hidden" name="course_id" value="<?= $unit['course_id'] ?>">

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Unit Code</label>
                <input type="text" name="unit_code" value="<?= htmlspecialchars($unit['unit_code']) ?>" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Unit Title</label>
                <input type="text" name="unit_title" value="<?= htmlspecialchars($unit['unit_title']) ?>" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Category</label>
                <select name="category"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="Basic" <?= $unit['category'] == 'Basic' ? 'selected' : '' ?>>Basic</option>
                    <option value="Common" <?= $unit['category'] == 'Common' ? 'selected' : '' ?>>Common</option>
                    <option value="Core" <?= $unit['category'] == 'Core' ? 'selected' : '' ?>>Core</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Description</label>
                <textarea name="description"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;"><?= htmlspecialchars($unit['description']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Update Unit</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>