<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 600px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/institution/department/<?= $course['department_id'] ?>" class="btn btn-outline">&larr;
            Cancel</a>
    </div>

    <h1>Edit Course</h1>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <form action="<?= APP_URL ?>/institution/course/update" method="POST">
    <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $course['id'] ?>">

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Department</label>
                <select name="department_id" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= $d['id'] ?>" <?= $d['id'] == $course['department_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Course Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Code</label>
                <input type="text" name="code" value="<?= htmlspecialchars($course['code']) ?>" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Level</label>
                <select name="level" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="Level 6 (Diploma)" <?= $course['level'] == 'Level 6 (Diploma)' ? 'selected' : '' ?>
                        >Diploma (Level 6)</option>
                    <option value="Level 5 (Certificate)" <?= $course['level'] == 'Level 5 (Certificate)' ? 'selected' : '' ?>>Certificate (Level 5)</option>
                    <option value="Level 4 (Artisan)" <?= $course['level'] == 'Level 4 (Artisan)' ? 'selected' : '' ?>
                        >Artisan (Level 4)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Update Course</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>