<?php
// manage-jobs.php
include 'includes/db.php';
$jobs = $conn->query("SELECT * FROM jobs ORDER BY created_at DESC");
?>
<h2>Manage Jobs</h2>
<a href="add-job.php">+ Add Job</a>
<table>
<tr><th>Title</th><th>Company</th><th>Actions</th></tr>
<?php while($row = $jobs->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= htmlspecialchars($row['company']) ?></td>
<td>
<a href="edit-job.php?id=<?= $row['id'] ?>">Edit</a> |
<a href="delete-job.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this job?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<?php
// add-job.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php';
    $stmt = $conn->prepare("INSERT INTO jobs (title, company, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['title'], $_POST['company'], $_POST['description']);
    $stmt->execute();
    header("Location: manage-jobs.php");
    exit();
}
?>
<form method="post">
<input name="title" placeholder="Job Title" required>
<input name="company" placeholder="Company" required>
<textarea name="description" placeholder="Description"></textarea>
<button type="submit">Add Job</button>
</form>

<?php
// edit-job.php
include 'includes/db.php';
$id = $_GET['id'];
$job = $conn->query("SELECT * FROM jobs WHERE id = $id")->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE jobs SET title=?, company=?, description=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['title'], $_POST['company'], $_POST['description'], $id);
    $stmt->execute();
    header("Location: manage-jobs.php");
    exit();
}
?>
<form method="post">
<input name="title" value="<?= htmlspecialchars($job['title']) ?>" required>
<input name="company" value="<?= htmlspecialchars($job['company']) ?>" required>
<textarea name="description"><?= htmlspecialchars($job['description']) ?></textarea>
<button type="submit">Update Job</button>
</form>

<?php
// delete-job.php
include 'includes/db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM jobs WHERE id = $id");
header("Location: manage-jobs.php");
exit();
?>

<?php
// manage-scholarships.php
include 'includes/db.php';
scholarships = $conn->query("SELECT * FROM scholarships ORDER BY created_at DESC");
?>
<h2>Manage Scholarships</h2>
<table>
<tr><th>Title</th><th>Institution</th><th>Actions</th></tr>
<?php while($row = $scholarships->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= htmlspecialchars($row['institution']) ?></td>
<td>
<a href="edit-scholarship.php?id=<?= $row['id'] ?>">Edit</a> |
<a href="delete-scholarship.php?id=<?= $row['id'] ?>">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<?php
// manage-internships.php
include 'includes/db.php';
internships = $conn->query("SELECT * FROM internships ORDER BY created_at DESC");
?>
<h2>Manage Internships</h2>
<table>
<tr><th>Title</th><th>Organization</th><th>Actions</th></tr>
<?php while($row = $internships->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= htmlspecialchars($row['organization']) ?></td>
<td>
<a href="edit-internship.php?id=<?= $row['id'] ?>">Edit</a> |
<a href="delete-internship.php?id=<?= $row['id'] ?>">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<?php
// manage-users.php
include 'includes/db.php';
$users = $conn->query("SELECT * FROM users");
?>
<h2>Manage Users</h2>
<table>
<tr><th>Name</th><th>Email</th><th>Actions</th></tr>
<?php while($row = $users->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><a href="delete-user.php?id=<?= $row['id'] ?>">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>

<?php
// upload-handler.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['banner'])) {
    $targetDir = 'uploads/banners/';
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $ext = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('banner_') . '.' . strtolower($ext);
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile)) {
        echo "Uploaded successfully: $filename";
    } else {
        echo "Upload failed.";
    }
}
?>

/* style.css */
body {
  font-family: Arial, sans-serif;
  background: #f4f4f4;
  margin: 0;
  padding: 0;
}
table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  margin-top: 20px;
}
th, td {
  padding: 10px;
  border: 1px solid #ccc;
}
a {
  text-decoration: none;
  color: blue;
}
form input, form textarea {
  display: block;
  width: 100%;
  margin: 10px 0;
  padding: 8px;
}
